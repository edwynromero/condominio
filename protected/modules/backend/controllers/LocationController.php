<?php

class LocationController extends Controller
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
		$model=new Location;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
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
		
		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Location');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new Location('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Location']))
			$model->attributes=$_GET['Location'];
		
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
		$model=Location::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	/**
	 * 
	 * @param integer $location_id
	 */
	public function actionShowReportCurrentDebt($location_id)
	{	
	
                MipHelper::downloadAccountState($location_id);
		//$this->buildReportCurrentDebt($location, 'I', 'Mirador_Panamericano_'.$location->code . '_' . date("d_m_Y").'.pdf');	
               
	}
	
	
	/**
	 * 
	 * @param unknown $location_id
	 * @param string $dest
	 * @return Ambigous <string, mixed, (string)>
	 */
	protected function buildReportCurrentDebt($location, $dest = 'I', $file = null )
	{
		$pdf = new KPdf("P", "mm", "Letter", true, 'UTF-8', false);
		
		$pdf->setHtmlHeader(array('title'=>MipHelper::t("Current Debt Report") ));
		$pdf->setHtmlFooter(array());
		
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Asocumica');
		$pdf->SetTitle(Yii::t('app', 'Current Debt Report'));
		$pdf->SetSubject(Yii::t('app', 'Current Debt Report'));
		
		
		// Para agregar nuevas paginas cuando se necesite de forma automatica.
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
		$pdf->Addpage();
		
		//$pdf->writeBodyHTML("<b>" . CVarDumper::dumpAsString($pdf->getMargins()) . "<b>");
		$pdf->writeBodyHTML($this->getCurrentDebtBodyReport($location));
		
		
		return $pdf->Output( $file, $dest);		
	}
	
	
	/**
	 * 
	 * @param unknown $location_id
	 */
	public function actionSendLocationDebtToEmail($location_id = 0)
	{ 
		//  presentar la lista de propietarios a quienes se enviara el email
		//  si el propietario no tiene correo asocido, prsentar un link para adjuntar el email
		//  tener un link para refrescar en caso de que se haya actualizado el correo de un propietario
		//  los propietarios con correo deben poder tener un checkbox, los que tienen email, y seleccionado por defecto
		//  se envian el correo a los emails asociados, se presenta en pantalle resultado exitosa o fallida de la operacion (por correo)
		
		$model = Location::model()->findByPk($location_id);
		
		
		$criteria = new CDbCriteria();
		$criteria->join = "  
			INNER JOIN " . Owner::model()->tableName() ." o ON ( t.id = o.person_id )
		";
		$criteria->condition = " location_id = :location_id";
		$criteria->params = array(':location_id'=>$location_id);
		
		$persons = Person::model()->findAll($criteria);
		
		$person_email_list = array();
		
		foreach( $persons as $person )
		{
			$emails = PersonEmail::model()->findAll( " person_id = :person_id ", array('person_id'=>$person->id) );
			foreach( $emails as $email )
			{
				$person_email_list[] = array( 'person'=>$person, 'email'=>$email );
			}
			if( count($emails) == 0 ) $person_email_list[] = array( 'person'=>$person, 'email'=>null );
		}
		
	
		return $this->render('send_debt_by_email', array('model'=>$model, 'person_email_list'=>$person_email_list, 'location_id'=>$location_id ));
			
	}
	
	
	/**
	 * 
	 * @param unknown $location_id
	 * @param unknown $email
	 */
	public function actionSendDebtReportToEmail($location_id, $person_mail_id)
	{ 
		/* var @location Location */
		$location = Location::model()->findByPk($location_id);
                
		$report_pdf_file =  Yii::getPathOfAlias('webroot') . '/reports/' . MipHelper::getLocationAccountStateReportFileName($location->code) . ".pdf";
                    
                
		MipHelper::saveToFileAccountState($location->id, $report_pdf_file);
		
		$person_email = PersonEmail::model()->findByPk( $person_mail_id );
		
		$message_error = MipHelper::t("Don't exist the email or owner".".");
		
		if( !is_null($person_email) )
		{
			/* @var $person Person */
			$person = Person::model()->findByPk($person_email->person_id);
			if( !is_null($person) )
			{
				try
				{
					Yii::app()->dpsMailer->sendByView(
						array( $person_email->email => $person->getFullNameEmail() ),
						'backend/location/email_debt', // template email view
						array( 'sUsername' =>$person->getFullNameEmail(),
							'sLocationCode'=>$location->code,
							'sLogoPicPath' => Yii::app()->theme->basePath . '/img/logo_mirador_small.jpg',
							'sFilePath' => $report_pdf_file,)
					);
					echo json_encode( array( 'process'=>true, 'data'=>array('location_id'=> $location_id, 'person_mail_id' => $person_mail_id ) ) );
                                        if (file_exists( $report_pdf_file )) {
                                            unlink($report_pdf_file);
                                        }
                                        
					Yii::app()->end();
				}
				catch (Exception $ex )
				{
					$message_error =  $ex->getMessage();
				}			
			}
		}
                if (file_exists( $report_pdf_file )) {
                    unlink($report_pdf_file);
                }
		echo json_encode( array( 'process'=>false, 'error' => $message_error) );
	}
	
	
	/**
	 * Obtiene el HTML del Cuerpo del Reporte Deuda Actual de la Parcela
	 * @param Location $location 	Parcela
	 */
	private function getCurrentDebtBodyReport($location)
	{
		
		$owners = Owner::model()->findAll('location_id = :location_id AND end_date IS NULL',array(':location_id'=>$location->id));
		
		
		$criteria = new CDbCriteria();	
		$criteria->join =  " LEFT JOIN " . Pay::model()->tableName() . " p ON ( t.pay_id = p.id )";
                $criteria->condition = " location_id = :location_id AND begin_date <  CURDATE()";
		$criteria->params = array(":location_id" => $location->id);
		$criteria->order = " p.pay_date DESC, begin_date DESC ";
		
		$count_feeds = ViewLocationFeePay::model()->count($criteria);
				
		$locationFeePays = ViewLocationFeePay::model()->findAll( $criteria );
		$locationFeePayToShow = array();
		
		$command = Yii::app()->getDb()->createCommand();
		$command->text = " SELECT SUM(value_pay) as payed FROM " . ViewAllPayedByLocation::model()->tableName() ." WHERE location_id = :location_id";
		
		$total_payed = $command->queryScalar(array(':location_id'=>$location->id));
		
		$debt 				=	$location->initial_debt;
		$last_pay 			= null;
		$valuePayNotCash 	= 0;
		$feeNotPayed		= 0;
		$feePayed 			= 0;
		$valuePayNotCashUnChecked = 0;
		
		foreach( $locationFeePays as $key => $locationFeePay )
		{
			if( $locationFeePay->fee_payed )
			{
				/* @var $last_pay Pay */
				
				if( is_null($last_pay) )
				{
					$last_pay = Pay::model()->findByPk($locationFeePay->pay_id);
					$resultPayNotCash = $last_pay->getValueNotCash();
					$valuePayNotCash = $resultPayNotCash["checked"] + $resultPayNotCash["unchecked"];	
					$valuePayNotCashUnChecked = $resultPayNotCash["unchecked"];
				}	

				$feePayed += $locationFeePay->value;
			}
			else
			{
				$feeNotPayed += 1;
				$debt += $locationFeePay->value;
				//  se seleccionan las ultimas cuotas sin pagar
				$locationFeePayToShow[] = $locationFeePay;
			}			
		}
		
		$total_payed = $total_payed - $feePayed;
		
		return $this->renderPartial('report/currentDebt/_body', array('location'=>$location, 'owners'=> $owners, 'debt'=>$debt, 'feeds_not_payed' => $locationFeePayToShow, 'total_feeds_not_payed' => $count_feeds, 'last_pay' => $last_pay, 'value_pay_not_cash' => $valuePayNotCash, 'valuePayNotCashUnChecked' =>$valuePayNotCashUnChecked, 'feeNotPayed' =>$feeNotPayed, 'total_payed'=>$total_payed ), true,false);
	}
	
}
