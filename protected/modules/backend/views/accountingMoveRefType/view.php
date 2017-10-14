<?php
$this->breadcrumbs=array(
	'Accounting Move Ref Types'=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>'List AccountingMoveRefType','url'=>array('index')),
array('label'=>'Create AccountingMoveRefType','url'=>array('create')),
array('label'=>'Update AccountingMoveRefType','url'=>array('update','id'=>$model->key)),
array('label'=>'Delete AccountingMoveRefType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->key),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AccountingMoveRefType','url'=>array('admin')),
);
?>

<h1>View AccountingMoveRefType #<?php echo $model->key; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'key',
		'title',
		'associated_name',
),
)); ?>
