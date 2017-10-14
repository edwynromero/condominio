<?php
/* @var $this BankAccountEntryController */
/* @var $model BankAccountEntry */

$this->breadcrumbs=array(
	'Bank Account Entries'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BankAccountEntry', 'url'=>array('index')),
	array('label'=>'Create BankAccountEntry', 'url'=>array('create')),
	array('label'=>'View BankAccountEntry', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BankAccountEntry', 'url'=>array('admin')),
);
?>

<h1>Update BankAccountEntry <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'bank_account_summary_id'=>$bank_account_summary_id)); ?>