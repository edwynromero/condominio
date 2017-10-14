<?php


/**
 * Movimientos Contables - Controlador
 * 
 */
class AccountingMoveController extends Controller
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
        $model = $this->loadModel($id);
               
        $isMoveOpen = $model->status == AccountingMoveStatus::defaultStatusOpen()->key || $model->status == AccountingMoveStatus::defaultStatusConciliated()->key;

        $balance_total = AccountingHelper::getBalanceFromAccountingMove( $model->id  );
        
        $references = AccountingMoveReference::model()->findAll("move_id = :move_id", array(":move_id"=>$id));

		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'isMoveOpen' => $isMoveOpen,
            'balance_total' => $balance_total,
            'references' => $references,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AccountingMove;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->date_at = MipHelper::getDateToday();

		if(isset($_POST['AccountingMove']))
		{
			$model->attributes=$_POST['AccountingMove'];
            $model->date_at=MipHelper::parseDateToDb($model->date_at);
            $model->created_at=MipHelper::getCurrentTimeStampDateDb();
            $model->updated_at=MipHelper::getCurrentTimeStampDateDb(); 
			
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}else{
				$model->date_at=MipHelper::parseDateFromDb($model->date_at);
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
		$model->date_at = MipHelper::parseDateFromDb( $model->date_at );

		if(isset($_POST['AccountingMove']))
		{
            $previous_status    =   $model->status;
            
			$model->attributes  =   $_POST['AccountingMove'];
            $model->date_at     =   MipHelper::parseDateToDb($model->date_at);
            $model->updated_at  =   MipHelper::getCurrentTimeStampDateDb();            
            
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}else{
				$model->date_at = MipHelper::parseDateFromDb($model->date_at);
				
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
    
    
    /**
     * 
     * @param integer $id
     * @param boolean $save
     * @return boolean
     */
    protected  function clsose($id, $save = false){
        $accountingMove = $this->loadModel($id);
		$accountingSeats = AccountingMoveLine::model()->findAll('accounting_move_id=:accounting_move_id', array(':accounting_move_id'=>$id));
        
        $debt = 0;
        $credt = 0;
        
        /** @var $accountingSeat AccountingMoveLine  */
        foreach($accountingSeats as $accountingSeat){
            $debt += $accountingSeat->debt;
            $credt += $accountingSeat->credt;
        }
        
        if($debt == $credt && $debt != 0 && $credt != 0){
            $accountingMove->status = AccountingMoveStatus::defaultStatusClosed()->key;
            if($save){
                $accountingMove->save();  
            }

            Yii::app()->user->setFlash('success', AccountingHelper::t( "The accounting movement was closed successfully." ));
            return true;
        }else{
                
        }
        
        return false;
    }






    /**
	 * Close Accounting Move
	 * @param integer $id the ID of the model to be closed
	 */
	public function actionClose($id)
	{
        
        $model = $this->loadModel($id);
        
        $model->status = AccountingMoveStatus::defaultStatusClosed()->key;

        $model->save();
        
        if( $model->getFailedOnClose() ){
            Yii::app()->user->setFlash('error', AccountingHelper::t( "The accounting movement does not meet the requirements to be closed!" ));
        }
        else {
            Yii::app()->user->setFlash('success', AccountingHelper::t( "The accounting movement was closed successfully." ));
        }
        
        $this->redirect( $this->createAbsoluteUrl("//backend/accountingMove/view", array("id"=>$id)) );
        
	}
    
    
    /**
	 * Close Accounting Move
	 * @param integer $id the ID of the model to be opened
	 */
	public function actionOpen($id)
	{
        $accountingMove         = $this->loadModel($id);
		$accountingMove->status = AccountingMoveStatus::defaultStatusConciliated()->key;
        $accountingMove->save();
        Yii::app()->user->setFlash('success', AccountingHelper::t( "The accounting movement was opened successfully." ));
        $this->redirect( $this->createAbsoluteUrl("//backend/accountingMove/view", array("id"=>$id)) );
	}
    

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		$accountingMoveLine = AccountingMoveLine::model()->find('accounting_move_id=:accounting_move_id', array(':accounting_move_id'=>$id));

        if(count($accountingMoveLine)){
            throw new CHttpException(500,  MipHelper::t('This Move is used in AccountingMoveLine'));
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
		/** $dataProvider=new CActiveDataProvider('AccountingMove');
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
		$model=new AccountingMove('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountingMove']))
			$model->attributes=$_GET['AccountingMove'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountingMove the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountingMove::model()->with("accountingMoveLines")->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountingMove $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounting-move-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    
    /**
     * 
     * @param AccountingMove $accountingMove
     */
    protected function reconcileMoveLines($accountingMove){
        
        if( $accountingMove->status == AccountingMoveStatus::defaultStatusConciliated()->key ){          
            AccountingMoveLine::model()->updateAll(array("reconciled"=>1)," accounting_move_id = :accounting_move_id", array(":accounting_move_id"=>$accountingMove->id));    
        }
        else{
            AccountingMoveLine::model()->updateAll(array("reconciled"=>0)," accounting_move_id = :accounting_move_id", array(":accounting_move_id"=>$accountingMove->id));    
        }
    }
    
    
    /**
     * Agrega un asiento contable a un Movimiento Contable
     * 
     * @param integer $id
     */
    public function actionSeatAdd($id){
        
        /* @var $accountingMove AccountingMove */
        $accountingMove             = AccountingMove::model()->find('id=:id',array('id'=>$id));
 
        $moveLineCount              = AccountingMoveLine::model()->count("accounting_move_id=:id", array(":id"=>$id));
        
        $model                      = new AccountingMoveLine;
        $model->accountingMoveDate  = $accountingMove->date_at;
        $model->date_at             = MipHelper::parseDateFromDb($accountingMove->date_at);
        $model->accounting_move_id  = $id;
        $model->credt               = 0.0;
        $model->debt                = 0.0;
        $model->reconciled          = 0;

        if(isset($_POST['AccountingMoveLine']))
        {

            $model->attributes  =   $_POST['AccountingMoveLine'];
            $model->date_at     =   MipHelper::parseDateToDb($model->date_at);
            $model->updated_at  =   MipHelper::getCurrentTimeStampDateDb();
            
            if( !is_null($model->isCredit) ){   
                if($model->isCredit){
                    $model->debt = 0.0;
                    $model->credt = $model->amount;
                }else{
                    $model->credt = 0.0;
                    $model->debt = $model->amount;
                } 
            }
            
            $transaction = Yii::app()->db->beginTransaction();

            if($model->save()  ){

                if( $accountingMove->checkCanBeClosed() ){
                    $accountingMove->status = AccountingMoveStatus::defaultStatusConciliated()->key;
                }
                else{
                    $accountingMove->status = AccountingMoveStatus::defaultStatusOpen()->key;
                }
                
                if( $accountingMove->save() ){
                    
                    $this->reconcileMoveLines($accountingMove);
                    
                    $transaction->commit();

                    $this->redirect(array('view','id'=> $accountingMove->id, ''));
                    
                }
      
            }else{
                
                $model->date_at = MipHelper::parseDateFromDb($model->date_at);
            }
            
            $transaction->rollback();
        }
        else{
            $model->accounting_account_id = isset($_GET["account_id"])?$_GET["account_id"]:0;
        }

        $this->render('accountingMoveLine/create',array(
            'model'=>$model,
            'accountingMove' => $accountingMove,
        ));
    }
    
    
    /**
     * 
     * @param integer $id  ID Accounting Move
     */
    public function actionSeatUpdate($id){
        
        /*  @var $model AccountingMoveLine */
         
        $model          = AccountingMoveLine::model()->findByPk($id);
        $accountingMove = AccountingMove::model()->findByPk($model->accounting_move_id);
    
        if(isset($_POST['AccountingMoveLine']))
        {
            $model->attributes  = $_POST['AccountingMoveLine'];
            $model->date_at     = MipHelper::parseDateToDb($model->date_at);
            $model->updated_at  = MipHelper::getCurrentTimeStampDateDb();
            $model->reconciled  = 0;
            
            if( !is_null($model->isCredit) ){
                if($model->isCredit){
                    $model->debt = 0.0;
                    $model->credt = $model->amount;
                }else{
                    $model->credt = 0.0;
                    $model->debt = $model->amount;
                } 
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            
            if($model->save()){
 
                if( $accountingMove->checkCanBeClosed() ){
                    $accountingMove->status = AccountingMoveStatus::defaultStatusConciliated()->key;
                }
                else{
                    $accountingMove->status = AccountingMoveStatus::defaultStatusOpen()->key;
                }
                
                if( $accountingMove->save() ){
                    
                    $this->reconcileMoveLines($accountingMove);
                    
                    $transaction->commit();

                    $this->redirect(array('view','id'=> $accountingMove->id, ''));
                    
                }
                
            }else{
                $model->date_at = MipHelper::parseDateFromDb($model->date_at);
            }
            
            $transaction->rollback();
            
        }else{
            
            if($model->credt > 0){
                $model->isCredit    = true;
                $model->amount      = $model->credt;
            }else{
                $model->isCredit    = false;
                $model->amount      = $model->debt;
            }
            
            if( isset($_GET["account_id"]) ){
                $model->accounting_account_id = $_GET["account_id"];
            }  

        }
        
        $this->render('accountingMoveLine/update',array(
            'model'=>$model,
            'accountingMove' => $accountingMove,
        ));
    }
    
    
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionSeatDelete($id)
	{
		$accountingMoveLine = AccountingMoveLine::model()->findByPk( $id );
        $accountingMove     = $this->loadModel($accountingMoveLine->accounting_move_id); 

        if( $accountingMove->status == AccountingMoveStatus::defaultStatusClosed()->key ){
            Yii::app()->user->setFlash('error', AccountingHelper::t( "This Seat is used in Accounting Move Closed." ));
            throw new CHttpException(500, AccountingHelper::t('This Seat is used in Accounting Move Closed.'));
        }else{
            
            $transaction = Yii::app()->db->beginTransaction();
            
            try{
                AccountingMoveReference::model()->deleteAll("move_line_id = :move_line_id", array(":move_line_id" => $accountingMoveLine->id ));
                $accountingMoveLine->delete();

                if( $accountingMove->checkCanBeClosed() ){
                    $accountingMove->status = AccountingMoveStatus::defaultStatusConciliated()->key;
                    $accountingMove->save();
                }
                else{
                    $accountingMove->status = AccountingMoveStatus::defaultStatusOpen()->key;
                    $accountingMove->save();
                }

                $transaction->commit();
                
            } catch (Exception $ex) {
                
                $transaction->rollback();
                
                Yii::app()->user->setFlash('error', AccountingHelper::t( "Internal fail to Delete." ));
                throw new CHttpException(500, AccountingHelper::t('Internal fail to Delete.'));
                
            }
            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect( $this->createUrl("//backend/accountingMove/view", array("id"=>$accountingMove->id) ) );
        }  
	}
    
    
    /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionSeatView($id)
	{
		$model              = AccountingMoveLine::model()->findByPk( $id );
        $accountingMove     = $this->loadModel($model->accounting_move_id); 
        $references         = AccountingMoveReference::model()->findAll("move_line_id = :move_line_id", array(":move_line_id"=>$id));

        
        $this->render('accountingMoveLine/view',array(
            'model'=>$model,
            'accountingMove' => $accountingMove,
            'references' => $references,
        ));
    }
    
    
    /**
     * 
     * @param type $id
     */
    public function actionReferenceAdd($id){
        
        $accountingMove     = AccountingMove::model()->find('id=:id',array('id'=>$id));
        $model              = new AccountingMoveReference();
        $model->move_id     = $id;
        $model->created_at  = MipHelper::getCurrentTimeStampDateDb();
        $model->updated_at  = MipHelper::getCurrentTimeStampDateDb();
        $model->type        = AccountingMoveRefType::defaultManually()->key;
        
        if(isset($_POST['AccountingMoveReference']))
        {
            $model->attributes  =   $_POST['AccountingMoveReference'];
            if($model->save()){
                $this->redirect(array('//backend/accountingMove/view','id'=> $accountingMove->id, ''));
            }
            
        }
        
        $this->render('accountingMoveReference/create',array(
            'model'=>$model,
            'accountingMove' => $accountingMove,
        ));
        
    }
    
    
    /**
     * 
     * @param type $id
     */
    public function actionReferenceEdit($id){
        
        $model              = AccountingMoveReference::model()->findByPk($id);
        $accountingMove     = AccountingMove::model()->find('id=:id',array('id'=>$model->move_id));

        if(isset($_POST['AccountingMoveReference']))
        {
            $model->attributes  =   $_POST['AccountingMoveReference'];
            
            $model->updated_at  = MipHelper::getCurrentTimeStampDateDb();
        
            if($model->save()){
                $this->redirect(array('view','id'=> $accountingMove->id, ''));
            }
            
        }
        
        $this->render('accountingMoveReference/update',array(
            'model'=>$model,
            'accountingMove' => $accountingMove,
        ));
        
    }
    
    
    /**
     * 
     * @param type $id
     */
    public function actionReferenceDelete($id){
        
        $model  = AccountingMoveReference::model()->findByPk($id);

        if( $model->delete() ){
            if(!isset($_GET['ajax']))
                $this->redirect(array('view','id'=> $model->move_id, ''));            
        }

    }
    
    
    
}
