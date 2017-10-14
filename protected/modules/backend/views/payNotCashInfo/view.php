<?php
$this->breadcrumbs=array(
	'Pay Not Cash Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List PayNotCashInfo','url'=>array('index')),
array('label'=>'Create PayNotCashInfo','url'=>array('create')),
array('label'=>'Update PayNotCashInfo','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PayNotCashInfo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PayNotCashInfo','url'=>array('admin')),
);
?>

<h1>View PayNotCashInfo #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
				'name'=>'pay_id',
				'type'=>'text',
				'value'=>MipHelper::getPayFullReference($model->pay_id)
		),
		array(
				'name'=>'bank_account_id',
				'type'=>'text',
				'value'=>MipHelper::getBankAccountFullReference($model->bank_account_id)
		),
		array(
				'name'=>'type',
				'type'=>'text',
				'value'=>MipHelper::getNotCashTypeName($model->type)
		),
		array(
				'name'=>'bank_id',
				'type'=>'text',
				'value'=>($bank_source_id=MipHelper::getBankName($model->bank_id))?$bank_source_id:"S/N",
		),
		array(
			'name'=>'number',
			'type'=>'text',
			'value'=>$model->number
		),
		array(
				'name'=>'value',
				'type'=>'text',
				'value'=>MipHelper::formatCurrency($model->value)
		),
		array(
				'name'=>'checked',
				'type'=>'text',
				'value'=>MipHelper::showYesNo($model->checked)
		),
),
)); ?>
