<?php

class PayController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
	protected $step1Action  = '';
	protected $step2Action  = '';
	protected $fee_id		= null;
	protected $location_id	= null;
	
	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$feePays = FeePay::model()->findAll('pay_id = :pay_id',array('pay_id'=>$model->id));
		
		$payNotCashInfos = PayNotCashInfo::model()->findAll('pay_id = :pay_id', array(':pay_id'=>$model->id));
		
		$this->render('view',array(
			'model'=>$model,
			'feePays'=>$feePays,
			'payNotCashInfos'=>$payNotCashInfos
		));
	}
	
	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{		
		$this->redirect(array('payStep1'));
	}
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateBase()
	{
		$model=new Pay;
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['Pay']))
		{
			$model->attributes=$_POST['Pay'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
	
		$this->render('create',array(
				'model'=>$model,
		));
	}
	
	
	/**
	 * Ejecuta el Paso1 en el Pago de Cuotas
	 * @param number $pay_id
	 * @param number $step
	 */
	protected function payStep1($pay_id = 0, $step = 0)
	{
		$model=new Pay;
		$saveLocationFeed = false;
		$previousCash = 0;
		
		if( $pay_id == 0 )
		{
			$model->pay_date = MipHelper::getCurrentDateDb();
		}
		else
		{
			$model= Pay::model()->findByPk( $pay_id );
			$previousCash = $model->getActualPay();		
		}
		
		//
		//  Si la eleccion es continuar con el segundo paso se redirecciona
		//
		if(isset($_POST['Pay']))
		{
			$model->attributes=$_POST['Pay'];
			$model->pay_date = MipHelper::parseDateToDb($model->pay_date);
			
			if($this->isActionAddSingleFee()  && !is_null($this->location_id) && !is_null($this->fee_id) )
			{
				$saveLocationFeed = true;
				$fee = Fee::model()->findByPk($this->fee_id);
				
				//
				//   La fecha de la cuota no puede ser mayor o igual que la fecha del pago
				//
				if( MipHelper::dateIsLessEqualThan($model->pay_date, $fee->begin_date) )
				{
					$model->addError('pay_date', MipHelper::t('The payment date must be greater than the Date of Fee'). ': ' . MipHelper::parseDateFromDb($fee->begin_date) . ' ('. MipHelper::t('day/month/year'). ')' );
				}
				
				//
				//  Balance descontando la Cuota
				//
				$currentBalance =  MipHelper::getPayBalancePersonId( $model->person_id );
				
				if( $model->isNewRecord )
				{
					$currentBalance += $model->value_cash;
				}
				else
				{
					$currentBalance = $currentBalance - $previousCash + $model->value_cash + $fee->value;
				}
				
				if( ( $currentBalance > 0 && $currentBalance - $fee->value < 0 ) || $currentBalance < 0)
				{
					$model->addError('value_cash',MipHelper::t('Not enough balance').' (' . MipHelper::formatCurrency($currentBalance - $model->value_cash) . ') '.MipHelper::t('to pay this fee').': ' . MipHelper::formatCurrency($fee->value) );
				}
				
				//
				//  aqui van reglas de negocio que garantizan que la cuota se puede pagar con el saldo 
				//
				$saveLocationFeed = $saveLocationFeed && !$this->existOnePayFeeLocation($this->fee_id, $this->location_id);  //  se establece que se puede agregar la cuota al pago 
			}
			
			if( !$model->hasErrors() && $model->save() )
			{
				if( $saveLocationFeed )
				{
					$feePay = new FeePay();
					$feePay->location_id = $this->location_id;
					$feePay->fee_id = $this->fee_id;
					$feePay->pay_id = $model->id;
					
					//  de haber un error con el enlace cuota y pago, se anula el pago
					if( $this->isActionAddSingleFee()  && !$feePay->save() )
					{
						$model->delete();
						throw new CException("No es viable");
					}
				}				
				
				// siguiente fase del asistente
				if( $step  == 2 )
				{
					if( $this->isActionAddSingleFee() )
					{
						$this->redirect( array($this->step2Action, 'id' => $model->id) );
					}
					else
					{
						$this->redirect( array($this->step2Action, 'pay_id' => $model->id) );
					}
				}				
			}
				
		}
				
		$model->pay_date = MipHelper::parseDateFromDb( $model->pay_date );
		$modelPayNotCash = PayNotCashInfo::model()->findAll('pay_id = :pay_id', array(':pay_id'=>$model->id));
		
		$this->render('payStep1',array(
				'model'=>$model,
				'modelPayNotCash'=>$modelPayNotCash
		));
	}
	
	
	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionPayStep1($pay_id = 0, $step = 0)
	{
		$this->step1Action = "//backend/pay/payStep1";
		$this->step2Action	= "//backend/pay/payStep2";
		$this->payStep1($pay_id, $step);
	}
	
	
	/**
	 * 
	 * @param number $pay_id
	 * @param number $step
	 */
	protected function payStep2($pay_id = 0, $step = 0)
	{
		$model = Pay::model()->findByPk($pay_id);
		$modelPayNotCash = PayNotCashInfo::model()->findAll('pay_id = :pay_id AND checked = true', array(':pay_id'=>$pay_id));
		
		$owners = Owner::model()->findAll('person_id = :person_id', array( ':person_id'=> $model->person_id ));
		$locations = array();
		foreach( $owners as $owner )
		{
			$locations[] = $owner->location_id;
		}
		
		$modelViewLocationFeePay = new ViewLocationFeePay('search');
		$modelViewLocationFeePay->feed_id = null;
		$modelViewLocationFeePay->location_id  = $locations;
		$modelViewLocationFeePay->fee_pay_id = null;
		$modelViewLocationFeePay->pay_id = $pay_id;
			
		/* @var $locationFeePay ViewLocationFeePay */
		$locationFeePays = $modelViewLocationFeePay->search()->getData(true);
		
		foreach( $locationFeePays as $locationFeePay )
		{
				
		}
		
		$debtBeforePay = BizLogic::getDebtBeforePay($pay_id);
		$balanceBeforePay = BizLogic::getBalanceBeforePay($pay_id);
		
		$this->render('payStep2',array(
				'model' => $model,
				'modelPayNotCash'=>$modelPayNotCash,
				'modelViewLocationFeePay'=>$modelViewLocationFeePay,
				'debtBeforePay' => $debtBeforePay,
				'balanceBeforePay' => $balanceBeforePay
		));		
	}
	
		
	/**
	 * 
	 * @param number $pay_id
	 * @param number $step
	 */
	public function actionPayStep2($pay_id = 0, $step = 1)
	{				
		
		$this->step2Action = "//backend/pay/payStep2";
		$this->payStep2($pay_id, $step);
	}
	
	
	
	
	/**
	 * 
	 * @param number $pay_id
	 */
	public function actionAjaxNotCashInfo($pay_id = 0)
	{
		$model = Pay::model()->findByPk($pay_id);
		$modelPayNotCash = PayNotCashInfo::model()->findAll('pay_id = :paid_id', array(':paid_id'=>$pay_id));
			
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.ui.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.formatCurrency-1.4.0.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.formatCurrency.es-VE.js'] = false;

		$this->renderPartial('_table_notcashinfo', array( 'model'=>$model, 'modelPayNotCash'=>$modelPayNotCash ), false, true);
	}
		
	
	/**
	 * 
	 */
	public function actionAjaxCreateNotCashInfo($person_id=null, $pay_id=0)
	{		
		$model=new PayNotCashInfo;
		$pay_id=empty($pay_id)?0:$pay_id;

		if(isset($_POST['PayNotCashInfo']))
		{
			$model->attributes=$_POST['PayNotCashInfo'];
			
	
			
			if( $model->validate() )
			{
				if( $model->pay_id == 0)
				{
					$modelPay = new Pay;
					$modelPay->person_id = $person_id;
					$modelPay->pay_date = MipHelper::getCurrentDateDb();
					$modelPay->save(false);
					$model->pay_id = $modelPay->id; 
				}
				if($model->save())
				{			
					echo CHtml::tag("script",array(), 'updatePayNotCash("'.$model->pay_id.'")');
					Yii::app()->end();
				}				
			}
		}
		else
		{
			$model->pay_id=$pay_id;
		} 

		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.ui.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.formatCurrency-1.4.0.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.formatCurrency.es-VE.js'] = false;
		
		$this->renderPartial('ajax/payNotCashInfo/create',array(
				'model'=>$model,
				'person_id'=>$person_id
		),false,true);		
	}
	
	/**
	 *
	 */
	public function actionAjaxDeleteNotCashInfo($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			PayNotCashInfo::model()->deleteByPk($id);		
			echo CHtml::tag("script",array(), '$("#btnRefreshNotCashInfo").click();');
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	/**
	 * 
	 * @param unknown $pay_not_cash_id
	 */
	public function actionAjaxUpdateNotCashInfo($pay_not_cash_id)
	{
		$model= PayNotCashInfo::model()->findByPk( $pay_not_cash_id  );
		
		if(isset($_POST['PayNotCashInfo']))
		{
			$model->attributes=$_POST['PayNotCashInfo'];

			if($model->save())
			{
				echo CHtml::tag("script",array(), 'jQuery("#updatePayNotCashInfoDialog").dialog("close");$("#btnRefreshNotCashInfo").click();');
				Yii::app()->end();
			}
		}
		
		$payModel = Pay::model()->findByPk( $model->pay_id );
		
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.ui.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.formatCurrency-1.4.0.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.formatCurrency.es-VE.js'] = false;
		
		$this->renderPartial('ajax/payNotCashInfo/update',array(
				'model'=>$model,
				'person_id'=>$payModel->person_id
		),false,true);
	}
	
	
	public function ajaxDeleteNotCashInfo()
	{
		$model= PayNotCashInfo::model()->findByPk( $pay_not_cash_id  );
	}
	
	
	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$this->actionPayStep1($id);
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
			$model = $this->loadModel($id);
			$db = Yii::app()->getDb();
			$transaction = $db->beginTransaction();
			
			try
			{
				PayNotCashInfo::model()->deleteAll(' pay_id = :pay_id;',array( ':pay_id' => $model->id ));
				FeePay::model()->deleteAll(' pay_id = :pay_id;',array( ':pay_id' => $model->id ));
				$model->delete();								
				$transaction->commit();
			}
			catch( CDbException $ex )
			{
				$transaction->rollback();
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}
	
	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pay');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new Pay('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pay']))
			$model->attributes=$_GET['Pay'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	* @return Pay
	*/
	public function loadModel($id)
	{
		$model=Pay::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pay-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	/**
	 *
	 * @param integer $location_id
	 */
	public function actionShowReceiptCurrentPay($pay_id)
	{
		$pdf = new KPdf();
		$title = MipHelper::t("Receipt") . " N°: MIP-" . str_pad($pay_id, 6, "0", STR_PAD_LEFT);
		$pdf->setHtmlHeader(array('title'=>$title));
		$pdf->setHtmlFooter(array('title'=>$title));
	
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Asocumica');
		$pdf->SetTitle(Yii::t('app', 'Pay Receipt'));
		$pdf->SetSubject(Yii::t('app', 'Pay Receipt'));
	
	
		// Para agregar nuevas paginas cuando se necesite de forma automatica.
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
		$pdf->Addpage();
	
		$pay = Pay::model()->findByPk($pay_id);
	
		$pdf->writeBodyHTML($this->getReceiptBody($pay));
	
	
		$pdf->Output('Mirador_Recibo_' . $pay_id . '_' . date("d_m_Y"),'I');
	
	}	
	
	
	/**
	 * 
	 * @param Pay $pay
	 */
	protected function getReceiptBody( $pay )
	{		
		$person 				= Person::model()->findByPk( $pay->person_id );
		$payNotCashInfos 		= PayNotCashInfo::model()->findAll('pay_id = :pay_id', array('pay_id'=>$pay->id));
		$payChecked 			= true;
		$NotCashAmount 			= 0;
		$NotCashAmountUnChecked = 0;
		
		foreach($payNotCashInfos as $payNotCashInfo)
		{
			if( !$payNotCashInfo->checked )
			{
				$payChecked = false;
				$NotCashAmountUnChecked += $payNotCashInfo->value;
			}
			$NotCashAmount += $payNotCashInfo->value;
		}	
		
		
		$locationFeePays = ViewLocationFeePay::model()->findAll('pay_id = :pay_id', array( ':pay_id'=>  $pay->id));

		
		return $this->renderPartial('report/receipt/_body', array(	'pay' => $pay,
                                                                                        'person'=>$person, 
                                                                                        'payChecked'=>$payChecked,
                                                                                        'NotCashAmount'=>$NotCashAmount,
                                                                                        'NotCashAmountUnChecked'=>$NotCashAmountUnChecked,
                                                                                        'locationFeePays'=>$locationFeePays,
                                                                        ),
                                                                        true,false);
		
	}
	
	
	/**
	 * 
	 */
	public function actionLocationFeePay()
	{
		$model=new ViewLocationFeePay('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ViewLocationFeePay']))
			$model->attributes=$_GET['ViewLocationFeePay'];
		
		$this->render('location_fee_pay',array(
				'model'=>$model,
		));
	}
	
	
	/**
	 *
	 * @param string $fee_id
	 * @param string $location_id
	 * @param number $pay_id
	 * @param number $step
	 * @throws CHttpException
	 */
	public function actionUpdateSingleFee($fee_id = null, $location_id = null, $pay_id = 0, $step = 1)
	{
		$existPayLocation = $this->existOnePayFeeLocation($fee_id, $location_id);
		if( !$existPayLocation  || (  $existPayLocation && $pay_id > 0) )
		{
			$this->step1Action = "//backend/pay/addSingleFee";
			$this->step2Action	= "//backend/pay/view";
			$this->fee_id = $fee_id;
			$this->location_id = $location_id;
			$this->payStep1($pay_id, $step);
		}
		else
		{
			throw new CHttpException( "500:   Ya se pago la Parcela, actualice la interfaz."   );
		}
	}

	/**
	 * 
	 * @param string $fee_id
	 * @param string $location_id
	 * @param number $pay_id
	 */
	public function actionDeleteSingleFee($fee_id = null, $location_id = null, $pay_id = 0)
	{
		$db = Yii::app()->getDb();
		$transaction = $db->beginTransaction();
		
		try {

			FeePay::model()->deleteAll('pay_id = :pay_id AND location_id = :location_id AND fee_id = :fee_id',
			array('fee_id'=>$fee_id,'location_id'=>$location_id,'pay_id'=>$pay_id));
			
			$count = FeePay::model()->count('pay_id = :pay_id ', array('pay_id'=>$pay_id));
			if( $count == 0)
			{
				PayNotCashInfo::model()->deleteAll('pay_id = :pay_id',array(':pay_id'=>$pay_id));
				Pay::model()->deleteAll('id = :id',array(':id'=>$pay_id));
			}	
			
			$transaction->commit();
		}
		catch(Exception $ex)
		{
			$transaction->rollback();
		}
		
	}
	
	
	/**
	 * 
	 * @param string $fee_id
	 * @param string $location_id
	 * @param number $pay_id
	 * @param number $step
	 * @throws CHttpException
	 */
	public function actionAddSingleFee($fee_id = null, $location_id = null, $pay_id = 0, $step = 1)
	{
		$existPayLocation = $this->existOnePayFeeLocation($fee_id, $location_id);
		if( !$existPayLocation  || (  $existPayLocation && $pay_id > 0) )
		{
			$this->step1Action = "//backend/pay/addSingleFee";
			$this->step2Action	= "//backend/pay/view";
			$this->fee_id = $fee_id;
			$this->location_id = $location_id;
			$this->payStep1($pay_id, $step);
		}
		else
		{
			throw new CHttpException( "500:   Ya se pago la Parcela, actualice la interfaz."   );
		}
	}
	
	/**
	 * 
	 * @param unknown $fee_id
	 * @param unknown $location_id
	 * @return boolean
	 */
	public function existOnePayFeeLocation($fee_id, $location_id)
	{
		$count = FeePay::model()->count('fee_id = :fee_id AND location_id = :location_id',array(':location_id'=>$location_id, ':fee_id'=> $fee_id));
		return ($count > 0);
	}
	
	/**
	 * 
	 * @return boolean
	 */
	protected function isActionAddSingleFee()
	{
		return ($this->getAction()->id == 'addSingleFee');		
	}
}
