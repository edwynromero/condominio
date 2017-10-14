<?php
/* @var $this BankAccountSummaryController */
/* @var $model BankAccountSummary */

$this->breadcrumbs=array(
        MipHelper::t( 'Bank Account Summaries' )=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	MipHelper::t( 'Update'),
);

$this->menu=array(
	array('label'=>MipHelper::t('Create BankAccountSummary'), 'url'=>array('create', "bank_account_id"=>$bankAccount->id)),
	array('label'=>MipHelper::t('View BankAccountSummary'), 'url'=>array('view', 'id'=>$model->id, "bank_account_id"=>$bankAccount->id)),
	array('label'=>MipHelper::t('Manage BankAccountSummary'), 'url'=>array('admin', "bank_account_id"=>$bankAccount->id)),
);


?>

<h1><?php echo MipHelper::t("Update BankAccountSummary") . " " .  $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,                         
                                            'bank' => $this->bank,
                                            'bankAccount' => $this->bankAccount,
                                            'modelFile' => $modelFile,)); ?>