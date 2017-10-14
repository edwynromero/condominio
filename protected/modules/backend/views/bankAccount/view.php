<?php
$this->breadcrumbs=array(
	'Bank Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List BankAccount','url'=>array('index')),
array('label'=>'Create BankAccount','url'=>array('create')),
array('label'=>'Update BankAccount','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete BankAccount','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage BankAccount','url'=>array('admin')),
);
?>

<h1>View BankAccount #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
				'name'=>'bank_id',
				'type'=>'text',
				'value'=>MipHelper::getBankName($model->bank_id),
		),
		array(
				'name'=>'account_type',
				'type'=>'text',
				'value'=>MipHelper::getAccountTypeName($model->account_type),
		),
		'number',
),
)); ?>
