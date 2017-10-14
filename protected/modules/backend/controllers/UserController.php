<?php

class UserController extends Controller
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
		$model=new User;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if( !$this->checkPassword( $model ) )
			{
				$model->addError("password_confirm", MipHelper::t("Password confirmation is necesary"));
			}
			else
			{
				$model->password = md5(trim($model->password));
			}
			
			if( $model->validate(null, false) && $model->save(false) ) //
			{
					$this->redirect(array('view','id'=>$model->id));	
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
		
		if(isset($_POST['User']))
		{
			$password = $model->password;
			$model->attributes=$_POST['User'];

			if( $this->isPasswordUpdatable($model) )
			{
				if( !$this->checkPassword( $model ) )
				{
					$model->addError("password_confirm", MipHelper::t("Password confirmation is necesary"));
				}
				else
				{
					$model->password = md5($model->password);
				}				
			}
			else
			{
				$model->password = $password;
			}	
				
			if( $model->validate(null, false) && $model->save(false) ) 
			{
				$this->redirect(array('view','id'=>$model->id));
			}			
			
		}
		
		//  siempre los password llegan en blanco al formulario
		$model->password_confirm 	= "";
		$model->password 			= "";
		
		
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
		
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
		$model=User::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Verifica si el password es valido
	 * @param User $model
	 * @return boolean
	 */
	protected function checkPassword($model)
	{
		$password_confirm =  trim($model->password_confirm);
		return $password_confirm != "" && ( $password_confirm	 == trim($model->password) );
	}
	
	
	/**
	 * Verifica si el password es para ser actualizado
	 * @param User $model
	 * @return boolean
	 */
	protected function isPasswordUpdatable($model)
	{
		return trim($model->password_confirm) != "" || trim($model->password) != ""; 
	}
	
	
}
