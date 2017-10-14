<?php

Yii::import('application.models.forms.fixPay.ProcessLocationForm');

class FixPayController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
        
        const PROCESS_NONE = 0;
        const PROCESS_FAIL = 1;
        const PROCESS_SUCESS = 2;
        const PROCESS_CANT_EXECUTE = 3;
        
        /**
         * 
         */
        public function actionIndex(){
            $this->render('index',array(
            ));   
        }
        
        
        /**
         * 
         */
        public function actionProcessLocation(){
          
            $model = new ProcessLocationForm();
            $person = null;
            $location = null;
            $operation = "";
            $feeds_not_bind_count = 0; 
            $feeds_bind_count  = 0;
            $feeds_bind_others = 0;
            $process_result = self::PROCESS_NONE;
            $show_process_result = false;
            
            $dbCriteria = new CDbCriteria();
            $dbCriteria->condition = "status <> :status";
            $dbCriteria->params = array(":status"=>"V");
            $dbCriteria->order = " code ASC ";
            $locations = Location::model()->findAll($dbCriteria);
            
            $output = "";
            $persons = array();
            
            if (Yii::app()->request->isPostRequest && $_POST['ProcessLocationForm']) {
                
                $operation = $_POST["operation"];
                
                $model->attributes = $_POST['ProcessLocationForm'];

                $owners = Owner::model()->findAll("location_id = :location_id",array(":location_id"=>$model->location_id));
                $person_id_list = array();
                /* @var $owner Owner */
                foreach($owners as $owner){
                    $person_id_list[] = $owner->person_id;
                }
                
                $persons = Person::model()->findAllByAttributes( array("id"=>$person_id_list) );
                
                $dbCriteria = new CDbCriteria();
                $dbCriteria->condition = "person_id = :person_id";
                $dbCriteria->params = array(":person_id"=> $model->person_id);
                $dbCriteria->order = " pay_date DESC ";
                $pay = Pay::model()->find($dbCriteria);
                if( !is_null($pay) ){
                    $model->last_pay_id = $pay->id;
                }
                
                switch($operation){
                    case "process-bind-fee-to-pay":
                        
                        $show_process_result = true;
                        $process_result = $this->processLocationWithPay($model->last_pay_id);

                        break;
                    case "clear-all":
                        
                        $model = new ProcessLocationForm();
                        $persons = array();

                        break;
                        
                }   
                
                if(!is_null($model->location_id) && $operation != "clear-all"  )
                {
                    $location = Location::model()->findByPk( $model->location_id );
                }
                
                if(!is_null($model->person_id) && $operation != "clear-all"  ){
                    
                    $conn = Yii::app()->db;
                    
                    $person = Person::model()->findByPk( $model->person_id );

                    $command = $conn->createCommand();
                    $command->text = "SELECT COUNT(fp.fee_id)
                                        FROM mip_fee_pay fp
                                            INNER JOIN mip_pay p 
                                               ON ( fp.pay_id = p.id )
                                        WHERE fp.location_id = :location_id AND p.person_id = :person_id";
                    $command->params = array(":location_id"=> $model->location_id, ":person_id" => $model->person_id );
                    $feeds_bind_count = $command->queryScalar();
                    
                    $command = $conn->createCommand();
                    $command->text = "SELECT COUNT(fp.fee_id)
                                        FROM mip_fee_pay fp
                                            INNER JOIN mip_pay p 
                                               ON ( fp.pay_id = p.id )
                                        WHERE fp.location_id = :location_id ";
                    $command->params = array(":location_id"=> $model->location_id );
                    $feeds_bind_count_all = $command->queryScalar();
                    
   
                    $fee_count = Fee::model()->count();
                     
                    
                    $feeds_not_bind_count = $fee_count - $feeds_bind_count_all;
                    
                    $feeds_bind_others = $feeds_bind_count_all - $feeds_bind_count;
                    
                }

            }
            
            
            $this->render('process_location_form',array(
                "model" => $model,
                "locations" => $locations,
                "persons" => $persons,
                "person" => $person,
                "location" => $location,
                "feeds_bind_count" => $feeds_bind_count,
                "feeds_not_bind_count" => $feeds_not_bind_count,
                "feeds_bind_others" => $feeds_bind_others,
                "process_result" => $process_result,
                "show_process_result" => $show_process_result,
            ));   
        }
        

	/**
         * 
         * @param type $pay_id
         */
	public function processLocationOrPay($pay_id=null, $location_id=null){
            
            if( !is_null($pay_id) )
            {
                return $this->processLocationWithPay($pay_id);
            }
            else if( !is_null($location_id) ){
                
                $owners = Owner::model()->findAll("location_id = :location_id", array(":location_id"=>$location_id));
                if(count($owners) == 1 ){
                    
                    $owner = $owners[0];

                    $dbCriteria = new CDbCriteria();
                    $dbCriteria->condition = " person_id = :person_id ";
                    $dbCriteria->params = array(":person_id" => $owner->person_id );
                    $dbCriteria->order = " pay_date DESC ";
                    $pay = Pay::model()->find($dbCriteria);
                    if(!is_null($pay))
                    {
                        return $this->processLocationWithPay($pay->id);
                    }
                }
                else if( count($owners) == 0 ){
                    $this->launchExceptionThatFixWithWithoutOwner();
                }
                else{
                    $this->launchExceptionThatFixWithOneOwner($owners);
                }
                
            }
            else{
                return self::PROCESS_CANT_EXECUTE;
            }
        }
        
        /**
         * 
         * @param type $pay_id
         * @param type $location_id
         */
        private function processLocationWithPay($pay_id=null){
            
            $pay = Pay::model()->findByPk($pay_id);
            
            if(!is_null($pay))
            {
                $person = Person::model()->findByPk($pay->person_id);

                $owners = Owner::model()->findAll("person_id = :person_id",array(":person_id"=>$person->id));

                if( count($owners) == 1 ){

                    /**
                     * @var Owner $owner
                     */
                    $owner =  $owners[0];

                    $location_id = $owner->location_id;

                    $dbCriteria = new CDbCriteria();
                    $dbCriteria->condition = " pay_date <= :pay_date AND person_id = :person_id ";
                    $dbCriteria->params = array(":pay_date"=> MipHelper::parseDateToDb($pay->pay_date) , ":person_id" => $pay->person_id );
                    $dbCriteria->order = " pay_date ASC ";

                    $payList = Pay::model()->findAll($dbCriteria);

                    $conn = Yii::app()->db;

                    $transaction = $conn->beginTransaction();
                    try{

                        foreach( $payList as $payToClear ){

                            FeePay::model()->deleteAll(" pay_id = :pay_id AND location_id = :location_id  ", array(":pay_id"=> $payToClear->id, ":location_id"=> $location_id ));

                        }

                        $command = $conn->createCommand();
                        $command->text = "SELECT
                                                    f.id as fee_id, f.value as value, f.begin_date as begin_date
                                            FROM
                                                    mip_fee f
                                                            LEFT JOIN mip_fee_pay fp ON
                                                                    ( f.id = fp.fee_id AND fp.location_id = :location_id )
                                            WHERE
                                                    fp.location_id IS NULL
                                            ORDER BY 
                                                f.begin_date ASC";
                        $command->params = array(":location_id"=> $location_id );
                        $feedNotBindedList = $command->queryAll(true);

                        $accumulated = 0;

                        foreach( $payList as $payToFix ){

                            $valuePayFix = 0;
                            $valuePayFix += $payToFix->value_cash;

                            //  solo pagos no cash que hayan sido verificados
                            $payNotCashList = PayNotCashInfo::model()->findAll("pay_id = :pay_id AND checked = true", array(":pay_id" => $payToFix->id ));

                            foreach( $payNotCashList as $payNotCash ){
                                $valuePayFix += $payNotCash->value;
                            }

                            $accumulated += $valuePayFix;

                            foreach( $feedNotBindedList as $key =>$feedNotBinded ){
                                
                                if( $feedNotBinded["begin_date"] <= $payToFix->pay_date ){
                                    
                                    
                                    if( $accumulated >= $feedNotBinded["value"] ){

                                        $feePay = new FeePay();
                                        $feePay->pay_id = $payToFix->id;
                                        $feePay->fee_id = $feedNotBinded["fee_id"];
                                        $feePay->location_id = $location_id;
                                        $feePay->save();                                            

                                        $accumulated -= $feedNotBinded["value"];
                                        unset($feedNotBindedList[$key]);
                                        
                                    }
                                    else{
                                        break;
                                    }
                                }
                            }

                        }


                        $transaction->commit(); 

                        return self::PROCESS_SUCESS;

                    } catch (Exception $ex) {

                        $transaction->rollback();
                        return self::PROCESS_FAIL;

                    }

                } 
            }
            
            
            
            return self::PROCESS_CANT_EXECUTE;
        }
        
        
        
        /**
         * 
         * @param type $obj
         * @throws Exception
         */
        private function launchExceptionIfNull($obj){
            if(is_null($obj))
            {
                throw new Exception("El elemento a procesar no existe", "501");
            }
        }
        
        /**
         * 
         * @param type $obj
         * @throws Exception
         */
        private function launchExceptionLocation(){
 
           throw new Exception("Error en la Propiedad suministrada", "501");
        }
        
        
        /**
         * 
         * @param type $owners
         * @throws Exception
         */
        private function launchExceptionThatFixWithOneOwner($owners){
            throw new Exception("Error, para este proceso sólo se permiten parcelas de un (1) propietario", "501");
        }
        
        /**
         * 
         * @param type $owners
         * @throws Exception
         */
        private function launchExceptionThatFixWithWithoutOwner(){
            throw new Exception("Error, para este proceso se requerie obligatioriamente (1) propietario", "501");
        } 
        
	
}
