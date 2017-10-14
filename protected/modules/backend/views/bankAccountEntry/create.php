<?php
/* @var $this BankAccountEntryController */
/* @var $model BankAccountEntry */

$this->breadcrumbs=array(
	'Bank Account Entries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BankAccountEntry', 'url'=>array('index')),
	array('label'=>'Manage BankAccountEntry', 'url'=>array('admin')),
);


?>

<h1>Create BankAccountEntry</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'bank_account_summary_id'=>$bank_account_summary_id)); ?>