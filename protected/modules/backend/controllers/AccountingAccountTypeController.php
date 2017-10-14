<?php

class AccountingAccountTypeController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'AccountingAccountType'),
		));
	}

	public function actionCreate() {
		$model = new AccountingAccountType;

                
                if (isset($_POST['AccountingAccountType'])) {
			$model->setAttributes($_POST['AccountingAccountType']);
                        
                        $model->scenario ='create';
			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->key));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'AccountingAccountType');


		if (isset($_POST['AccountingAccountType'])) {
			$model->setAttributes($_POST['AccountingAccountType']);

			$accountingAccountType = AccountingAccountType::model()->find('`key`=:key', array(':key'=>$id));


			if(strcmp($accountingAccountType->label, $model->label) !==0 )
			{
				$data= AccountingAccountType::model()->find('label=:label', array(':label'=>$model->label));

				if(count($data)){
					$model->scenario = 'labelRepeat';
				}
			}




			if(strcmp($accountingAccountType->key, $model->key) !==0 )
			{
				$data= AccountingAccountType::model()->find('`key`=:key', array(':key'=>$model->key));

				if(count($data)){
					$model->scenario = 'keyRepeat';
				}
			}





			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->key));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {




		$accountingAccount = AccountingAccount::model()->find('type=:type', array(':type'=>$id));

		

		
		
		if(count($accountingAccount)){
			
				throw new CHttpException(500,  MipHelper::t('This type accounting account is used in a accountingaccount'));
			
			
		}else{




		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'AccountingAccountType')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));


		}
	}

	public function actionIndex() {
		/*$dataProvider = new CActiveDataProvider('AccountingAccountType');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));*/
                
                $this->redirect('admin');
                
	}

	public function actionAdmin() {
		$model = new AccountingAccountType('search');
		$model->unsetAttributes();

		if (isset($_GET['AccountingAccountType']))
			$model->setAttributes($_GET['AccountingAccountType']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}