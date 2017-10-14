<?php


/**
 * 
 */
class AccountingAccountController extends GxController {


    
    /**
     * 
     * @param type $id
     */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'AccountingAccount'),
		));
	}
    
    
    /**
     * 
     * @param type $move_line_id
     */
    public function actionCreateAtMoveLineForm($id, $source="move"){
        
		$model = new AccountingAccount;
        
        $accountingKinds = AccountingAccountKind::getDefaults(false);

		if( AccountingHelper::processAccountSave($_POST, $model) ){
            
            if($source == "move"){
                $this->redirect(array('//backend/accountingMove/seatAdd', 'id' => $id, 'account_id' => $model->id  ));
            }
            else{
                $this->redirect(array('//backend/accountingMove/seatUpdate', 'id' => $id, 'account_id' => $model->id ));
            }

		}

		$this->render('create', array( 'model' => $model, 'accountingKinds' => $accountingKinds));
        
    }

    
    /**
     * 
     */
	public function actionCreate() {
        
		$model = new AccountingAccount;
        
        $accountingKinds = AccountingAccountKind::getDefaults();

		if( AccountingHelper::processAccountSave($_POST, $model) ){
            
            if (Yii::app()->getRequest()->getIsAjaxRequest())
                Yii::app()->end();
            else
                $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array( 'model' => $model, 'accountingKinds' => $accountingKinds));
	}

    
    /**
     * 
     * @param type $id
     */
	public function actionUpdate($id) {
        
		$model = $this->loadModel($id, 'AccountingAccount');
        
        $accountingKinds = AccountingAccountKind::getDefaults();

		if( AccountingHelper::processAccountSave($_POST, $model) ){
            $this->redirect(array('view', 'id' => $model->id));
        }

		$this->render('update', array( 'model' => $model, 'accountingKinds' => $accountingKinds));
	}

    
    /**
     * 
     * @param type $id
     * @throws CHttpException
     */
	public function actionDelete($id) {

        $model = $this->loadModel($id, 'AccountingAccount');
        if( AccountingHelper::processAccountDelete( $model ) ){
            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                    $this->redirect(array('admin'));
        }
	}

    
    /**
     * 
     */
	public function actionIndex() {
      
        $this->redirect('admin');
	}

    
    /**
     * 
     */
	public function actionAdmin() {
		$model = new AccountingAccount('search');
		$model->unsetAttributes();

		if (isset($_GET['AccountingAccount']))
			$model->setAttributes($_GET['AccountingAccount']);
          
		$this->render('admin', array(
			'model' => $model,
		));
	}

}