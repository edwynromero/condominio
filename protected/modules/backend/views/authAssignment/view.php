<?php
$this->breadcrumbs=array(
	'Auth Assignments'=>array('index'),
	$model->itemname,
);

$this->menu=array(
array('label'=>'List AuthAssignment','url'=>array('index')),
array('label'=>'Create AuthAssignment','url'=>array('create')),
array('label'=>'Update AuthAssignment','url'=>array('update','id'=>$model->itemname)),
array('label'=>'Delete AuthAssignment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->itemname),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AuthAssignment','url'=>array('admin')),
);
?>

<h1>View AuthAssignment #<?php echo $model->itemname; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'itemname',
		'userid',
		'bizrule',
		'data',
),
)); ?>
