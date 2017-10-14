<?php
$this->breadcrumbs=array(
	'Association Positions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AssociationPosition','url'=>array('index')),
	array('label'=>'Create AssociationPosition','url'=>array('create')),
	array('label'=>'View AssociationPosition','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AssociationPosition','url'=>array('admin')),
	);
	?>

	<h1>Update AssociationPosition <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>