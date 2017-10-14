<?php
$this->breadcrumbs=array(
	'Bank Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List BankAccount','url'=>array('index')),
	array('label'=>'Create BankAccount','url'=>array('create')),
	array('label'=>'View BankAccount','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BankAccount','url'=>array('admin')),
	);
	?>

	<h1>Update BankAccount <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>