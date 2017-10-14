<?php
/* @var $this BankAccountEntryController */
/* @var $model BankAccountEntry */

$this->breadcrumbs=array(
	'Bank Account Entries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BankAccountEntry', 'url'=>array('index')),
	array('label'=>'Create BankAccountEntry', 'url'=>array('create','id'=>$model->id)),
	array('label'=>'Update BankAccountEntry', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BankAccountEntry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BankAccountEntry', 'url'=>array('admin')),
);
?>

<h1>View BankAccountEntry #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'begin_date',
		'end_date',
		'number',
		'summary',
		'value',
		'type',
		'mip_bank_account_id',
	),
)); ?>
