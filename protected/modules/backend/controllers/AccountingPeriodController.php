<?php

class AccountingPeriodController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            
            $this->validateFiscalYears();
                
            $model=new AccountingPeriod;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['AccountingPeriod']))
            {	

                    $model->attributes=$_POST['AccountingPeriod'];
                    $model->from=MipHelper::parseDateToDb($model->from);
                    $model->updated_at=MipHelper::getCurrentTimeStampDateDb(); 

                    $model->to=MipHelper::parseDateToDb($model->to);

                    $model->scenario =      'create';
                    if($model->save()){
                            $this->redirect(array('view','id'=>$model->id));
                    }else{
                            $model->from = MipHelper::parseDateFromDb($model->from);
                            $model->to = MipHelper::parseDateFromDb($model->to);

                    }
            }

            $this->render('create',array(
                    'model'=>$model,
            ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$AccountingPeriod= AccountingPeriod::model()->find("id=:id", array(":id"=>$id));

		$model->to = MipHelper::parseDateFromDb( $model->to );
		$model->from = MipHelper::parseDateFromDb( $model->from );


		if(isset($_POST['AccountingPeriod']))
		{
                    $model->attributes=$_POST['AccountingPeriod'];
                    $model->from=MipHelper::parseDateToDb($model->from);
                    $model->updated_at=MipHelper::getCurrentTimeStampDateDb(); 
                    $model->to=MipHelper::parseDateToDb($model->to);

                    if(strcmp($AccountingPeriod->label, $model->label) !==0 )
                    {

                        $data= AccountingPeriod::model()->find('label=:label', array(':label'=>$model->label));

                        if(count($data)){
                                $model->scenario = 'labelRepeat';
                        }
                    }

                    if($model->save()){
                        $this->redirect(array('view','id'=>$model->id));
                    }else{
                        $model->from = MipHelper::parseDateFromDb($model->from);
                        $model->to = MipHelper::parseDateFromDb($model->to);

                    }
		}

		$this->render('update',array(
			'model'=>$model,
			'from' => $AccountingPeriod->from,
			'to'=> $AccountingPeriod->to,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

            $accountingMoveLine = AccountingMoveLine::model()->find('accounting_period_id=:accounting_period_id', array(':accounting_period_id'=>$id));

            if(count($accountingMoveLine)){
                    throw new CHttpException(500,  MipHelper::t('This Period is used in AccountingMoveLine'));
            }else{


                $this->loadModel($id)->delete();

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

            }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            
            $this->validateFiscalYears();

            /*$dataProvider=new CActiveDataProvider('AccountingPeriod');
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));*/

            $this->redirect('admin');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            
                $this->validateFiscalYears();
                
		$model=new AccountingPeriod('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountingPeriod']))
			$model->attributes=$_GET['AccountingPeriod'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountingPeriod the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountingPeriod::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountingPeriod $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounting-period-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        
        /**
         * Verifica si existen Años Fiscales y lleva a la creación de los mismos
         */
        protected function validateFiscalYears(){
            
            $fiscalYears = AccountingHelper::getAllFiscalYears();
            if( count($fiscalYears) == 0 ){
                
                $this->redirect( array("//backend/fiscalYear/create") );
                
            }
            
        }
        
}
