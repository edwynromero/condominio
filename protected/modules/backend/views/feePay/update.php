<?php
$this->breadcrumbs=array(
	'Fee Pays'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List FeePay','url'=>array('index')),
	array('label'=>'Create FeePay','url'=>array('create')),
	array('label'=>'View FeePay','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage FeePay','url'=>array('admin')),
	);
	?>

	<h1>Update FeePay <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>