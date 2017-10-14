<?php
$this->breadcrumbs=array(
	'Auth Assignments'=>array('index'),
	$model->itemname=>array('view','id'=>$model->itemname),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AuthAssignment','url'=>array('index')),
	array('label'=>'Create AuthAssignment','url'=>array('create')),
	array('label'=>'View AuthAssignment','url'=>array('view','id'=>$model->itemname)),
	array('label'=>'Manage AuthAssignment','url'=>array('admin')),
	);
	?>

	<h1>Update AuthAssignment <?php echo $model->itemname; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>