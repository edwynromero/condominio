<?php
$this->breadcrumbs=array(
	'Accounting Move Ref Types'=>array('index'),
	$model->title=>array('view','id'=>$model->key),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AccountingMoveRefType','url'=>array('index')),
	array('label'=>'Create AccountingMoveRefType','url'=>array('create')),
	array('label'=>'View AccountingMoveRefType','url'=>array('view','id'=>$model->key)),
	array('label'=>'Manage AccountingMoveRefType','url'=>array('admin')),
	);
	?>

	<h1>Update AccountingMoveRefType <?php echo $model->key; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>