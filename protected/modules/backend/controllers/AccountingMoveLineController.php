<?php

class AccountingMoveLineController extends Controller
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

        $references = AccountingMoveReference::model()->findAll("move_line_id = :move_line_id", array(":move_line_id"=>$id));
        
		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'reference'=>$references,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new AccountingMoveLine;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
        $accountingMove=AccountingMove::model()->find('id=:id',array('id'=>$id));

        $model->accountingMoveDate  = $accountingMove->date_at;
        $model->date_at = MipHelper::parseDateFromDb($accountingMove->date_at);
        $model->balance = "0";

		if(isset($_POST['AccountingMoveLine']))
		{
                        
			$model->attributes=$_POST['AccountingMoveLine'];
                        $model->date_at = MipHelper::parseDateToDb($model->date_at);
                        $model->updated_at=MipHelper::getCurrentTimeStampDateDb(); 
                        
                        
                        if($model->debt){
                                $model->debt=$model->amount;
                        }else if($model->credt){
                                $model->credt=$model->amount;
                        }
                        
                       
                       
                       $data = AccountingMoveLine::model()->find("accounting_move_id=:id", array(":id"=>$id));
                       
                       
                       if(!count($data)){
                               $model->position = BizLogic::valueMinPosition();  
                       }
                       
                       if(($model->credt) &&  (count($data)) ){
                               
                            $data = AccountingMoveLine::model()->findBySql("SELECT * from mip_accounting_move_line order by id desc");
                            
                            if($model->credt > $data->debt){
                                    
                                   $model->position = $data->position + BizLogic::valueMinPosition();
   
                               }else{
                   
                                 $model->position = $data->position;
                         
                            }
                            
                       }else if($model->debt){
                               
                            
                                
                            if(count($data)){
                                   $model->position = $data->position;
                                   
                            }
                               
                       }
                       
                       
                       
                        
                         
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id,''));
			}else{
				$model->date_at = MipHelper::parseDateFromDb($model->date_at);
			}
		}

		$this->render('create',array(
			'model'=>$model,
                        'accountingMoveLine'=>$id,
                        
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
                
                
                
                
                
                
                $accountingMove=AccountingMove::model()->find('id=:id',array('id'=>$id));
                         
                        $model->accountingMoveDate  = $accountingMove->date_at;
                        $model->date_at = MipHelper::parseDateFromDb($model->date_at);        
                
		if(isset($_POST['AccountingMoveLine']))
		{
			$model->attributes=$_POST['AccountingMoveLine'];
                        $model->date_at = MipHelper::parseDateToDb($model->date_at);
                        $model->updated_at=MipHelper::getCurrentTimeStampDateDb(); 
         					

         					
                        $model->scenario = "update";
                        
                       
                        
                        if($model->debt){
                                $model->debt=$model->amount;
                        }else if($model->credt){
                                $model->credt=$model->amount;
                        }
          
                       
                       
                       if($model->credt){
                            $data = AccountingMoveLine::model()->findBySql("SELECT * from mip_accounting_move_line  where id<>".$model->id." order by id desc");
                            
                            if(count($data)){
                                if($model->credt < $data->debt){
                              
                                    $model->position = $model->position - BizLogic::valueMinPosition(); 
                                }else if($model->credt == $data->debt){
                                    
                                    $model->position = $data->position;
                                }else{
                                        
                                      $model->position = $data->position + BizLogic::valueMinPosition();   
                                }
                                
                            }
                       }
                       
                       
                       
                       
     
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}else{
				
				$model->date_at = MipHelper::parseDateFromDb($model->date_at);
			
			}
		}
                
                
		$this->render('update',array(
			'model'=>$model,
                        'date_update'=>$model->date_update,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AccountingMoveLine');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AccountingMoveLine('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountingMoveLine']))
			$model->attributes=$_GET['AccountingMoveLine'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountingMoveLine the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountingMoveLine::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountingMoveLine $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounting-move-line-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
