<?php

class PersonEmailController extends Controller
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
		$person_id =  isset($_GET['person_id'])? $_GET['person_id']:null;
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'person_id' => $person_id
		));
	}
	
	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$person_id =  isset($_GET['person_id'])? $_GET['person_id']:null;
		
		$model=new PersonEmail;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['PersonEmail']))
		{
			$model->attributes=$_POST['PersonEmail'];
			if( !empty($person_id) )
			{
				$model->person_id = $person_id;
			}			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id, 'person_id'=>$person_id));
		}
		
		if( !empty($person_id) )
		{
			$model->person_id = $person_id;
		}
				
		
		$this->render('create',array(
			'model'=>$model,
			'person_id'=>$person_id
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateByPerson($id)
	{
		$model=new PersonEmail;
		$model->person_id = $id;
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['PersonEmail']))
		{
			$model->attributes=$_POST['PersonEmail'];			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
	
		$this->render('createByPerson',array(
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
		$person_id =  isset($_GET['person_id'])? $_GET['person_id']:null;
		$model=$this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['PersonEmail']))
		{
			$model->attributes=$_POST['PersonEmail'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		if( !empty($person_id) )
		{
			$model->person_id = $person_id;
		}
		
		$this->render('update',array(
			'model'=>$model,
			'person_id'=>$person_id
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
		$person_id =  isset($_GET['person_id'])? $_GET['person_id']:null;

		$dataProvider=new CActiveDataProvider('PersonEmail');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'person_id'=>$person_id
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$person_id =  isset($_GET['person_id'])? $_GET['person_id']:null;
		
		$model=new PersonEmail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PersonEmail']))
			$model->attributes=$_GET['PersonEmail'];
		
		if( $person_id )
		{
			$model->person_id = $person_id; 
		}
		
		$this->render('admin',array(
			'model'=>$model,
			'person_id'=> $person_id
		));
	}
	
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=PersonEmail::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='person-email-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
