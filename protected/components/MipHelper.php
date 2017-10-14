<?php

/**
 * 
 * @author Koiosoft
 *
 */
class MipHelper
{
	const ROLE_ASSOCIATION = 'association';
	const ROLE_ADMIN = 'admin';
        const PARAM_REPORT_KEY = 'report';
        const PARAM_BANK_ACCOUNT_KEY = 'bank_account';
        const PARAM_MAX_YEARS_BANKACCOUNT_KEY = "year_max";
        const PARAM_MONTHS_BANKACCOUNT_KEY = "months";
        const PARAM_PATH_TO_UPLOAD_BANK_RESUME = "path_to_upload_bank_resume";
        
        
        /**
         * Parse strin numeric Venezolano 
         * 
         * @param string $value
         * @return float
         */
        public static function formatNumberToDb( $value ){
            return floatval(str_replace(',', '.', str_replace('.', '', $value )));
        }
        
        /**
         * Obtiene el Path para Subir la Lista de Transacciones Mensuales de la Cuenta
         */
        public static function getPathToUploadBankResume(){
            $relativePath = Yii::app()->params[self::PARAM_PATH_TO_UPLOAD_BANK_RESUME];
            return Yii::getPathOfAlias('webroot') . $relativePath;
        }
        
        
        /**
         * 
         * @return type
         */
        public static function getBankAccountParameters(){
            return Yii::app()->params[self::PARAM_BANK_ACCOUNT_KEY];
        }
        
        /**
         * Obtienes los años disponibles para la carga transacciones bancarias
         */
        public static function getYearLisBankAccountSummary(){
            $parameters = self::getBankAccountParameters();
            $currentYear = date("Y");
            $years = [];
            $max = $parameters[self::PARAM_MAX_YEARS_BANKACCOUNT_KEY];

            for($i = 0; $i <= $max; $i++){
                $years[$currentYear - $i] = $currentYear - $i;
            }
            
            return $years;
        }
        
        
        /**
         * 
         */
        public static function getMonthListBankAccountSummary(){
            $parameters = self::getBankAccountParameters();
            $months = $parameters[self::PARAM_MONTHS_BANKACCOUNT_KEY];
            foreach($months as $key => $month){
                $months[$key] = MipHelper::t($month);
            }
            
            return $months;
        }

        
        /**
         * 
         * @param date $date
         */
        public static function getLocationAccountStateReportFileName($location_code, $date=null){
            
            $parameters = Yii::app()->params[self::PARAM_REPORT_KEY];
            
            if(is_null($date)){
                $date =  date("d-m-Y");
            }
            
            $report_name = str_replace( "@location@", $location_code, self::t($parameters["account_state_download_filename"]) );
            $report_name = str_replace( "@date@", $date, $report_name );
            
            return str_replace("-", "_", $report_name );
        }
        
        
        /**
         * 
         * @param date $date
         */
        public static function getDefaultReportFileName($date=null){
            
            if(is_null($date)){
                $date =  date("d-m-Y");
            }
            $date = str_replace("-", "_", $date);
            $parameters = Yii::app()->params[self::PARAM_REPORT_KEY];
            return str_replace("d/m/y", $date, self::t($parameters["defaults_download_filename"]));
        }
	
	/**
	 * 
	 * @param unknown $model
	 * @return multitype:multitype:multitype:string  string
	 */
	public static function getMenuToList($model)
	{
		return array(
				array('label'=>self::getCreateLabelMenu($model),'url'=>array('create')),
				array('label'=>self::getManageLabelMenu($model),'url'=>array('admin')),
		);
	}
	
	
	/**
	 *
	 * @param unknown $model
	 * @return multitype:multitype:multitype:string  string  multitype:multitype:string NULL  string
	 */
	public static function getMenuToAdmin($model)
	{
		return array(
				array('label'=>self::getListLabelMenu($model),'url'=>array('index')),
				array('label'=>self::getCreateLabelMenu($model),'url'=>array('create')),
		);
	}
	
	/**
	 *
	 * @param unknown $model
	 * @return multitype:multitype:multitype:string  string  multitype:multitype:string NULL  string
	 */
	public static function getMenuToCreate($model)
	{
		return array(
				array('label'=>self::getListLabelMenu($model),'url'=>array('index')),
				array('label'=>self::getManageLabelMenu($model),'url'=>array('admin')),
		);
	}	
	
	
	/**
	 * 
	 * @param unknown $model
	 * @return multitype:multitype:multitype:string  string  multitype:multitype:string NULL  string
	 */
	public static function getMenuToUpdate($model)
	{
		return array(
				array('label'=>self::getListLabelMenu($model),'url'=>array('index')),
				array('label'=>self::getCreateLabelMenu($model),'url'=>array('create')),				
				array('label'=>self::getViewLabelMenu($model),'url'=>array('view','id'=>$model->id)),
				array('label'=>self::getManageLabelMenu($model),'url'=>array('admin')),
		);
	}
	
	/**
	 * 
	 * @param unknown $model
	 * @return multitype:multitype:multitype:string  string  multitype:multitype:string NULL  string  multitype:string multitype:string multitype:string NULL
	 */
	public static function getMenuToView($model)
	{
		return array(
				array('label'=>self::getListLabelMenu($model),'url'=>array('index')),
				array('label'=>self::getCreateLabelMenu($model),'url'=>array('create')),
				array('label'=>self::getUpdateLabelMenu($model),'url'=>array('update','id'=>$model->id)),
				array('label'=>self::getDeleteLabelMenu($model),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
				array('label'=>self::getManageLabelMenu($model),'url'=>array('admin')),
		);
	}
	
	
	/**
	 *
	 * @param unknown $model
	 */
	public static function getViewLabelMenu($model)
	{
                        return self::getGeneralLabelMenu("View", $model);
	}	
	
	/**
	 * 
	 * @param unknown $model
	 */
	public static function getListLabelMenu($model)
	{
		return self::getGeneralLabelMenu("List", $model);
	}
	
	
	/**
	 * 
	 * @param unknown $model
	 * @return string
	 */
	public static function getCreateLabelMenu($model)
	{
		return self::getGeneralLabelMenu("Create", $model);
	}
	
	/**
	 * 
	 * @param unknown $model
	 * @return string
	 */
	public static function getDeleteLabelMenu($model)
	{
		return self::getGeneralLabelMenu("Delete", $model);
	}	
	
	
	/**
	 * 
	 * @param unknown $model
	 * @return string
	 */
	public static function getUpdateLabelMenu($model)
	{
		return self::getGeneralLabelMenu("Update", $model);
	}	
	
	
	/**
	 * 
	 * @param unknown $model
	 * @return string
	 */
	public static function getManageLabelMenu($model)
	{
		return self::getGeneralLabelMenu("Manage", $model);
	}	
	
	
	/**
	 * 
	 * @param unknown $action
	 * @param unknown $model
	 * @return string
	 */
	public static function getGeneralLabelMenu($action, $model)
	{		
		if( get_class($model) == "CActiveDataProvider" ) $model = $model->model;
		return self::t($action). ' ' .self::t( get_class($model));
	}
	
	/**
	 * 
	 * @param unknown $var
	 * @param string $disableDump
	 */
	public static function log($var, $disableDump = false)
	{
		if( $disableDump )
			Yii::log( $var );
		else
			Yii::log( CVarDumper::dumpAsString($var));
	}
	
	
	/**
	 * 
	 * @param unknown $value
	 * @return Ambigous <string, mixed>
	 */
	public static function formatCurrency( $value, $currency = "Bs. " )
	{
		$nf = new CNumberFormatter("es_VE");
		return $nf->formatCurrency($value, $currency); 
	}
	
	
	/**
	 * 
	 * @param unknown $pay_id
	 */
	public static function getPayNotCashInfoBalance($pay_id)
	{
		$command = Yii::app()->getDb()->createCommand();
		$command->text = "SELECT * FROM view_pay_not_cash_summary WHERE pay_id = :pay_id;"; 
		$result =  $command->queryRow(true, array(':pay_id'=>$pay_id));
		if( $result == false )
		{
			return array(
			    'pay_id' => $pay_id,
			    'pay_unchecked' => 0,
			    'pay_checked' => 0,
			);
		}	
		return $result;	
	}
	
	
	/**
	 * 
	 * @param unknown $person_id
	 */
	public static function getTotalFeeByPersonId( $person_id )
	{
		$command = Yii::app()->getDb()->createCommand();
		$command->text = "SELECT total FROM view_sum_fee_by_person WHERE person_id = :person_id";
		$result = $command->queryScalar(array(':person_id'=>$person_id));		
		return empty($result)?0:$result;		
	} 
	
	
	/**
	 *
	 * @param unknown $person_id
	 */
	public static function getPayedFeeByPersonId( $person_id )
	{
		$command = Yii::app()->getDb()->createCommand();
		$command->text = "SELECT total FROM view_sum_fee_payed_by_person WHERE person_id = :person_id";
		$result = $command->queryScalar(array(':person_id'=>$person_id));
		return empty($result)?0:$result;
	}	
	
	
	/**
	 *  Obtiene la deuda de la Persona por el ID
	 * @param unknown $person_id
	 */
	public static function getDebtFeeByPersonId( $person_id )
	{
		 $total_feed = self::getTotalFeeByPersonId($person_id);
		 $payed_feed = self::getPayedFeeByPersonId($person_id);
		 return $total_feed - $payed_feed;
	}
	
	
	
	
	/**
	 *
	 * @param unknown $person_id
	 */
	public static function getAmountPayedPersonId( $person_id )
	{
		$command = Yii::app()->getDb()->createCommand();
		$command->text = "SELECT value  FROM view_ammount_payed_by_person  WHERE person_id = :person_id";
		$result = $command->queryScalar(array(':person_id'=>$person_id));
		return empty($result)?0:$result;
	}
	
	
	
	
	
	/**
	 * Obtiene el Saldo de una Persona según sus pagos
	 * @param integer $person_id
	 */
	public static function getPayBalancePersonId( $person_id )
	{
		$payedAll = self::getAmountPayedPersonId($person_id);
		$feePayed = self::getPayedFeeByPersonId($person_id);
		return $payedAll - $feePayed;
	}
	
	
	
	/**
	 * Retorna la fecha del formato ES-VE (dd/MM/yyyy) a  Mysql (yyyy-MM-dd)
	 * @param string $date
	 * @return string
	 */
	public static function parseDateToDb( $date )
	{
		$timestamp=CDateTimeParser::parse($date,'dd/MM/yyyy');
		$formatter = new CDateFormatter(null);
		return $formatter->format('yyyy-MM-dd', $timestamp);
	}
    
    
    /**
	 * Retorna la fecha del formato Mysql (yyyy-MM-dd) a timestamp
	 * @param string $date
	 * @return string
	 */
	public static function parseTimestampFromDateDb( $date )
	{
		if( !is_null( $date ) )
		{
			return CDateTimeParser::parse($date,'yyyy-MM-dd');	
		}
		else 
			return null;
	}
	
	/**
	 * Retorna la fecha del formato Mysql (yyyy-MM-dd) a ES-VE (dd/MM/yyyy)
	 * @param string $date
	 * @return string
	 */
	public static function parseDateFromDb( $date )
	{
		if( !is_null( $date ) )
		{
			$timestamp=CDateTimeParser::parse($date,'yyyy-MM-dd');
			$formatter = new CDateFormatter(null);
			return $formatter->format('dd/MM/yyyy', $timestamp);	
		}
		else 
			return '';
	}
    
    
    
    /**
	 * Retorna la fecha del formato Mysql (yyyy-MM-dd) a ES-VE (dd/MM/yyyy)
	 * @param string $date
	 * @return string
	 */
	public static function parseDayDateFromDb( $date )
	{
		if( !is_null( $date ) )
		{
			$timestamp=CDateTimeParser::parse($date,'yyyy-MM-dd');
			$formatter = new CDateFormatter(null);
			return $formatter->format('dd', $timestamp);	
		}
		else 
			return '';
	}
    
        
	/**
	 * Retorna la fecha del formato Mysql (yyyy-MM-dd) a ES-VE (dd/MM/yyyy)
	 * @param string $date
	 * @return string
	 */
	public static function parseYearDateFromDb( $date )
	{
		if( !is_null( $date ) )
		{
			$timestamp=CDateTimeParser::parse($date,'yyyy-MM-dd');
			$formatter = new CDateFormatter(null);
			return $formatter->format('yyyy', $timestamp);	
		}
		else 
			return '';
	}
        
        
        
        
 	/**
	 * Retorna la fecha del formato Mysql (yyyy-MM-dd) a ES-VE (dd/MM/yyyy)
	 * @param string $date
	 * @return string
	 */
	public static function parseMonthDateFromDb( $date )
	{
		if( !is_null( $date ) )
		{
			$timestamp=CDateTimeParser::parse($date,'yyyy-MM-dd');
			$formatter = new CDateFormatter(null);
			return $formatter->format('MM', $timestamp);	
		}
		else 
			return '';
	}
        
        
	/**
	 * Retorna la fecha del formato Mysql (yyyy-MM-dd) a ES-VE (dd/MM/yyyy)
	 * @param string $date
	 * @return string
	 */
	public static function parseYearMonthDateFromDb( $date )
	{
		if( !is_null( $date ) )
		{
			$timestamp=CDateTimeParser::parse($date,'yyyy-MM-dd');
			$formatter = new CDateFormatter(null);
			return $formatter->format('yyyy-MM', $timestamp);	
		}
		else 
			return '';
	}
        

	/**
	 * 
	 * @param string $dateLeft
	 * @param string $operator
	 * @param string $dateRight
	 */
	public static function dateIsLessEqualThan($dateLeft, $dateRight)
	{
		$timestampLeft=CDateTimeParser::parse($dateLeft,'yyyy-MM-dd');
		$timestampRight=CDateTimeParser::parse($dateRight,'yyyy-MM-dd');

		return ( $timestampLeft <= $timestampRight );
	}
	
	
	/**
	 * Retorna la fecha actual en MYSQL (yyyy-MM-dd)
	 * @return string
	 */
	public static function getCurrentDateDb()
	{
		$formatter = new CDateFormatter(null);
		return $formatter->format('yyyy-MM-dd', time());
	}

	
	/**
	 * 
	 * @param boolean $value
	 * @return string
	 */
	public static function showYesNo($value)
	{
		return $value?'Sí':'No';
	}
	
	/**
	 *	Value puede tener los siguientes valores:
	 *  - 0: No Verificado
	 *  - 1: Verificado
	 * @param boolean $value
	 * @return string
	 */
	public static function showCheckedIcon($value)
	{		
		switch($value)
		{
			case 0:
				$class = "icon-time";
				break;
			case 1:
				$class = "icon-ok";
				break;
			case 2:
				$class = "icon-remove";
				break;
			default:
				$class = "icon-time";
				break;
		}
		return CHtml::tag('div',array('class'=>$class),false,true);
	}
	
	

	/**
	 *
	 * @param boolean $value
	 * @return string
	 */
	public static function getYesNoOptions()
	{
		return array(1=>self::t('Yes'), 0=>self::t('No'));
	}	
	
	/**
	 *
	 * @param boolean $value
	 * @return string
	 */
	public static function getActiveOptions()
	{
		return array('A'=>self::t('Active'), 0=>self::t('No Active'));
	}	
	
	/**
	 * 
	 * @param unknown $date
	 * @return Ambigous <string, unknown>
	 */	
	public static function cleanDate( $date )
	{
		return $date=='0000-00-00'?'':$date;
	}
	
	/**
	 * 
	 * @param unknown $message
	 * @param string $category
	 * @return Ambigous <string, string, unknown>
	 */
	public static function t( $message, $category = "app")
	{
		return Yii::t($category, $message);
	}
	
	
	/**
	 * 
	 * @return Ambigous <CActiveRecord, mixed, NULL, multitype:CActiveRecord , multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDefaultCountry()
	{
		$iso_code = Yii::app()->params['default_country'];		
		return Country::model()->find('iso_code = :iso_code', array( 'iso_code' => $iso_code));
	}
	
	
	/**
	 * 
	 */
	public static function getBankListUserInTransfer()
	{
		$criteria = new CDbCriteria();
		$criteria->join = " INNER JOIN mip_pay_not_cash_info pnci ON ( t.id = pnci.source_bank_id ) ";
		
		return Bank::model()->findAll( $criteria );
		
	}
	
	
	/**
	 * Lista de los Tipos de Telefonos
	 */
	public static function getNotCashTypeList()
	{
		return  Yii::app()->params['not_cash_type_list'];
	}
	
	/**
	 * Lista de los Tipos de Telefonos
	 */
	public static function getPhoneTypeList()
	{
		return  Yii::app()->params['phone_type'];
	}	
	
	
	/**
	 * Lista de los Tipos de Telefonos
	 */
	public static function getEmailTypeList()
	{
		return  Yii::app()->params['email_type'];
	}

	/**
	 *
	 **/
	public static function getGroupPersonsTypeList()
	{
		return  Yii::app()->params['group_persons_type_list'];
	}	
	
	
	/**
	 *
	 **/
	public static function getIdentityTypeList()
	{
		return  Yii::app()->params['identity_type_list'];
	}
	
	
	/**
	 * 
	 */
	public static function getAccountTypeList()
	{
		return  BankAccount::getAccountTypeList();
	}
	
	/**
	 * 
	 */
	public static function getLocationStatusList()
	{
		return  Yii::app()->params['location_status_list'];
	}
	
	
	/**
	 * 
	 */
	public static function getDataLocations()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "code ASC";
		return GxHtml::listData(Location::model()->findAll($criteria), "id","code");	
	} 
	
	/**
	 * 
	 * @param unknown $id
	 */
	public static function getLocationCode($id)
	{
		$model = Location::model()->findByPk($id);
		return $model?$model->code:"";
	}
	

	/**
	 * 
	 * @param unknown $id
	 * @return string
	 */
	public static function getPayFullReference($id)
	{
		$model = Pay::model()->findByPk($id);
		return $model?$model->FullReference:"";
	}
	
	
	/**
	 * 
	 * @param unknown $id
	 * @return string
	 */
	public static function getFeeFullReference($id)
	{
		$model = Fee::model()->findByPk($id);
		return $model?$model->FullReference:"";
	}
	
	
	/**
	 *
	 * @param unknown $id
	 * @return string
	 */
	public static function getBankAccountFullReference($id)
	{
		/* @var $model BankAccount */
		$model = BankAccount::model()->findByPk($id);
		return $model?$model->FullReference:"";
	}	
	
	
	/**
	 *
	 * @param unknown $id
	 * @return string
	 */
	public static function getBankAccountShortReference($id)
	{
		/* @var $model BankAccount */
		$model = BankAccount::model()->findByPk($id);
		return $model?$model->ShortReference:"";
	}
	
	/**
	 *
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getNotCashTypeName($key)
	{
		$list = self::getNotCashTypeList();
		return $list[$key];
	}	
	
	
	/**
	 *
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getNotCashTypeShortName($key)
	{
		$list = self::getNotCashTypeList();
		return substr($list[$key], 0, 5); ;
	}
	
	
	/**
	 *
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getPhoneTypeName($key)
	{
		$list = self::getPhoneTypeList();
		return $list[$key];
	}

	/**
	 *
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getEmailTypeName($key)
	{
		$list = self::getEmailTypeList();
		return $list[$key];
	}	
	
	/**
	 *
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getGroupPersonTypeName($key)
	{
		$list = self::getGroupPersonsTypeList();
		return $list[$key];
	}	
	
	
	/**
	 * 
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getLocationStatusName($key)
	{
		$list = self::getLocationStatusList();
		return $list[$key];		
	}
	
	
	/**
	 * 
	 * @param unknown $key
	 * @return unknown
	 */
	public static function getAccountTypeName($key)
	{
		$list = self::getAccountTypeList();
		return $list[$key];
	}
	
	
	/**
	 * Obtiene la Lista de Bancos excluyendo un Key en particular
	 * @todo Hace la exclusion de una lista de keys
	 * @param string $excludeKey
	 * @return Ambigous <multitype:, mixed, multitype:unknown mixed >
	 */
	public static function getDataBanks($excludeKey = null)
	{
		
		$criteria = new CDbCriteria();
		$criteria->order = "name ASC";
		$bankList = Bank::model()->findAll($criteria);
		
		/**
		 * @var $bank Bank
		 */
		foreach( $bankList as $key => $bank )
		{
			if( $bank->akey  == $excludeKey )
			{
				unset( $bankList[$key] );
				break;
			}
		}
		
		return GxHtml::listData($bankList, "id","name");
	}
	
	
	/**
	 * 
	 * @param unknown $id
	 */
	public static function getBankName($id)
	{
		$model = Bank::model()->findByPk($id);
		return $model?$model->name:"";
	}
	
	/**
	 *
	 * @param unknown $id
	 */
	public static function getShortBankName($id)
	{
		$model = Bank::model()->findByPk($id);
		return substr($model?$model->name:"", 0, 5);
	}	
	

	/**
	 * 
	 * @param unknown $id
	 */
	public static function getGroupPersonName($id)
	{
		$model = GroupPerson::model()->findByPk($id);
		return $model?$model->name:"";
	}
	
	/**
	 *
	 * @param unknown $id
	 */
	public static function getPersonName($id)
	{
		$model = Person::model()->findByPk($id);
		return $model?$model->fullNameList:"";
	}	
	
	/**
	 *
	 * @param unknown $id
	 */
	public static function getAssociationPositionName($id)
	{
		$model = AssociationPosition::model()->findByPk($id);
		return $model?$model->name:"";
	}	
	
	
	public static function getDataPersons()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "first_name ASC, last_name ASC, full_name ASC";
		return GxHtml::listData(Person::model()->findAll($criteria), "id","FullNameList");
	}
	
	
	/**
	 * 
	 * @return array
	 */
	public static function getDataOwnerPersons($location_id = null)
	{
		$criteria = new CDbCriteria();
		$criteria->order = "first_name ASC, last_name ASC, full_name ASC";
		$criteria->join = "
				INNER JOIN mip_owner ow ON ( t.id = ow.person_id )
				INNER JOIN mip_location l ON ( l.id = ow.location_id )				
		";
		if( !is_null($location_id))
		{
			$criteria->condition = " l.id = :location_id ";
			$criteria->params = array(":location_id"=>$location_id);
		}
		return GxHtml::listData(Person::model()->findAll($criteria), "id","FullNameList");		
	}
	
	
	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataGroupPerson()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "name ASC";
		return GxHtml::listData(GroupPerson::model()->findAll($criteria), "id","name");
	}	
	
	/**
	 * 
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataCountries()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "name ASC";		
		return GxHtml::listData(Country::model()->findAll($criteria), "id","name");
	}
	
	
	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataAssociationPosition()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "name ASC";
		return GxHtml::listData(AssociationPosition::model()->findAll($criteria), "id","name");
	}
	
	
	/**
	 * 
	 * @param unknown $id
	 * @return string
	 */
	public static function getFeeTypeName($id)
	{
		$model = FeeType::model()->findByPk($id);
		return $model?$model->title:"";
	}


	/**
	 *
	 * @param unknown $id
	 * @return string
	 */
	public static function getFeeScheduleName($id)
	{
		$model = FeeSchedule::model()->findByPk($id);
		return $model?$model->name:"";
	}
	
	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataFeeType($active=true)
	{
		$criteria = new CDbCriteria();
		$criteria->order = "title ASC";
		if( !empty($active))
		{
			$criteria->addCondition("active = :active");
			$criteria->params = array(":active"=>$active);
		}
		return GxHtml::listData(FeeType::model()->findAll($criteria), "id","title");
	}	
	

	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataFeeSchedule($active=true)
	{
		$criteria = new CDbCriteria();
		$criteria->order = "name ASC";
		if( !empty($active))
		{
			$criteria->addCondition("active = :active");
			$criteria->params = array(":active"=>$active);
		}
		return GxHtml::listData(FeeSchedule::model()->findAll($criteria), "id","name");
	}
	
	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataFee()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "name ASC";
		return GxHtml::listData(Fee::model()->findAll($criteria), "id","FullReference");
	}
	
	
	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataPay()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "id DESC";
		return GxHtml::listData(Pay::model()->findAll($criteria), "id","FullReference");
	}	
	
	
	/**
	 *
	 * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
	 */
	public static function getDataBankAccount()
	{
		$criteria = new CDbCriteria();
		$criteria->order = "number DESC";
		return GxHtml::listData(BankAccount::model()->findAll($criteria), "id","FullReference");
	}	
		
	/**
	 * 
	 * @param integer $id
	 */
	public static function getCountryName($id)
	{
		$model = Country::model()->findByPk($id);
		return $model?$model->name:"";
	}
	
	
	/**
	 * Obtiene el Link persona
	 * @param integer $id
	 */
	public static function createPersonLinkById($id, $target="blank")
	{
		$title = MipHelper::getPersonName($id);
		return CHtml::link($title, Yii::app()->controller->createUrl('//backend/person/view', array('id'=>$id)), array('target'=>'blank'));
	}
        
        /**
	 * Obtiene el Link persona
	 * @param integer $id
	 */
	public static function createPersonLink($person)
	{
		return CHtml::link($person->fullNameList, Yii::app()->controller->createUrl('//backend/person/view', array('id'=>$person->id)), array('target'=>'blank'));
	}
	
	
	/**
	 * Obtiene el Link Parcela
	 * @param integer $id
	 */
	public static function createLocationLink($id, $target="blank")
	{
		$title = MipHelper::getLocationCode($id);
		return CHtml::link($title, Yii::app()->controller->createUrl('//backend/location/view', array('id'=>$id)), array('target'=>'blank'));
	}
        
        
        /**
	 * Obtiene el Link Parcela
	 * @param integer $id
	 */
	public static function createLocationCodeLink($id, $code, $target="blank")
	{
		return CHtml::link( $code, Yii::app()->controller->createUrl('//backend/location/view', array('id'=>$id)), array('target'=>'blank'));
	}
	

	/**
	 * Obtiene el Link Parcela
	 * @param integer $id
	 */
	public static function createFeedLink($id, $target="blank")
	{
		$title = MipHelper::getFeeFullReference($id);
		return CHtml::link($title, Yii::app()->controller->createUrl('//backend/fee/view', array('id'=>$id)), array('target'=>'blank'));
	}
		
	
	/**
	 * 
	 * @return string
	 */
	public static function getHtmlFieldRequiered()
	{
		return '<p class="help-block">' .  MipHelper::t('The fields with') . ' <span class="required">*</span> ' . MipHelper::t('are requiered') .'.</p>';
	}
	
	
	/**
	 * Check if a string is a valid date(time)
	 *
	 * DateTime::createFromFormat requires PHP >= 5.3
	 *
	 * @param string $date
	 * @return bool
	 */
	public static function isValidDate($date) {
		$timestamp = CDateTimeParser::parse($date,'dd/MM/yyyy');
		return $timestamp?true:false;
	}
	
	
	/**
	 * 
	 * @param unknown $fee_pay_id
	 * @return string
	 */
	public static function getPayerName( $fee_pay_id )
	{
		if( empty($fee_pay_id) ) return "";
		
		$criteria = new CDbCriteria();
		$criteria->join = " INNER JOIN " . Pay::model()->tableName() . " p ON ( t.id = p.person_id  )";
		$criteria->join .= " INNER JOIN " . FeePay::model()->tableName() . " fp ON ( p.id = fp.pay_id ) ";
		$criteria->condition = " fp.id = :fee_pay_id ";
		$criteria->params = array(':fee_pay_id'=>$fee_pay_id);
		
		/** @var $person Person **/
		$person = Person::model()->find($criteria);

		return $person->getFullNameList();
	}
	
	
	/**
	 *
	 * @param unknown $fee_pay_id
	 * @return string
	 */
	public static function getPayerNameByPayId( $pay_id )
	{
		if( empty($pay_id) ) return "";
	
		$criteria = new CDbCriteria();
		$criteria->join = " INNER JOIN " . Pay::model()->tableName() . " p ON ( t.id = p.person_id  )";
		$criteria->condition = " p.id = :pay_id ";
		$criteria->params = array(':pay_id'=>$pay_id);
	
		/** @var $person Person **/
		$person = Person::model()->find($criteria);
	
		return $person->getFullNameList();
	}
	
	
	/**
	 *
	 * @param unknown $fee_pay_id
	 * @return string
	 */
	public static function getPayDate( $fee_pay_id )
	{
		if( empty($fee_pay_id) ) return "";
		
		$criteria = new CDbCriteria();
		$criteria->join = " INNER JOIN " . FeePay::model()->tableName() . " fp ON ( t.id = fp.pay_id ) ";
		$criteria->condition = " fp.id = :fee_pay_id ";
		$criteria->params = array(':fee_pay_id'=>$fee_pay_id);
		
		$pay = Pay::model()->find($criteria);
		return self::parseDateFromDb( $pay->pay_date );
	}	
        
        
        /**
         * 
         * @param Pay $pay
         */
        public static function getCreditBalanceBeforePay($pay = null)
        {
            
            if( $pay != null )
            {
                
                $command = Yii::app()->db->createCommand();
                $command->text = " SELECT SUM(p.value_cash) FROM mip_pay p WHERE ( p.pay_date <= :pay_date ) AND ( p.id <> :pay_id ) AND ( p.person_id = :person_id ) ";
                $command->params = [":pay_date" => $pay->pay_date, ":pay_id" => $pay->id, ':person_id' => $pay->person_id];
                $payed_cash = $command->queryScalar();
                
                $command = Yii::app()->db->createCommand();
                $command->text = " 
                    SELECT 
                        SUM(pnc.value) 
                    FROM 
                        mip_pay_not_cash_info pnc
                            INNER JOIN mip_pay p 
                                ON (p.id = pnc.pay_id )
                    WHERE ( p.pay_date <= :pay_date ) AND ( p.id <> :pay_id ) AND ( p.person_id = :person_id ) AND ( pnc.checked = true )
                ";
                $command->params = [":pay_date" => $pay->pay_date, ":pay_id" => $pay->id, ':person_id' => $pay->person_id];
                $payed_cash_not_cash = $command->queryScalar();                
                
                $command = Yii::app()->db->createCommand();
                $command->text = " 
                    SELECT 
                        SUM(f.value) 
                    FROM 
                        mip_fee f
                            INNER JOIN mip_fee_pay fp
                                ON ( f.id = fp.fee_id )
                            INNER JOIN mip_pay p 
                                ON ( p.id = fp.pay_id )
                    WHERE ( p.pay_date <= :pay_date ) AND ( p.id <> :pay_id ) AND ( p.person_id = :person_id ) 
                ";
                $command->params = [":pay_date" => $pay->pay_date, ":pay_id" => $pay->id, ':person_id' => $pay->person_id];
                $fee_payed = $command->queryScalar();   
                
                
                
                return  $payed_cash + $payed_cash_not_cash - $fee_payed;
            }
            return null;
        }
        
        
        /**
         * 
         * Crea el Estado de Cuenta en una Ruta
         * 
         * @param type $location_id
         * @param type $file_path
         */
        public static function saveToFileAccountState($location_id = 0, $file_path = null){
            self::buildAccountState($location_id, $output_type = "F", $file_path);
        }
        
        
        /**
         * 
         * @param type $location_id
         */
        public static function downloadAccountState( $location_id = 0 ) {
            self::buildAccountState($location_id);
        }
      
        
        /**
         * 
         * Entrega el Estado de Cuenta en PDF al Browser
         * 
         * @param integer $location_id
         * @param string $output_type
         * @param string $file_path
         */
        public static function buildAccountState( $location_id = 0, $output_type = "I", $file_path = null ) {
           
           $controller = Yii::app()->controller;
           
           $controller->layout = "pdf_report_layout";

           $pdfReportTitle = "Estado de Cuenta";

           /* @var $mPDF1 */

           $location = Location::model()->findByPk($location_id);

           $owners = Owner::model()->findAll('location_id = :location_id AND end_date IS NULL', array(':location_id' => $location->id));


           $criteria = new CDbCriteria();
           $criteria->join = " LEFT JOIN " . Pay::model()->tableName() . " p ON ( t.pay_id = p.id )";
           $criteria->condition = " location_id = :location_id AND begin_date <=  CURDATE()";
           $criteria->params = array(":location_id" => $location->id);
           $criteria->order = " p.pay_date DESC, begin_date DESC ";

           $count_feeds = ViewLocationFeePay::model()->count($criteria);

           $locationFeePays = ViewLocationFeePay::model()->findAll($criteria);
           $locationFeePayToShow = array();

           $command = Yii::app()->getDb()->createCommand();
           $command->text = " SELECT SUM(value_pay) as payed FROM " . ViewAllPayedByLocation::model()->tableName() . " WHERE location_id = :location_id";

           $total_payed = $command->queryScalar(array(':location_id' => $location->id));

           $debt = $location->initial_debt;
           $last_pay = null;
           $valuePayNotCash = 0;
           $feeNotPayed = 0;
           $feePayed = 0;
           $valuePayNotCashUnChecked = 0;

           foreach ($locationFeePays as $key => $locationFeePay) {
               if ($locationFeePay->fee_payed) {
                   /* @var $last_pay Pay */

                   if (is_null($last_pay)) {
                       $last_pay = Pay::model()->findByPk($locationFeePay->pay_id);
                       $resultPayNotCash = $last_pay->getValueNotCash();
                       $valuePayNotCash = $resultPayNotCash["checked"] + $resultPayNotCash["unchecked"];
                       $valuePayNotCashUnChecked = $resultPayNotCash["unchecked"];
                   }

                   $feePayed += $locationFeePay->value;
               } else {
                   $feeNotPayed += 1;
                   $debt += $locationFeePay->value;
                   //  se seleccionan las ultimas cuotas sin pagar
                   $locationFeePayToShow[] = $locationFeePay;
               }
           }

           $total_payed = $total_payed - $feePayed;



           
           /* @var $mPDF1 TCPDF */
           $mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter');


           // Load a stylesheet
           $stylesheet = file_get_contents( Yii::getPathOfAlias('webroot.themes.frontend.css') . '/pdf_report_style.css');


           $mPDF1->SetHTMLHeader($controller->renderPartial('application.views.reports.commons.header_report', array("pdfReportTitle" => $pdfReportTitle), true));
           $mPDF1->SetHTMLFooter($controller->renderPartial('application.views.reports.commons.footer_report', array("pdfReportTitle" => $pdfReportTitle), true));

           $mPDF1->WriteHTML($stylesheet, 1);

           // renderPartial (only 'view' of current controller)
           $mPDF1->WriteHTML($controller->renderPartial('webroot.themes.frontend.views.site.pdf_account_state', array(
                       "location" => $location,
                       'owners' => $owners, 'debt' => $debt,
                       'feeds_not_payed' => $locationFeePayToShow,
                       'total_feeds_not_payed' => $count_feeds,
                       'last_pay' => $last_pay,
                       'value_pay_not_cash' => $valuePayNotCash,
                       'valuePayNotCashUnChecked' => $valuePayNotCashUnChecked,
                       'feeNotPayed' => $feeNotPayed,
                       'total_payed' => $total_payed
                           ), true));
           
           if( is_null($file_path) ){
               $file_path = self::getLocationAccountStateReportFileName( $location->code );
           }

           # Outputs ready PDF
           $mPDF1->Output( $file_path, $output_type);
       }
       
       
       
       
       
       
       
       
       /**
	 * 
	 * @param update position mip_accounting_move_line
	 */
	public static function updatePositionAccountingMoveLine($position,$id)
	{
		$command = Yii::app()->getDb()->createCommand();
		$command->text = "UPDATE mip_accounting_move_line set position = ".$position." where id =".$id."  "; 
		$command->execute();
	}
       
       
    /**
	 * Retorna la fecha actual en MYSQL Timestamp (yyyy-MM-dd)
	 * @return string
	 */
	public static function getCurrentTimeStampDateDb()
	{
		

		$formatter = new CDateFormatter(null);
			
		return $formatter->format('yyyy-MM-dd', time())." ".date("H").":".date("i").":".date("s");
	} 



	/**
	 * Retorna la fecha actual (dd/MM/YYYY)
	 * @return string
	 */
	public static function getDateToday(){
		return date("d")."/".date("m")."/".date("Y");
	}
                 
	
}
