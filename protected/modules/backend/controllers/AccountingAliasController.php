<?php


/**
 * 
 */
class AccountingAliasController extends Controller {


    /**
	 * @var string The layout for the controller view.
	 */
	public $layout = '//layouts/column2';
	/**
	 * @var array Context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array The breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

    
    /**
     * 
     * @param type $id
     */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'AccountingAlias'),
		));
	}

    
    /**
     * 
     */
	public function actionCreate() {
		$model = new AccountingAlias;

                $model->scenario ='create';
		if (isset($_POST['AccountingAlias'])) {
			$model->setAttributes($_POST['AccountingAlias']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->key));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

    
    /**
     * 
     * @param type $id
     */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
                  
                

		if (isset($_POST['AccountingAlias'])) {
			$model->setAttributes($_POST['AccountingAlias']);
                        
            $model->update  = true;


            $accountingAlias = AccountingAlias::model()->find('`key`=:key', array(':key'=>$id));

              
			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->key));
			}
		}

		$this->render('update', array(
            'model' => $model,
        ));
	}

    
    /**
     * 
     * @param type $id
     * @throws CHttpException
     */
	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'AccountingAlias')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
                        
	}

    
    
    /**
     * 
     */
	public function actionIndex() {
		/*$dataProvider = new CActiveDataProvider('AccountingAlias');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));*/
                
                $this->redirect('admin');
	}

    
    
    /**
     * 
     */
	public function actionAdmin() {
		$model = new AccountingAlias('search');
		$model->unsetAttributes();

		if (isset($_GET['AccountingAlias']))
			$model->setAttributes($_GET['AccountingAlias']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
    
    
    /**
     * 
     * @param integer $id
     * @return AccountingAlias
     */
    protected function loadModel($id, $class=""){
        return AccountingAlias::model()->findByPk($id);
    }

}