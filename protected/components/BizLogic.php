<?php

/**
 * Clase con la Lógica del negocio
 * @author roger
 *
 */
class BizLogic {
    
    
    const CONST_ROL_ADMIN_KEY = "admin";
    const CONST_ROL_FINANCE_KEY = "finance";
    const CONST_ROL_ASSOCIATION_KEY = "association";
    const CONST_ROL_RESIDENT_KEY = "association";
    const PARAM_BANK_ACCOUNT_SUMMARY_INTERVAL = "bank_account_summary_interval";
    const PARAM_BANK_ACCOUNT_SUMMARY_INTERVAL_KEY_MIN_YEAR = "MIN_YEAR";
    const ACCOUNTING_ALIAS = "accouting_alias";
    const DEFAULT_LABEL_CASH_DESCRIPTION = "Credt cash to account";
    const LABEL_DEBT_ACCOUNT_QUOTE = "Debited account quota";
    const LABEL_DEBT_ACCOUNT_QUOTE_TYPE = "Fee";
    const LABEL_CASH_ACCOUNT_QUOTE_TYPE = "Pay Cash";
    const LABEL_CHEQ_ACCOUNT_QUOTE_TYPE  = "Pay Cheq";
    const CHEQ_ACCOUNT_QUOTE_TYPE = "C";
    const CASH_ACCOUNT_QUOTE_TYPE = "E";
    const DEBT_ACCOUNT_QUOTE_TYPE = "F";
    const OTHER_PAY_ACCOUNT_QUOTE_TYPE = "O";
    const LABEL_OTHER_PAY_ACCOUNT_QUOTE_TYPE = "Pay by other Person";
    const TRANSFER_ACCOUNT_QUOTE_TYPE = "T";
    const LABEL_TRANSFER_ACCOUNT_QUOTE_TYPE = "Pay Transfer";
    const VOUCHER_ACCOUNT_QUOTE_TYPE = "V";
    const LABEL_VOUCHER_ACCOUNT_QUOTE_TYPE = "Pay Deposit";
    const PARAM_POSITION_MIN =1;
    
    /**
     * Obtiene la deuda existente antes del Pago
     * @param integer $pay_id Id del Pgo
     */
    public static function getDebtBeforePay($pay_id) {
        /**
         * Obtenemos el total de cuotas antes del pago
         */
        /* @var $pay Pay */
        $pay = Pay::model()->findByPk($pay_id);
        $conn = Yii::app()->db;
        $command = $conn->createCommand();
        $command->text = " SELECT SUM(value) FROM " . Fee::model()->tableName() . " WHERE begin_date <= :pay_date";
        $total_fee = $command->queryScalar(array(":pay_date" => $pay->pay_date));

        $location_ids = self::getLocationIdsByPerson($pay->person_id);

        // se suman todas las cuotas de todas las parcelas
        $total_fee = count($location_ids) * $total_fee;

        $total_payed = self::getSumAllBeforePay($pay, $location_ids);
        
        return $total_fee - $total_payed;
    }

    /**
     * Obtiene la deuda existente antes del Pago
     * @param integer $pay_id Id del Pgo
     */
    public static function getAllDebtByPerson($person_id) {
        /**
         * Obtenemos el total adeuda para la persona a la fecha
         */
        $date = date('Y-m-d H:i:s');

        $conn = Yii::app()->db;
        $command = $conn->createCommand();
        $command->text = " SELECT SUM(value) FROM " . Fee::model()->tableName() . " WHERE begin_date < :pay_date";
        $total_fee = $command->queryScalar(array(":pay_date" => $date));

        $location_ids = self::getLocationIdsByPerson($person_id);

        // se suman todas las cuotas de todas las parcelas
        $total_fee = count($location_ids) * $total_fee;

        $total_payed = self::getSumAllFeePayed($location_ids, $date);

        return $total_fee - $total_payed;
    }

    /**
     *  Monto total abonado por una persona
     * @param integer $person_id
     */
    public static function getAmountPayedPersonId($person_id) {
        $command = Yii::app()->getDb()->createCommand();
        $command->text = "SELECT value  FROM view_ammount_payed_by_person  WHERE person_id = :person_id";
        $result = $command->queryScalar(array(':person_id' => $person_id));
        return empty($result) ? 0 : $result;
    }

    /**
     * Obtiene el Balance del Estado de Cuenta antes del Pago
     * @param integer $pay_id  Id del Pago
     */
    public static function getBalanceBeforePay($pay_id) {
        /* @var $pay Pay */
        $pay = Pay::model()->findByPk($pay_id);
        $conn = Yii::app()->db;
        $command = $conn->createCommand();

        // obtenemos el total de los pagos en efectivo
        $command->select("SUM(p.value_cash) ");
        $command->from(Pay::model()->tableName() . " p");
        $command->where('p.person_id = :person_id');
        $command->andWhere('p.pay_date < :pay_date');
        $command->andWhere('p.id <> :pay_id');
        $totalCash = $command->queryScalar(array(":person_id" => $pay->person_id, ":pay_date" => $pay->pay_date, ":pay_id" => $pay->id ));

        // obtenemos el total de los pagos en transferencia o deposito
        $command = $conn->createCommand();
        $command->select("SUM(pnci.value) ");
        $command->from(Pay::model()->tableName() . " p");
        $command->join(PayNotCashInfo::model()->tableName() . " pnci", "p.id = pnci.pay_id");
        $command->where('p.person_id = :person_id');
        $command->andWhere('p.pay_date < :pay_date');
        $command->andWhere('pnci.checked = true');
        $command->andWhere('p.id <> :pay_id');
        $totalNotCash = $command->queryScalar(array(":person_id" => $pay->person_id, ":pay_date" => $pay->pay_date, ":pay_id" => $pay->id ));

        $location_ids = self::getLocationIdsByPerson($pay->person_id);

        $totalFeedsPayed = self::getSumAllFeePayedAt($location_ids, $pay);

        return $totalCash + $totalNotCash - $totalFeedsPayed;
    }

    /**
     * Obtiene un array de las Parcelas asociadas a una persona
     * @param integer $personId
     * @return array
     */
    public static function getLocationsByPerson($personId) {
        /**
         * Buscamos las parcelas asociadas a la persona que realiza el pago
         */
        $criteria = new CDbCriteria();
        $criteria->join = " INNER JOIN " . Owner::model()->tableName() . " ow ";
        $criteria->join .= " ON ( t.id = ow.location_id ) ";
        $criteria->condition = " ow.person_id = :person_id ";
        $criteria->params = array(":person_id" => $personId);

        return Location::model()->findAll($criteria);
    }

    /**
     * Obtiene un array de Ids de Parcelas por Persona
     * @param integer $personId
     * @return multitype:number
     */
    public static function getLocationIdsByPerson($personId) {
        $locations = self::getLocationsByPerson($personId);
        $locationsIds = array();

        /* @var $location Location */
        foreach ($locations as $location) {
            $locationsIds[] = $location->id;
        }

        return $locationsIds;
    }
    
    
    /**
     * Suma todas las cuotas pagadas para las parcelas (ids) y una fecha tope (opcional)
     * @param Pay $pay
     */
    public static function getSumAllBeforePay($pay, $locations_id) {
        
        $conn = Yii::app()->db;
        $all_cash = 0;

        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->text = " SELECT SUM(value_cash) 
                                FROM mip_pay p 
                                WHERE 
                                        p.id IN ( SELECT pay_id FROM mip_fee_pay WHERE location_id IN ( " . join(",", $locations_id) . ") )
                                    AND 
                                        p.pay_date <= :pay_date 
                                    AND 
                                        p.id <> :pay_id  ";
        $command->params = array(":pay_id"=>$pay->id, ":pay_date"=> $pay->pay_date);
        $all_cash = $command->queryScalar();
        
        
        $command->text = " SELECT SUM(nci.value) 
                                FROM mip_pay p 
                                    INNER JOIN mip_pay_not_cash_info nci
                                        ON (nci.pay_id = p.id AND nci.checked = true )
                                WHERE 
                                        p.id IN ( SELECT pay_id FROM mip_fee_pay WHERE location_id IN ( " . join(",", $locations_id) . ") )
                                    AND 
                                        p.pay_date <= :pay_date 
                                    AND 
                                        p.id <> :pay_id  ";
        $command->params = array(":pay_id"=>$pay->id, ":pay_date"=> $pay->pay_date);
        $all_not_cash = $command->queryScalar();
        
        
        

        return $all_cash + $all_not_cash;
    }
    
    
    
    /**
     * Suma todas las cuotas pagadas para las parcelas (ids) y una fecha tope (opcional)
     * @param array $locationIds
     * @param string $dateTop (opcional)
     */
    public static function getSumAllFeePayedAt($locationIds = array(), $pay) {
        $conn = Yii::app()->db;

        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->select("SUM(f.value) ");
        $command->from(Fee::model()->tableName() . " f");
        $command->join(FeePay::model()->tableName() . " fp", " fp.fee_id = f.id ");
        $command->join(Pay::model()->tableName() . " p", " fp.pay_id = p.id ");
        $command->where(array('in', 'fp.location_id', $locationIds));
        $command->andWhere('f.begin_date <= :pay_date');
        $command->andWhere('fp.pay_id <> :pay_id');
        $command->andWhere('p.person_id = :person_id');
        $total_payed = $command->queryScalar(array(":pay_date" => $pay->pay_date, ":pay_id" => $pay->id, ":person_id" => $pay->person_id  ));
 
        return $total_payed;
    }
    
    
    /**
     * Obtiene la suma de todas las Cuotas definidas en el
     */
    public static function getSumAllFeeAt($date = null){
        $conn = Yii::app()->db;
        
        $date = is_null($date)? date('Y-m-d'):$date;
        
        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->text = " SELECT SUM(value) 
                           FROM 
                                mip_fee
                           WHERE
                             begin_date <= :begin_date


        ";
        $command->params = array(":begin_date"=> $date);
        return $command->queryScalar();
        
    }
    
    
        /**
     * Obtiene la suma de todas las Cuotas definidas en el
     */
    public static function getCountAllFeeAt($date = null){
        $conn = Yii::app()->db;
        
        $date = is_null($date)? date('Y-m-d'):$date;
        
        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->text = " SELECT COUNT(id) 
                           FROM 
                                mip_fee
                           WHERE
                             begin_date <= :begin_date

        "; 
        $command->params = array(":begin_date"=> $date);
        return $command->queryScalar();
        
    }
    
    

    /**
     * Suma todas las cuotas pagadas para las parcelas (ids) y una fecha tope (opcional)
     * @param array $locationIds
     * @param string $dateTop (opcional)
     */
    public static function getSumAllFeePayed($locationIds = array(), $dateTop = null) {
        $conn = Yii::app()->db;

        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->select("SUM(f.value) ");
        $command->from(Fee::model()->tableName() . " f");
        $command->join(FeePay::model()->tableName() . " fp", " fp.fee_id = f.id ");
        $command->where(array('in', 'fp.location_id', $locationIds));

        if (is_null($dateTop)) {
            $total_payed = $command->queryScalar();
        } else {
            $command->andWhere('f.begin_date <= :pay_date');
            $total_payed = $command->queryScalar(array(":pay_date" => $dateTop));
        }

        return $total_payed;
    }

    /**
     * Obtiene la Lista de Bancos Virtuales para operaciones internas
     */
    public static function getAsocumicaBankKey() {
        /**
         * 000 -  Asocumica BANK
         */
        return '000';
    }

    /**
     * Obtiene el banco virtual de Asocuminca
     * @return Bank
     */
    public static function getAsocumicaBank() {
        return Bank::model()->find('akey = :akey', array(':akey' => self::getAsocumicaBankKey()));
    }

    /**
     *
     * @param unknown $id
     * @return string
     */
    public static function getBankAccountShortReference($id) {
        /* @var $model BankAccount */
        $model = BankAccount::model()->findByPk($id);
        return self::getBankAccountShortName($model);
    }

    /**
     * Obtiene la representacion corta del Numbero de Operacion no en efectivo
     * @param string $number
     */
    public static function getNotCashInfoShortNumber($number) {
        return substr($number, 0, 4) . " *** " . substr($number, -4);
    }

    /**
     * 
     * @param unknown $bank
     * @return string
     */
    public static function getBankAccountShortName($bank) {
        return substr($bank->number, 0, 4) . " .. " . substr($bank->number, -4);
    }

    /**
     * 
     */
    public static function listBankAccountsShorName() {
        $bankAccounts = BankAccount::model()->findAll();
        $bankAccounList = array();
        foreach ($bankAccounts as $bankAccount) {
            $bankAccounList[] = array('id' => $bankAccount->id, 'shortReference' => self::getBankAccountShortName($bankAccount));
        }

        return CHtml::listData($bankAccounList, 'id', 'shortReference');
    }

    /**
     * Obtiene la cantidad de cuotas pagadas para un conjunto de parcelas asociadas a una persona
     * @param type $person_id  Id de la Persona
     */
    public static function getCountFeedsPayedRelationedToPerson($person_id, $dateTop = null) {

        $locationIds = self::getLocationIdsByPerson($person_id);
        $date_top = is_null($dateTop) ? date('Y-m-d H:i:s') : $dateTop;

        $conn = Yii::app()->getDb();
        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->select("COUNT(fp.id) ");
        $command->from(Fee::model()->tableName() . " f");
        $command->join(FeePay::model()->tableName() . " fp", " fp.fee_id = f.id ");
        $command->where(array('in', 'fp.location_id', $locationIds));
        
        if(is_null($dateTop))
        {
            return $command->queryScalar();
        }
        
        $command->andWhere('f.begin_date < :pay_date');
        return $command->queryScalar(array(":pay_date" => $dateTop ));
    }
    
    
    
    /**
     * Obtiene el ultimo pago relacionadas para un conjunto de parcelas asociadas a una persona
     * @param integer $person_id
     * @param date $dateTop
     * @return Pay
     */
    public static function getLastPayRelationedToPerson($person_id, $dateTop = null) {
        
        $locationIds = self::getLocationIdsByPerson($person_id);
        $date_top = is_null($dateTop) ? date('Y-m-d H:i:s') : $dateTop;

        $conn = Yii::app()->getDb();
        //  se suman todas las cuotas pagadas
        $command = $conn->createCommand();
        $command->select("fp.pay_id");
        $command->from(Pay::model()->tableName() . " p");
        $command->join(FeePay::model()->tableName() . " fp", " p.id = fp.pay_id ");
        $command->where(array('in', 'fp.location_id', $locationIds));
        $command->order('p.pay_date DESC');
        
        $pay_id = $command->queryScalar();
        
        return Pay::model()->findByPk( $pay_id );
        
    }
    
    
    /**
     * 
     * @param type $location_id
     */
    public static function getOwnersByLocation($location_id){
        
        $criteria = new CDbCriteria();
        
        $criteria->select = "p.*";
        $criteria->alias = "p";
        $criteria->join = " INNER JOIN mip_owner o ON ( p.id = o.person_id )";
        $criteria->condition = " o.location_id = :location_id ";
        $criteria->params = array(":location_id"=>$location_id);
        
        
        return  Person::model()->findAll($criteria);
 
    }
    
    
    /**
     * @return integer
     */
    public static function getBankAccountSummaryMinYear(){
            
       $interval = Yii::app()->params[self::PARAM_BANK_ACCOUNT_SUMMARY_INTERVAL];
       return $interval[self::PARAM_BANK_ACCOUNT_SUMMARY_INTERVAL_KEY_MIN_YEAR];
    } 
    
    
    
    public static function getAccountingAlias(){
            $accouting_alias = Yii::app()->params[self::ACCOUNTING_ALIAS];      
            return $accouting_alias;
    }
    
    
    
    
    public static function valueMinPosition(){
            
            
            return self::PARAM_POSITION_MIN;
    }
    
    
    /**
     * 
     * @param [] $item
     * @return []
     */
    public static function formatAccountHistoricalNotCashLabel($item){
        
        return [];
    }
    
    
    
    
    /**
     * 
     * @param integer $person_id
     * @return []
     */
    public static function retrieveAccountHistorical( $person_id,  $current_debt = 0, $location_id = null ){
        
        $historical = array();
               
        $before = 0;

        
        $criteria = new CDbCriteria();
        $criteria->alias  = "l";
        $criteria->join = "INNER JOIN mip_owner o ON ( o.location_id = l.id )";
        $criteria->condition = " o.person_id = :person_id ";
        $criteria->params = array(":person_id" => $person_id );
        $criteria->order = "l.code ASC";
        $locations = Location::model()->findAll( $criteria );
        
        if( count($locations) == 1 ){
            $location_id = $locations[0]->id;
        }
        
        
        
        $criteria = new CDbCriteria();
        $criteria->alias  = "p";
        $criteria->join = "INNER JOIN mip_owner o ON ( o.person_id = p.id )";
        $criteria->condition = " o.location_id = :location_id";
        $criteria->params = array(":location_id" => $location_id);
        $persons = Person::model()->findAll();
        
        $other_owners = array();
        foreach($persons as $person){
            $other_owners[$person->id] = $person;
        }
                
        
        /**
         * 
         */
        $command = Yii::app()->db->createCommand();
        $command->text = "
                            SELECT 
                                    *   
                            FROM (
                                            SELECT 
                                                    f.id as entry_id,
                                                    f.name as entry_label,
                                                    f.begin_date as entry_date,
                                                    null as entry_bank_account_id,
                                                    null as entry_number,
                                                    :entry_fee_type as entry_type,
                                                    f.value as entry_value,
                                                    null as entry_source_bank_id,
                                                    null as entry_person_id
                                            FROM 
                                                    mip_fee f 

                                    UNION

                                            SELECT
                                                    p.id as entry_id,
                                                    CONCAT('Transfer/Voucher ', pnci.pay_date) as entry_label,
                                                    p.pay_date as entry_date,
                                                    pnci.bank_account_id as entry_bank_account_id,
                                                    pnci.number as entry_number,
                                                    pnci.type as entry_type,
                                                    pnci.value as entry_value,
                                                    pnci.source_bank_id as entry_source_bank_id,
                                                    null as entry_person_id
                                            FROM mip_pay p
                                                    INNER JOIN mip_pay_not_cash_info pnci
                                                            ON ( pnci.pay_id = p.id AND pnci.checked = true )
                                            WHERE
                                                    p.person_id = :person_id

                                    UNION

                                            SELECT
                                                    p.id as entry_id,
                                                    CONCAT('Cash ', p.pay_date) as entry_label,
                                                    p.pay_date as entry_date,
                                                    null as entry_bank_account_id,
                                                    null as entry_number,
                                                    'E' as entry_type,
                                                    p.value_cash as entry_value,
                                                    null as entry_source_bank_id,
                                                    null as entry_person_id
                                               FROM 
                                                    mip_pay p   
                                               WHERE
                                                            p.person_id = :person_id AND p.value_cash > 0 
                                    UNION
    
                                            SELECT 
                                                    p.id as entry_id,
                                                    f.name as entry_label,
                                                    p.pay_date as entry_date,
                                                    null as entry_bank_account_id,
                                                    null as entry_number,
                                                    :entry_pay_other_person as entry_type,
                                                    f.value as entry_value,
                                                    null as entry_source_bank_id,
                                                    p.person_id as entry_person_id
                                            FROM 
                                                    mip_fee f
                                                            INNER JOIN mip_fee_pay fp
                                                                    ON ( fp.fee_id = f.id )
                                                            INNER JOIN mip_pay p
                                                                    ON ( p.id = fp.pay_id )
                                            WHERE 
                                                    fp.location_id = :location_id AND p.person_id <> :person_id

                            ) t
                            ORDER BY entry_date ASC, entry_type ASC, entry_id ASC;        

        ";    
        
        $entry_list = $command->queryAll(true, array(   ":person_id" => $person_id, 
                                                        ":location_id" => $location_id, 
                                                        ':entry_fee_type' => self::DEBT_ACCOUNT_QUOTE_TYPE,
                                                        ':entry_cash_type' => self::CASH_ACCOUNT_QUOTE_TYPE,
                                                        ':entry_pay_other_person' => self::OTHER_PAY_ACCOUNT_QUOTE_TYPE
                                        ));
        
      
        $before = 0;
        
        foreach(  $entry_list as $entry ){
            
            $custom_id = $entry["entry_type"] . "-" . str_pad($entry["entry_id"], Yii::app()->params['pad_key_at_report'], "0", STR_PAD_LEFT) ;
            
            switch($entry["entry_type"]){
                case self::DEBT_ACCOUNT_QUOTE_TYPE:
                    
                    foreach( $locations as $location ){
                        $historical[] = array(
                            "id" =>  $custom_id,
                            "date" => MipHelper::parseDateFromDb($entry["entry_date"]),
                            "before" =>  MipHelper::formatCurrency($before, ""),
                            "amount" => "-" . MipHelper::formatCurrency( $entry["entry_value"], "" ),
                            "after" =>  MipHelper::formatCurrency($before -  $entry["entry_value"], ""),
                            "description" =>  $entry["entry_label"],
                            "type" => MipHelper::t(self::LABEL_DEBT_ACCOUNT_QUOTE_TYPE),
                        );
                    }
                    
                    $before -= $entry["entry_value"];
                    
                    break;

                case self::CASH_ACCOUNT_QUOTE_TYPE:
                    
                    $historical[] = array(
                        "id" =>  $custom_id,
                        "date" => MipHelper::parseDateFromDb($entry["entry_date"]),
                        "before" =>  MipHelper::formatCurrency($before, ""),
                        "amount" => "+" . MipHelper::formatCurrency( $entry["entry_value"], "" ),
                        "after" =>  MipHelper::formatCurrency($before +  $entry["entry_value"], ""),
                        "description" => MipHelper::t(self::DEFAULT_LABEL_CASH_DESCRIPTION),
                        "type" => MipHelper::t(self::LABEL_CASH_ACCOUNT_QUOTE_TYPE),
                    );   
                    
                    $before += $entry["entry_value"];
                    
                    break;
                
                case self::CHEQ_ACCOUNT_QUOTE_TYPE:
                    
                    $historical[] = array(
                        "id" =>  $custom_id,
                        "date" => MipHelper::parseDateFromDb($entry["entry_date"]),
                        "before" =>  MipHelper::formatCurrency($before, ""),
                        "amount" => "+" . MipHelper::formatCurrency( $entry["entry_value"], "" ),
                        "after" =>  MipHelper::formatCurrency($before +  $entry["entry_value"], ""),
                        "description" => MipHelper::t(self::LABEL_CHEQ_ACCOUNT_QUOTE_TYPE). " #" . $entry["entry_number"]   ,
                        "type" => MipHelper::t(self::LABEL_CHEQ_ACCOUNT_QUOTE_TYPE),
                    );   
                    
                    $before += $entry["entry_value"];
                    
                    break; 
                

                case self::OTHER_PAY_ACCOUNT_QUOTE_TYPE:
                    
                    $historical[] = array(
                        "id" =>  $custom_id,
                        "date" => MipHelper::parseDateFromDb($entry["entry_date"]),
                        "before" =>  MipHelper::formatCurrency($before, ""),
                        "amount" => "+" . MipHelper::formatCurrency( $entry["entry_value"], "" ),
                        "after" =>  MipHelper::formatCurrency($before +  $entry["entry_value"], ""),
                        "description" => MipHelper::t("Pay by")  . " " .  $other_owners[$entry["entry_person_id"]]->fullNameList,
                        "type" => MipHelper::t(self::LABEL_OTHER_PAY_ACCOUNT_QUOTE_TYPE),
                    );   
                    
                    $before += $entry["entry_value"];
                    
                    break;  
                
                case self::TRANSFER_ACCOUNT_QUOTE_TYPE:
                    
                    $historical[] = array(
                        "id" =>  $custom_id,
                        "date" => MipHelper::parseDateFromDb($entry["entry_date"]),
                        "before" =>  MipHelper::formatCurrency($before, ""),
                        "amount" => "+" . MipHelper::formatCurrency( $entry["entry_value"], "" ),
                        "after" =>  MipHelper::formatCurrency($before +  $entry["entry_value"], ""),
                        "description" => MipHelper::t(self::LABEL_TRANSFER_ACCOUNT_QUOTE_TYPE) . " " . MipHelper::t( "from Account#" ) . $entry["entry_number"]   ,
                        "type" => MipHelper::t(self::LABEL_TRANSFER_ACCOUNT_QUOTE_TYPE),
                    );   
                    
                    $before += $entry["entry_value"];
                    
                    break; 

                default:
                    
                    $historical[] = array(
                        "id" =>  $custom_id,
                        "date" => $entry["entry_date"],
                        "before" =>  MipHelper::formatCurrency($before, ""),
                        "amount" => "+" . MipHelper::formatCurrency( $entry["entry_value"], "" ),
                        "after" =>  MipHelper::formatCurrency($before +  $entry["entry_value"], ""),
                        "description" => "Label: " . $entry["entry_label"],
                        "type" =>  self::LABEL_VOUCHER_ACCOUNT_QUOTE_TYPE  ,
                    );   
                    
                    $before += $entry["entry_value"];
                    
                    break;
                
            }
            
        }
        
        if( abs($before) <  abs($current_debt) ){
            Yii::log($before . "----" . $current_debt);
                
            $difference = abs($current_debt)  - abs($before);
                    
            $historical[] = array(
                "id" =>  "-",
                "date" => "-",
                "before" =>  MipHelper::formatCurrency($before, ""),
                "amount" => "-" . MipHelper::formatCurrency( $difference, "" ),
                "after" =>  MipHelper::formatCurrency( $before - $difference, ""),
                "description" => MipHelper::t( "Pay not binded" ),
                "type" =>  "FIX" ,
            ); 
            
        }

        return $historical;
        
    }
    
    
}
