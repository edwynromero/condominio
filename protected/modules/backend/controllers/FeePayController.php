<?php

class FeePayController extends Controller
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
	public function actionAjaxCreate()
	{
		$model=new FeePay;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if( isset($_POST["fee_id"]) && isset($_POST["pay_id"]) && isset($_POST["location_id"])) // && $_GET['ajax'] )
		{
			$model->location_id = $_POST["location_id"];
			$model->fee_id 		= $_POST["fee_id"];
			$model->pay_id 		= $_POST["pay_id"];
			
			$count = FeePay::model()->count(' location_id = :location_id AND fee_id = :fee_id AND pay_id = :pay_id ', array(':location_id'=>$model->location_id, ':fee_id'=>$model->fee_id, ':pay_id'=>$model->pay_id));
			
			if( $count == 0 )
			{
				if($model->save())
					echo CJSON::encode(array('sucesfull'=>true));
				else
					echo CJSON::encode(array('sucesfull'=>false, 'error'=>$model->getError()));		
			}
			
			Yii::app()->end();
		}
		echo CJSON::encode(array('sucesfull'=>false, 'error'=>'The requested page does not exist.'));
	}	
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionAjaxDelete()
	{
		if( isset($_POST["fee_id"]) && isset($_POST["pay_id"]) && isset($_POST["location_id"])) // && $_GET['ajax'] )
		{
			FeePay::model()->deleteAll('fee_id = :fee_id AND pay_id = :pay_id AND location_id = :location_id', 
										array(':fee_id'=>$_POST["fee_id"], ':pay_id'=>$_POST["pay_id"], 'location_id'=>$_POST["location_id"]));			
			echo CJSON::encode(array('sucesfull'=>true));
		
			Yii::app()->end();
		}
		echo CJSON::encode(array('sucesfull'=>false, 'error'=>'The requested page does not exist.'));
	}	
	
	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$model=new FeePay;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['FeePay']))
		{
			$model->attributes=$_POST['FeePay'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		
		if(isset($_POST['FeePay']))
		{
			$model->attributes=$_POST['FeePay'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
				$this->loadModel($id)->delete();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('FeePay');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new FeePay('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeePay']))
			$model->attributes=$_GET['FeePay'];
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=FeePay::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fee-pay-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
