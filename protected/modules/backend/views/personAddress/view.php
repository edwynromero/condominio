<?php
$this->breadcrumbs=array(
	'Person Addresses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List PersonAddress','url'=>array('index')),
array('label'=>'Create PersonAddress','url'=>array('create')),
array('label'=>'Update PersonAddress','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PersonAddress','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PersonAddress','url'=>array('admin')),
);
?>

<h1>View PersonAddress #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'address_1',
		'address_2',
		'state_id',
		'city',
		'is_main',
),
)); ?>
