<?php

class RegisterRequestController extends Controller
{
	
	const PASSWORD_TMP_VALID = 'Password123.,';
	const PROCESS_REQUEST_STEP_PERSON = 1;
	const PROCESS_REQUEST_STEP_LOCATION = 2;
		
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
		$model=new RegisterRequest;
		
		$model->scenario = "create";
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['RegisterRequest']))
		{
			$model->attributes=$_POST['RegisterRequest'];
			
			$this->fillNamePersonByIdentityType($model);			
			
			if($model->validate())
			{
				$model->user_password = md5($model->user_password);
				$model->save(false);
				$this->redirect(array('view','id'=>$model->id));
			}
				
		}
		
		$this->resetBasic($model);
		
		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	
	/**
	 * 
	 */
	protected function resetBasic($model)
	{
		$model->user_password 			= "";
		$model->user_password_confirm 	= "";
		$model->person_email_confirm	= "";
	}
	
	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$post_request = isset($_POST['RegisterRequest'])?$_POST['RegisterRequest']:null;
		
		$model=$this->loadModel($id);
		$model->scenario = "update";
		
		/*$model->scenario ="change_email";
		$model->scenario ="change_password_and_email";*/
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(!empty($post_request))
		{
			$current_password = $model->user_password;
			$current_email = $model->person_email;
			
			$model->attributes=$post_request;			
			$model->user_password_confirm = isset($post_request['user_password_confirm'])?$post_request['user_password_confirm']:null;
			$model->person_email_confirm = isset($post_request['person_email_confirm'])?$post_request['person_email_confirm']:null;
			
			//
			//  reglas para el password, establece el escenario si se confirma el cambio
			//
			if( empty($model->user_password_confirm) )
			{
				$model->user_password = self::PASSWORD_TMP_VALID;   // cumple la regla con un password temporal (el original MD5 no pasa las validacioens)
			}
			else 
			{
				$model->scenario .= "_password";
			}

			//
			//  reglas para el correo, establece el escenario si se confirma el cambio
			//
			if( empty($model->person_email_confirm) )
			{
				$model->person_email = $current_email;
			}
			else 
			{
				$model->scenario .= "_email";
			}
			
			$this->fillNamePersonByIdentityType($model);

			if($model->validate())
			{
				
				//
				//  el Validate, garantiza que el ConfirmPassword es igual al Password, por lo que debe cifrarse
				//			
				$model->user_password = empty($model->user_password_confirm)? $current_password: md5($model->user_password);
				
				$model->save(false);
				$this->redirect(array('view','id'=>$model->id));
			}
			
		}
		
		$this->resetBasic($model);
		
		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	
	/**
	*
	 */
	protected function fillNamePersonByIdentityType($model)
	{
		if( $this->displayCompany($model)  )
		{
			$model->first_name = Person::NAME_NOT_DEFINED;
			$model->last_name = Person::NAME_NOT_DEFINED;
		
		}
		else
		{
			$model->full_name = Person::NAME_NOT_DEFINED;
		}
	}
	
	
	/**
	 * 
	 * @return boolean
	 */
	protected function displayCompany($model)
	{
		return ( $model->identity_type == Person::IDENTITY_TYPE_COMPANY || $model->identity_type == Person::IDENTITY_TYPE_FIRM || $model->identity_type == Person::IDENTITY_TYPE_GOVERN  );		
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
		$dataProvider=new CActiveDataProvider('RegisterRequest');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new RegisterRequest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RegisterRequest']))
			$model->attributes=$_GET['RegisterRequest'];
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	

	/**
	 * 
	 * Enter description here ...
	 * @param integer $id
	 */
	public function actionBeginProcessRequest($id)
	{
		$request = RegisterRequest::model()->findByPk($id);
	
		$person = Person::model()->find('identity_code = :identity_code AND identity_type = :identity_type',
										array(':identity_code'=>$request->identity_code,':identity_type'=>$request->identity_type));
               
                 if($person==NULL){
                     $person = new Person;
                     
                 }
										
		$person_phone = PersonPhone::model()->find('person_id = :person_id AND is_main = true', array(':person_id'=>$person->id));
		
		$person_email = PersonEmail::model()->find('person_id = :person_id AND is_main = true', array(':person_id'=>$person->id));

		$this->render('beginProcess',array(
			'request'=>$request,
			'person'=>$person,
			'person_email'=>$person_email,
			'person_phone'=>$person_phone
		));
	}
	
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param integer $id
	 * @param boolean $new_person
	 */
	public function actionProcessRequest($id=0)
	{
		/* @var $request RegisterRequest */
		$request = RegisterRequest::model()->findByPk($id);

		$message_fail = "";
		
		if( empty( $request )) 
			throw new CHttpException(404);
			
		
		$person = Person::model()->find('identity_code = :identity_code AND identity_type = :identity_type', array(':identity_code'=>$request->identity_code,':identity_type'=>$request->identity_type));
                if($person==null){
                    $person = new Person;
                }					
		$person_phone = PersonPhone::model()->find('person_id = :person_id AND prefix = :prefix  AND number = :number', array(':person_id'=>$person->id,':prefix'=>$request->phone_prefix, ':number' => $request->phone_number ));
		
		$person_email = PersonEmail::model()->find('person_id = :person_id AND email = :email', array(':person_id'=>$person->id,':email'=>$request->person_email ));
		
		if( isset($_POST["confirm"] )  && $_POST["confirm"] )
		{
					
			/* @var $transaction CDbTransaction */
			$transaction = Yii::app()->getDb()->beginTransaction();
	
			try {
				
				//
				//  Se debe garantizar siempre la Persona, si no existe se crea, si existe se actualiza
				//
				if( empty($person) )
				{
					$person = new Person();
				}
				else 
				{
					$person->group_person_id 	= null;
				}
				
				$person->first_name 		= $request->first_name;
				$person->last_name 			= $request->last_name;
				$person->full_name 			= $request->full_name;
				$person->identity_code 		= $request->identity_code;
				$person->identity_type 		= $request->identity_type;
				$person->active 			= 1;
				
				
				if( $person->save() )
				{
					PersonPhone::model()->deleteAll('person_id = :person_id',array(':person_id'=>$person->id));
					
					//
					//  Se debe garantizar siempre un telefono principal, si no existe se crea
					//
					if( empty($person_phone) )
					{
						$person_phone = new PersonPhone();
						$person_phone->person_id = $person->id;
					}
					
					$person_phone->country_id = MipHelper::getDefaultCountry()->id;
					$person_phone->type 	= $request->phone_type;
					$person_phone->prefix 	= $request->phone_prefix;
					$person_phone->number 	= $request->phone_number;
					$person_phone->is_main  = 1;
	
					//
					//  Se debe garantizar siempre un correo principal, sino existe se crea
					//
					
					PersonEmail::model()->deleteAll('person_id = :person_id',array(':person_id'=>$person->id));
					
					if( empty($person_email) )
					{
						$person_email = new PersonEmail();
					}
					
					$person_email->email 		= $request->person_email;
					$person_email->is_main 		= 1;
					$person_email->person_id 	= $person->id;
					
					if( $person_email->save() && $person_phone->save() )
					{
						
						if( !isset($_POST["not_change_location"] )  )
						{
							// se realiza el cambio de parcelamiento
							$owners = Owner::model()->deleteAll(' person_id = :person_id ',array(':person_id'=>$person->id));
							$location_codes = explode(',', $request->locations);
							$locations = Location::model()->findAllByAttributes( array("code" => $location_codes) );
							
							foreach( $locations as $location )
							{
								$owner = new Owner();
								$owner->person_id = $person->id;
								$owner->location_id = $location->id;
								$owner->begin_date =  new CDbExpression('NOW()');
								
								if( !$owner->save() )
								{
									throw new Exception("Error saving Locations to Owner");
								}
							}
							
						}	
						
						$user 	= new User();
			
						$user->name 		= $request->user_name;
						$user->password 	= $request->user_password;
						$user->is_admin 	= 0;
						$user->person_id 	= $person->id;
	
						if( $user->save() )
						{
							//
							//  Se realiza la asignacion de permisos
							//
							$auth_assigment = new AuthAssignment();
							$auth_assigment->itemname = "";
							$auth_assigment->userid = $user->id;
							
							if( $auth_assigment->save() )
							{
								//  error al guardar los permisos del Usuario
								throw new Exception("Error saving User Permisions Record");
							}

							$transaction->commit();
							
							//
							//  Siendo el registro exitoso, redireccionamos la pantalla
							//
							$this->redirect(array("//backend/registerRequest/processRequestSucessFull", array('id'=>$request->id)));
							
						}
						else 
						{
							//  error al guardar el Usuario del Sistema
							throw new Exception("Error saving User System Record");
						}
					}
					else 
					{
						// Error al Guardar la Información de Correos o Telefonos Personas
						
						throw new Exception("Error saving Email or Phone by Person");
					}
				}
				else 
				{
					//  Erroral Guardar la Información de las Personas
					throw new Exception("Error saving Person");
				}
			}
			catch( Exception $ex )
			{
				$message_fail = $ex->getMessage();
				$transaction->rollback();
			}
			
		}

		
		$this->render('processRequest',array(
			'request'=>$request, 'message_fail' => $message_fail
		));
		
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param integer $id
	 */
	public function actionProcessRequestSucessFull($id)
	{
		$request = RegisterRequest::model()->findByPk($id);
		$this->render("processRequestSucessFull", array('request'=>$request));
	}
	
	
	
	
	
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=RegisterRequest::model()->findByPk($id);
		if($model===null)
		{
                    throw new CHttpException(404,'The requested page does not exist.');
                }
		return $model;
	}
	
	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='register-request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();                        
		}
	}
	
	
}
