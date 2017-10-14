<?php
/* @var $this BankAccountSummaryController */
/* @var $model BankAccountSummary */
$this->breadcrumbs=array(
	MipHelper::t('Bank Account Summaries')=>array('index'),
	MipHelper::t('Create'),
);

$this->menu=array(
	array('label'=> MipHelper::t('List BankAccountSummary') , 'url'=>array('index', "bank_account_id"=>$bankAccount->id)),
	array('label'=>MipHelper::t('Manage BankAccountSummary'), 'url'=>array('admin', "bank_account_id"=>$bankAccount->id)),
);
?>

<h1><?php   echo  MipHelper::t("Create BankAccountSummary"); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,                                          
                                            'bank' => $this->bank,
                                            'bankAccount' => $this->bankAccount,
                                            'modelFile' => $modelFile,)); ?>