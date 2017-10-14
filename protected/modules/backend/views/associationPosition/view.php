<?php
$this->breadcrumbs=array(
	'Association Positions'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List AssociationPosition','url'=>array('index')),
array('label'=>'Create AssociationPosition','url'=>array('create')),
array('label'=>'Update AssociationPosition','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AssociationPosition','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AssociationPosition','url'=>array('admin')),
);
?>

<h1>View AssociationPosition #<?php echo $model->id; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		array(
			'name'=>'is_main',
			'type'=>'text',
			'value'=>MipHelper::showYesNo($model->is_main),
		),
),
)); ?>
