<?php
$this->breadcrumbs=array(
	'Person Addresses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PersonAddress','url'=>array('index')),
	array('label'=>'Create PersonAddress','url'=>array('create')),
	array('label'=>'View PersonAddress','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PersonAddress','url'=>array('admin')),
	);
	?>

	<h1>Update PersonAddress <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>