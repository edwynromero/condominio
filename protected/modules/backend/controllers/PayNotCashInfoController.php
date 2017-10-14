<?php

class PayNotCashInfoController extends Controller
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
		$model=new PayNotCashInfo;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['PayNotCashInfo']))
		{
			$model->attributes=$_POST['PayNotCashInfo'];
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
		
		if(isset($_POST['PayNotCashInfo']))
		{
			$model->attributes=$_POST['PayNotCashInfo'];
			$model->checked = ( empty($model->checked) || $model->checked == false )?0:1;
			if($model->save())
                        {
                            
                            
                            
                            
                            
                            
                            $this->redirect(array('//backend/payNotCashInfo/review'));
                        }
			
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
		$dataProvider=new CActiveDataProvider('PayNotCashInfo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new PayNotCashInfo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PayNotCashInfo']))
			$model->attributes=$_GET['PayNotCashInfo'];
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	/**
	 * Manages all models.
	 */
	public function actionReview()
	{
		$model=new PayNotCashInfo('review');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PayNotCashInfo']))
		{
			$model->attributes=$_GET['PayNotCashInfo'];
		}
	
		$this->render('review',array(
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
		$model=PayNotCashInfo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pay-not-cash-info-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
