<?php

/**
 * 
 * @author rogerzavala
 *
 */
class SiteController extends Controller {

    public $menuItems = array();
    public $pdfReportTitle = "";
    public $pdfPathImage = "";

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'error', 'forget', 'recover', 'forgetSuccess'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'create', 'update', 'login', 'logout', 'currentDebt', 'payments', 'showpay', 'downloadPayReceipt', 'reportPayment', 'reportPaymentSuccessfully', 'downloadAccountState', 'profile', 'editProfile', 'panel', 'historical'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'login'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->redirect(array('//site/panel'));
    }

    /**
     * Obtiene la Lista de Parcelas del Usuario
     * @return array
     */
    public function getUserLocations() {
        $user = User::model()->findByPk(Yii::app()->user->id);

        /**
         * Se obtienen las parcelas asociadas al usuario
         */
        $command = Yii::app()->db->createCommand();
        $command->text = "
               SELECT 
                l.id,
                l.code
               FROM 
                    mip_owner o
                        INNER JOIN mip_location l
                            ON ( o.location_id = l.id )
               WHERE
                    o.person_id = :person_id;
        ";
        $command->params = [':person_id' => $user->person_id];
        return $command->queryAll(true);
    }

    
    
    /**
     * Descarga el Estado de Cuenta en PDF
     * @param type $location_id
     */
    public function actionDownloadAccountState($location_id = 0) {
        
        MipHelper::downloadAccountState($location_id);
        
    }

    /**
     * Muestra la deuda actual del Usuario
     * @param int $location_id
     */
    public function actionCurrentDebt($location_id = 0) {
        $criteria = null;
        $this->layout = "column2";

        $locations = CHtml::listData($this->getUserLocations(), 'id', 'code');

        $feetype_not_regular_list = array();
        $fee_list = array();
        $amount = 0;

        if (count($locations) == 1) {
            $location_id = key($locations);
        }

        if (is_numeric($location_id) && $location_id > 0 && isset($locations[$location_id])) {
            //  obtenemos la deuda de la parcela seleccionada

            /* @var $locationFeePay ViewLocationFeePay */
            $criteria = new CDbCriteria();
            $criteria->condition = " location_id = :location_id AND begin_date <  CURDATE() AND NOT fee_payed ";
            $criteria->params = array(":location_id" => $location_id);

            $locationFeePays = ViewLocationFeePay::model()->findAll($criteria);

            $fee_id_list = array();

            foreach ($locationFeePays as $locationFeePay) {
                $fee_id_list[] = $locationFeePay->feed_id;
                $amount += $locationFeePay->value;
            }

            $criteria = new CDbCriteria();
            $criteria->addInCondition("id", $fee_id_list);
            $criteria->order = " begin_date DESC ";
            $fee_list = Fee::model()->findAll($criteria);

            $criteria = new CDbCriteria();
            $criteria->condition = "is_regular = false";
            $command = Yii::app()->db->createCommand();
            $command->text = "SELECT id FROM mip_fee_type WHERE is_regular = FALSE";
            $feetype_not_regular_list = $command->queryColumn();
        } else {
            $location_id = 0;
        }

        $this->render('current_debt', array('location_id' => $location_id, 'locations' => $locations, "fee_list" => $fee_list, "amount" => $amount, "feetype_not_regular_list" => $feetype_not_regular_list));
    }

    /**
     * Procesa el reporte de pagos
     */
    public function actionReportPayment() {
        $this->layout = "column2";
        $pay = new Pay;
        $payNotCash = new PayNotCashInfo("site_report_pay");

        if (isset($_POST['PayNotCashInfo'])) {
            $pay->value_cash = 0;
            $pay->pay_date = MipHelper::parseDateToDb(date('d/m/Y'));
            $pay->person_id = $this->getCurrentPersonId();

            $transaction = Yii::app()->db->beginTransaction();

            try {
                if ($pay->save()) {
                    $payNotCash->attributes = $_POST['PayNotCashInfo'];
                    $payNotCash->pay_id = $pay->id;
                    if ($payNotCash->type == Yii::app()->params['voucher_key']) {
                        $payNotCash->source_bank_id = BizLogic::getAsocumicaBank()->id;
                    }
                    $payNotCash->pay_date = MipHelper::parseDateToDb($payNotCash->pay_date);

                    //
                    //  OJO, corregir las validaciones
                    //
                    if ($payNotCash->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', MipHelperFront::t("Operation done sucessfull"));
                        $this->redirect(array('//site/payments'));
                    } else {
                        $transaction->rollback();
                    }
                } else {
                    throw new Exception("Error saving model Pay");
                }
            } catch (Exception $ex) {

                if ($transaction->active)
                    $transaction->rollback();
                throw new CHttpException(MipHelperFront::t('Fail in the service, please report to administrator'), 500);
            }
        }

        $bankList = MipHelper::getDataBanks(BizLogic::getAsocumicaBankKey());

        $accountList = MipHelperFront::getDataBankAccount();

        $this->render('report_payment', array('payNotCash' => $payNotCash, 'bankList' => $bankList, 'accountList' => $accountList));
    }

    /**
     * 
     * @param unknown $id
     */
    public function actionReportPaymentSuccessfully($id) {
        $this->layout = "column2";

        $this->render('report_payment_successfully');
    }

    /**
     * Obtiene el ID de la Persona enlazada al Usuario
     * @return int
     */
    private function getCurrentPersonId() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        return $user->person_id;
    }

    /**
     * Muestra los pagos
     */
    public function actionPayments() {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $this->layout = "column2";
        $this->render('payments', $this->getBalanceInformation($user));
    }

    /**
     *
     * @param unknown $user
     * return array('payments', "total_amount", "fee_amount_payed")
     */
    private function getBalanceInformation($user) {
        $payments = [];

        $criteria = new CDbCriteria();
        $criteria->condition = " person_id = :person_id ";
        $criteria->params = [":person_id" => $user->person_id];
        $criteria->order = "pay_date DESC, pay_id DESC";

        $items = ViewFullInfoPayedByLocation::model()->findAll($criteria);

        $total_amount = 0;
        $last_pay = null;

        /* @var $item ViewFullInfoPayedByLocation */
        foreach ($items as $index => $item) {
            if (!isset($payments[$item->pay_id])) {
                $payments[$item->pay_id] = ["id" => $item->pay_id, "payer" => $this->getPayerLabel($item), "date" => $item->pay_date, "amount" => 0.0, "taken" => 0.0];
            }

            //  ojo con la referencia al objeto
            $payment = &$payments[$item->pay_id];
            $payment["amount"] += $item->value_pay;

            /**
             * Si el monto es enefectivo, se abona automaticamente
             */
            if ($item->is_cash || ( $item->checked )) {
                $payment["taken"] += $item->value_pay;
                $total_amount += $item->value_pay;
            }
        }

        $command = Yii::app()->db->createCommand();
        $command->text = "
            SELECT
                SUM( f.value )
            FROM
                mip_pay p
                    INNER JOIN mip_fee_pay fp
                        ON ( p.id = fp.pay_id )
                    INNER JOIN mip_fee f
                        ON (fp.fee_id = f.id )
            WHERE
                p.person_id = :person_id ;
        ";
        $command->params = array(":person_id" => $user->person_id);
        $fee_amount_payed = $command->queryScalar();

        return array('payments' => $payments, "total_amount" => $total_amount, "fee_amount_payed" => $fee_amount_payed);
    }

    /**
     * Muestra el detalle del pago
     * @param int $id
     */
    public function actionShowPay($id = 0) {
        /* @var $pay Pay */
        /* @var $person Person */
        /* @var $pay_not_cash PayNotCashInfo */
        /* @var $account BankAccount */

        $this->layout = "column2";
        $pay = Pay::model()->findByPk($id);
        $bank_list = [];
        $account_list = [];
        $criteria = null;

        $total_amount = 0;
        $not_cash_amount = 0;
        $deferred_amount = 0;

        if (!empty($pay)) {
            $total_amount += $pay->value_cash;

            $person = Person::model()->findByPk($pay->person_id);

            $pay_not_cash_list = PayNotCashInfo::model()->findAll('pay_id = :pay_id', array(':pay_id' => $pay->id));

            $bank_ids = [];
            $bank_account_ids = [];

            foreach ($pay_not_cash_list as $pay_not_cash) {
                $bank_ids[] = $pay_not_cash->source_bank_id;
                $bank_account_ids[] = $pay_not_cash->bank_account_id;
                $total_amount += $pay_not_cash->value;
                if (!$pay_not_cash->checked) {
                    $deferred_amount += $pay_not_cash->value;
                }

                $not_cash_amount += $pay_not_cash->value;
            }


            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $bank_account_ids);
            $accounts = BankAccount::model()->findAll($criteria);

            foreach ($accounts as $account) {
                $account_list[$account->id] = $account;
                $bank_ids[] = $account->bank_id;
            }

            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $bank_ids);

            $banks = Bank::model()->findAll($criteria);
            foreach ($banks as $bank) {
                $bank_list[$bank->id] = $bank->name;
            }

            $command = Yii::app()->db->createCommand();
            $command->text = "
                            SELECT 
                                    f.*, l.code 
                            FROM
                                    mip_fee f
                                            INNER JOIN mip_fee_pay fp
                                                    ON ( fp.fee_id = f.id )  
                                            INNER JOIN mip_location l 
                                                    ON ( fp.location_id = l.id )
                            WHERE
                                    fp.pay_id = :pay_id ;
            ";

            $fees = $command->queryAll(true, array(":pay_id" => $pay->id));

            $criteria = new CDbCriteria();
            $criteria->condition = "is_regular = false";
            $command = Yii::app()->db->createCommand();
            $command->text = "SELECT id FROM mip_fee_type WHERE is_regular = FALSE";
            $feetype_not_regular_list = $command->queryColumn();
        }

        $this->render('show_pay', array('pay' => $pay, 'person' => $person, 'pay_not_cash_list' => $pay_not_cash_list, 'bank_list' => $bank_list, 'account_list' => $account_list, 'total_amount' => $total_amount, 'deferred_amount' => $deferred_amount, 'not_cash_amount' => $not_cash_amount, 'fees' => $fees, 'feetype_not_regular_list' => $feetype_not_regular_list));
    }

    /**
     * Obtiene el Recibo de Pago
     * @param int $id
     */
    public function actionDownloadPayReceipt($id = 0) {
        /* @var $pay Pay */
        /* @var $person Person */

        $this->layout = "pdf_report_layout";
        $pdfReportTitle = "Recibo de Pago #" . $id;

        /* @var $pay Pay */
        /* @var $person Person */
        /* @var $pay_not_cash PayNotCashInfo */
        /* @var $account BankAccount */

        $pay = Pay::model()->findByPk($id);
        $bank_list = [];
        $account_list = [];
        $criteria = null;

        $total_amount = 0;
        $not_cash_amount = 0;
        $deferred_amount = 0;

        if (!empty($pay)) {
            $total_amount += $pay->value_cash;

            $person = Person::model()->findByPk($pay->person_id);

            $pay_not_cash_list = PayNotCashInfo::model()->findAll('pay_id = :pay_id', array(':pay_id' => $pay->id));

            $bank_ids = [];
            $bank_account_ids = [];

            foreach ($pay_not_cash_list as $pay_not_cash) {
                $bank_ids[] = $pay_not_cash->source_bank_id;
                $bank_account_ids[] = $pay_not_cash->bank_account_id;
                $total_amount += $pay_not_cash->value;
                if (!$pay_not_cash->checked) {
                    $deferred_amount += $pay_not_cash->value;
                }

                $not_cash_amount += $pay_not_cash->value;
            }


            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $bank_account_ids);
            $accounts = BankAccount::model()->findAll($criteria);

            foreach ($accounts as $account) {
                $account_list[$account->id] = $account;
                $bank_ids[] = $account->bank_id;
            }

            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $bank_ids);

            $banks = Bank::model()->findAll($criteria);
            foreach ($banks as $bank) {
                $bank_list[$bank->id] = $bank->name;
            }

            $criteria = new CDbCriteria();
            $criteria->alias = "f";
            $criteria->join = " INNER JOIN " . FeePay::model()->tableName() . " fp ON ( fp.fee_id = f.id ) ";
            $criteria->condition = " fp.pay_id = :pay_id ";
            $criteria->params = array(":pay_id" => $pay->id);
            $fees = Fee::model()->findAll($criteria);

            $criteria = new CDbCriteria();
            $criteria->condition = "is_regular = false";
            $command = Yii::app()->db->createCommand();
            $command->text = "SELECT id FROM mip_fee_type WHERE is_regular = FALSE";
            $feetype_not_regular_list = $command->queryColumn();
        } else {
            throw new CHttpException(MipHelper::t("Pay not found"), 404);
        }


        // You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter');


        // Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.themes.frontend.css') . '/pdf_report_style.css');


        $mPDF1->SetHTMLHeader($this->renderPartial('pdf/header_report', array("pdfReportTitle" => $pdfReportTitle), true));
        $mPDF1->SetHTMLFooter($this->renderPartial('pdf/footer_report', array("pdfReportTitle" => $pdfReportTitle), true));

        $mPDF1->WriteHTML($stylesheet, 1);


        // renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('pdf_pay_receipt', array(
                    'pay' => $pay,
                    'person' => $person,
                    'pay_not_cash_list' => $pay_not_cash_list,
                    'bank_list' => $bank_list,
                    'account_list' => $account_list,
                    'total_amount' => $total_amount,
                    'deferred_amount' => $deferred_amount,
                    'not_cash_amount' => $not_cash_amount,
                    'fees' => $fees,
                    'feetype_not_regular_list' => $feetype_not_regular_list,
                        ), true));

        # Outputs ready PDF
        $mPDF1->Output();
    }

    /**
     * OBtiene el nombre del Pagador dependiendo del Tipo de Documento de Identidad (Natural o Juridico)
     * @param ViewFullInfoPayedByLocation $payItem Item del Tipo 
     */
    private function getPayerLabel($payItem) {
        if ($payItem->identity_type == Person::IDENTITY_TYPE_FIRM || $payItem->identity_type == Person::IDENTITY_TYPE_NATIVE || $payItem->identity_type == Person::IDENTITY_TYPE_FOREIGN) {
            return $payItem->first_name . " " . $payItem->last_name;
        } else {
            return $payItem->full_name;
        }
    }

    /**
     * 
     * @param type $value
     * @param type $list
     * @return type
     */
    public function getLabelIsFeeTypeNotRegular($value, $list) {
        return in_array($value, $list) ? MipHelperFront::t("Extraordinary") : MipHelperFront::t("Normal");
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = 'column2';

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin($username = '') {
        $this->layout = "login";

        $model = new LoginForm;
        $model->username = $username;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model, 'username' => $username));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * 
     */
    public function actionForget() {
        $this->layout = "login";
        $model = new RecoveryPassword();

        // collect user input data
        if (isset($_POST['RecoveryPassword'])) {
            $model->attributes = $_POST['RecoveryPassword'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->recovery()) {
                $this->redirect(array("//site/forgetSuccess"));
            }
        }

        $this->render('forget', array('model' => $model));
    }

    /**
     * 
     */
    public function actionForgetSuccess() {
        $this->layout = "login";
        $this->render('forget_success');
    }

    /**
     * 
     * @param unknown $email
     * @param unknown $token
     */
    public function actionRecover($email = '', $token = '') {
        $username = '';
        $tokenValid = true;
        $passwordChanged = false;
        $this->layout = "login";
        $model = new ChangePasswordForm();

        $changePasswordIsValid = ( empty($email) || empty($token) );

        $criteria = new CDbCriteria();
        $criteria->join = "INNER JOIN " . PersonEmail::model()->tableName() . " pe ON ( t.person_id = pe.person_id ) ";
        $criteria->condition = " t.token = :token AND pe.email = :email ";
        $criteria->params = array(':token' => $token, ':email' => $email);
        $user = User::model()->find($criteria);

        $tokenValid = !empty($user);

        if ($tokenValid) {
            $username = $user->name;

            if (isset($_POST['ChangePasswordForm'])) {
                $model->attributes = $_POST['ChangePasswordForm'];

                if ($model->validate()) {
                    $user->password = md5(trim($model->password));
                    $user->token = null;
                    if ($user->save()) {
                        $returnUri = $this->createAbsoluteUrl('//site/login');
                        Yii::app()->clientScript->registerMetaTag("10;url={$returnUri}", null, 'refresh');
                        $passwordChanged = true;
                    }
                }
            }
        }

        $this->render('change_password', array('model' => $model, 'tokenValid' => $tokenValid, 'passwordChanged' => $passwordChanged, 'username' => $username));
    }

    /**
     * 
     */
    public function actionProfile() {
        /* @var $user User */
        /* @var $person Person */
        /* @var $person_email PersonEmail */
        /* @var $person_phone PersonPhone */

        $this->layout = "column2";
        $user = User::model()->findByPk(Yii::app()->user->id);
        $person = $user->person;

        $person_email = PersonEmail::model()->find('person_id = :person_id AND is_main = true', array(':person_id' => $user->person_id));

        $person_phone = PersonPhone::model()->find('person_id = :person_id AND is_main = true', array(':person_id' => $user->person_id));

        $criteria = new CDbCriteria();
        $criteria->alias = "l";
        $criteria->join = " INNER JOIN mip_owner o ON ( o.location_id = l.id )";
        $criteria->condition = " o.person_id = :person_id ";
        $criteria->params = array(":person_id" => $person->id);

        $locations = Location::model()->findAll($criteria);


        $this->render('user_profile', array('user' => $user, 'person' => $person, 'locations' => $locations, 'person_email' => $person_email, 'person_phone' => $person_phone));
    }

    /**
     * 
     */
    public function actionEditProfile() {

        /* @var $user User */
        /* @var $person Person */
        /* @var $person_email PersonEmail */
        /* @var $person_phone PersonPhone */
        /* @var $location Location */
        /* @var $profileModel UserProfileForm */

        //
        //  Obtenemos los Datos Iniciales del usuario
        //

        $this->layout = "column2";
        $user = User::model()->findByPk(Yii::app()->user->id);
        $person = $user->person;


        $person_email = PersonEmail::model()->find('person_id = :person_id AND is_main = true', array(':person_id' => $user->person_id));
        $person_phone = PersonPhone::model()->find('person_id = :person_id AND is_main = true', array(':person_id' => $user->person_id));

        $criteria = new CDbCriteria();
        $criteria->alias = "l";
        $criteria->join = " INNER JOIN mip_owner o ON ( o.location_id = l.id )";
        $criteria->condition = " o.person_id = :person_id ";
        $criteria->params = array(":person_id" => $person->id);

        $locations = Location::model()->findAll($criteria);

        $profileModel = new UserProfileForm();
        $profileModel->scenario = "update";

        //
        //  Preparamo las data para el Formulario
        //

        $profileModel->user_name = $user->name;

        $profileModel->first_name = empty($person) ? "" : $person->first_name;
        $profileModel->last_name = empty($person) ? "" : $person->last_name;
        $profileModel->full_name = empty($person) ? "" : $person->full_name;
        $profileModel->identity = empty($person) ? "" : $person->identity_type . "-" . $person->identity_code;
        $profileModel->is_not_company = empty($person) ? "" : $person->isNotCompany;

        $profileModel->phone_number = empty($person_phone) ? "" : $person_phone->number;
        $profileModel->phone_prefix = empty($person_phone) ? "" : $person_phone->prefix;
        $profileModel->phone_type = empty($person_phone) ? "" : $person_phone->type;

        if (!empty($person_email)) {
            $profileModel->email = $person_email->email;
        }

        //
        //  Manejamos los cambios del Formulario
        // 
        if (isset($_POST["UserProfileForm"])) {
            $profileModel->attributes = $_POST["UserProfileForm"];

            //
            //  se ajusta el escenario si hay el password nuevo 
            //
                if (!empty($profileModel->password_new)) {
                $profileModel->scenario .= "_password";
            }

            //
            //  se ajusta el escenario si hay el email nuevo 
            //
                        if (!empty($profileModel->email_confirm) || $profileModel->email != $person_email->email) {
                $profileModel->scenario .= "_email";
            }

            if (empty($profileModel->email)) {
                $profileModel->email = $person_email->email;
            }


            if ($profileModel->validate()) {

                if ($user->password == md5(trim($profileModel->password))) {

                    $transaction = Yii::app()->db->beginTransaction();

                    try {
                        //
                        //  Se actua con el escenario de actualizaon de email, revisar Rules en Modelo
                        //
                                                if ($profileModel->scenario == "update_email" || $profileModel->scenario == "update_password_email") {

                            $person_email->email = trim($profileModel->email);
                            $person_email->save();
                        }

                        //
                        //  Se actua con el escenario de actualizaon de password, revisar Rules en Modelo
                        //
                        if ($profileModel->scenario == "update_password" || $profileModel->scenario == "update_password_email") {

                            $user->password = md5(trim($profileModel->password_new));
                            $user->save();
                        }

                        if ($person_phone->validate()) {
                            $person_phone->prefix = trim($profileModel->phone_prefix);
                            $person_phone->number = trim($profileModel->phone_number);
                            $person_phone->type = trim($profileModel->phone_type);
                            $person_phone->save();
                        }

                        $transaction->commit();

                        Yii::app()->user->setFlash('success', MipHelperFront::t("Operation done sucessfull"));

                        $this->redirect(array("//site/profile"));
                    } catch (Exception $ex) {

                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', MipHelperFront::t("Internal Error, contact to Sytem Admin"));
                        //Yii::app()->user->setFlash('error', $ex->getMessage());
                    }
                } else {
                    $profileModel->addError("password", MipHelperFront::t("The password is wrong"));
                }
            }
        }

        $profileModel->email_confirm = "";

        $profileModel->password = "";
        $profileModel->password_new = "";
        $profileModel->password_confirm = "";

        $profileModel->locations = array();
        foreach ($locations as $location) {
            $profileModel->locations[] = $location->code;
        }

        $this->render('edit_user_profile', array('profileModel' => $profileModel));
    }

    
    /**
     * 
     */
    public function actionPanel() {

        /* @var $user User */
        /* @var $person Person */
        /* @var $person_email PersonEmail */
        /* @var $person_phone PersonPhone */
        /* @var $location Location */
        /* @var $profileModel UserProfileForm */

        //
        //  Obtenemos los Datos Iniciales del usuario
        //
        	
        $this->layout = "column2";
        $user = User::model()->findByPk(Yii::app()->user->id);

        $balanceInformation = $this->getBalanceInformation($user);
        $person = $user->person;

        //  layout por defecto a dos columnas
        $this->layout = "column2";

        $current_debt = BizLogic::getAllDebtByPerson($person->id);
        $current_balance = $balanceInformation["total_amount"] - $balanceInformation["fee_amount_payed"];
        $current_balance = $current_balance > 0 ? $current_balance : 0;

        $last_pay_date = null;  //  Si no hay pagos, la fecha es NULL
        $totalLastPayed = 0;  //  Si no hay pagos, el totalPagado será 0

        $pay = BizLogic::getLastPayRelationedToPerson($person->id );

        if (!is_null($pay)) {
            $last_pay_date = $pay->pay_date;
            $totalLastPayed = $pay->value_cash;

            $criteria = new CDbCriteria();
            $criteria->condition = " pay_id = :pay_id";
            $criteria->params = array(":pay_id" => $pay->id);
            $payNotCashList = PayNotCashInfo::model()->findAll($criteria);

            /* @var $payNotCash PayNotCashInfo */
            foreach ($payNotCashList as $payNotCash) {
                if ($payNotCash->checked) {
                    $pay->value_cash += $payNotCash->value;
                }
                $totalLastPayed += $payNotCash->value;
            }
        }


        $last_pay = array("amount" => $totalLastPayed, "date" => $last_pay_date, "credited" => $totalLastPayed);


        $total_feeds = Fee::model()->count(" begin_date <= CURDATE() ");

        $feesPayedCount = BizLogic::getCountFeedsPayedRelationedToPerson($person->id); //$command->queryScalar();

        $outstanding_contributions = $total_feeds - $feesPayedCount;

        $this->render('panel', array(   "current_debt" => $current_debt, 
                                        "current_balance" => $current_balance, 
                                        "outstanding_contributions" => $outstanding_contributions, 
                                        "last_pay" => $last_pay, 
                                        "total_feeds" => $total_feeds));
    }
    
    
    /**
     * 
     * @param integer $location_id
     */
    public function actionHistorical($location_id=null){
        
        $this->layout = "column2";
        
        $user = User::model()->findByPk(Yii::app()->user->id);
        $person = $user->person;
        
        $locations = CHtml::listData($this->getUserLocations(), 'id', 'code');
 
        $balanceInformation = $this->getBalanceInformation($user);
        
        $current_debt = BizLogic::getAllDebtByPerson($person->id);
        $current_balance = $balanceInformation["total_amount"] - $balanceInformation["fee_amount_payed"];
        $current_balance = $current_balance > 0 ? $current_balance : 0;
        
        $historical = BizLogic::retrieveAccountHistorical($user->person_id, $current_debt);
        
        $this->render("historical",array('location_id' => $location_id,
                                         'locations'=>$locations,
                                         'current_debt' => $current_debt,
                                         'current_balance' => $current_balance,
                                        'historical' => array_reverse($historical) ));
        
    }
    
    

}
