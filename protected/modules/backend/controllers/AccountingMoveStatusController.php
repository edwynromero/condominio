<?php

class AccountingMoveStatusController extends Controller
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
		$model=new AccountingMoveStatus;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountingMoveStatus']))
		{
			$model->attributes=$_POST['AccountingMoveStatus'];
			$model->scenario = 'create';
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->key));


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

		if(isset($_POST['AccountingMoveStatus']))
		{
			$model->attributes=$_POST['AccountingMoveStatus'];



			$accountingMoveStatus= AccountingMoveStatus::model()->find('`key`=:key', array(':key'=>$id));

			if(strcmp($accountingMoveStatus->label, $model->label) !==0 )
			{
				$data= AccountingMoveStatus::model()->find('label=:label', array(':label'=>$model->label));

				if(count($data)){
					$model->scenario = 'labelRepeat';
				}
			}




			if(strcmp($accountingMoveStatus->key, $model->key) !==0 )
			{
				$data= AccountingMoveStatus::model()->find('`key`=:key', array(':key'=>$model->key));

				if(count($data)){
					$model->scenario = 'keyRepeat';
				}
			}


			
			if($model->save())
				$this->redirect(array('view','id'=>$model->key));
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



		$accountingMove = accountingMove::model()->find('status=:status', array(':status'=>$id));
		

	if(count($accountingMove)){
				throw new CHttpException(500,  MipHelper::t('This status is used in a AccountingMove'));
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
		/** $dataProvider=new CActiveDataProvider('AccountingMoveStatus');
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
		$model=new AccountingMoveStatus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountingMoveStatus']))
			$model->attributes=$_GET['AccountingMoveStatus'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountingMoveStatus the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountingMoveStatus::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountingMoveStatus $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounting-move-status-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
