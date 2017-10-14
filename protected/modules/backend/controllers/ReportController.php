<?php

Yii::import('application.models.forms.fixPay.ProcessLocationForm');

class ReportController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
        private $all_fee_count = 0;
        private $all_fee_amount = 0;
        
        public function behaviors()
        {
            return array(
                'eexcelview'=>array(
                    'class'=>'ext.eexcelview.EExcelBehavior',
                ),
            );
        }
        
        
        
        
        /**
         * Accion para el reporte de Deud
         */
        public function actionDefaulters(){
            
            
            $pageSize = 10;
            $min_fee_dues = 3;
            $max_fee_dues = 10;

            if( isset($_GET["size"]) && isset($_GET["min"])  & isset($_GET["max"])  )
            {
                $pageSize = $_GET["size"];
                $min_fee_dues = $_GET["min"];
                $max_fee_dues = $_GET["max"];
            }
            
            $this->all_fee_amount = BizLogic::getSumAllFeeAt();
            $this->all_fee_count = BizLogic::getCountAllFeeAt();
            
            
            
            $sql = "SELECT
                           l.id as id, 
                           l.code, 
                           (:all_fee_count - COUNT( DISTINCT f.id)) as fee_debt_count
                    FROM 
                                    mip_location l
                                    INNER JOIN mip_fee_pay fp  ON
                                            ( l.id = fp.location_id )
                                    INNER JOIN mip_fee f ON 
                                            ( fp.fee_id =  f.id )
                    GROUP BY 
                            l.id, l.code
                    HAVING
                        (:all_fee_count - COUNT( DISTINCT f.id)) >= :MIN  AND (:all_fee_count - COUNT( DISTINCT f.id) <= :MAX )
                    ";
            $parameters = array(":MIN"=>$min_fee_dues, ":MAX"=>$max_fee_dues, ":all_fee_count" => $this->all_fee_count );

            $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') t ')->queryScalar($parameters);
            $dataProvider=new CSqlDataProvider($sql, array(
                'totalItemCount'=>$count,
                'sort'=>array(
                    'attributes'=>array(
                         'fee_debt_count'=>array(
                                'asc' =>'fee_debt_count DESC, code DESC',
                                'desc'=>'fee_debt_count ASC,  code ASC',
                         ), 
                         'code'=>array(
                                'asc' =>'code ASC,  fee_debt_count ASC',
                                'desc'=>'code DESC, fee_debt_count DESC',
                         ),  
                    ),
                    'defaultOrder'=>array(
                        'fee_debt_count' => CSort::SORT_DESC,
                        'code' => CSort::SORT_DESC,
                    ), 
                ),
                'pagination'=>array(
                    'pageSize'=>$pageSize,
                ),
                'params'=>$parameters,
            ));
            
            $this->render('defaulters',array(   
                'count'=>$count,
                'dataProvider'=>$dataProvider,
                'page_size' => $pageSize,
                'min_fee_dues' => $min_fee_dues,
                'max_fee_dues' => $max_fee_dues,
            )); 
            
            
        }
        
        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridFeeDueSum($data, $row){
           return MipHelper::formatCurrency( $this->all_fee_amount - BizLogic::getSumAllFeePayed(array($data["id"])) );
        }

        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridFeeCount($data, $row){
           return  $data["fee_debt_count"];
        }
        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridOwnersByLocation($data, $row){
           $persons = BizLogic::getOwnersByLocation($data["id"]);
           $html = "";
           foreach($persons as $person){
               $html .= CHtml::openTag("div") . MipHelper::createPersonLink($person) . Chtml::closeTag("div");
           }
           
           return $html;
        }
        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridLocation($data, $row){   
           return MipHelper::createLocationCodeLink($data["id"], $data["code"]);
        }
        
        
        /**
         * Accion para el reporte de Deud
         */
        public function actionDownloadDefaulters($min=0, $max=0){
            
            
            $min_fee_dues = 3;
            $max_fee_dues = 10;

            if( isset($_GET["min"])  & isset($_GET["max"])  )
            {
                $min_fee_dues = $_GET["min"];
                $max_fee_dues = $_GET["max"];
            }
            
            $this->all_fee_amount = BizLogic::getSumAllFeeAt();
            $this->all_fee_count = BizLogic::getCountAllFeeAt();
            
            
            
            $sql = "SELECT
                           l.id as id, 
                           l.code, 
                           (:all_fee_count - COUNT( DISTINCT f.id)) as fee_debt_count
                    FROM 
                                    mip_location l
                                    INNER JOIN mip_fee_pay fp  ON
                                            ( l.id = fp.location_id )
                                    INNER JOIN mip_fee f ON 
                                            ( fp.fee_id =  f.id )
                    GROUP BY 
                            l.id, l.code
                    HAVING
                        (:all_fee_count - COUNT( DISTINCT f.id)) >= :MIN  AND (:all_fee_count - COUNT( DISTINCT f.id) <= :MAX )";
            $parameters = array(":MIN"=>$min_fee_dues, ":MAX"=>$max_fee_dues, ":all_fee_count" => $this->all_fee_count );
            
            $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') t ')->queryScalar($parameters);
            $dataProvider=new CSqlDataProvider($sql, array(
                'totalItemCount'=>$count,
                'sort'=>array(
                    'defaultOrder'=>array(
                        'fee_debt_count' => CSort::SORT_DESC,
                    ), 
                ),
                'pagination'=>array(
                    'pageSize'=>$count,
                ),
                'params'=>$parameters,
            ));
            
            $columns = array(
                                'id',
                                array(
                                        'header'=>'Parcela',
                                        'name'=>'code',
                                        'type'=>'text',
                                        'value'=> array($this, 'showGridLocationDownload'),
                                ),
                                array(
                                        'header'=>'Propietarios',
                                        'name'=>'fee_debt_count',
                                        'type'=>'text',
                                        'value'=> array($this, 'showGridOwnersByLocationDownload'),
                                ),
                                array(
                                        'header'=>'Deuda',
                                        'name'=>'fee_debt_count',
                                        'type'=>'text',  
                                        'value'=> array($this, 'showGridFeeDueSumDownload'),
                                ),
                                array(
                                        'header'=>'Cuotas',
                                        'name'=>'fee_debt_count',
                                        'type'=>'text',
                                        'value'=> array($this, 'showGridFeeCountDownload'),
                                ),
                     );

            $this->toExcel(
                    $dataProvider,
                    $columns,
                    MipHelper::getDefaultReportFileName(),
                     array(
                         'creator' => 'Koiosoft',
                     )
            );
            
        }
        
        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridFeeDueSumDownload($position, $row){
           $data = $row[$position];
           return MipHelper::formatCurrency( $this->all_fee_amount - BizLogic::getSumAllFeePayed(array($data["id"])) );
        }

        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridFeeCountDownload($position, $row){
           $data = $row[$position];
           return  $data["fee_debt_count"];
        }
        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridOwnersByLocationDownload($position, $row){
           $data = $row[$position];
           $persons = BizLogic::getOwnersByLocation($data["id"]);
           $output = "";
           foreach($persons as $person){
               $output .= $person->fullNameList . "\r\n";
           }
           
           return $output;
        }
        
        /**
         * 
         * @param type $data
         * @param type $row
         * @return type
         */
        public function showGridLocationDownload($position, $row){
           $data = $row[$position]; 
           return $data["code"];
        }
        
        
        /**
         * 
         */
        public function actionIndex(){
            $this->render('index',array(
            ));   
        }
        
      
        
	
}
