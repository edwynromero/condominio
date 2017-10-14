<?php
$this->breadcrumbs=array(
	'Accounting Journals'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AccountingJournal','url'=>array('index')),
	array('label'=>'Create AccountingJournal','url'=>array('create')),
	array('label'=>'View AccountingJournal','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AccountingJournal','url'=>array('admin')),
	);
	?>

	<h1>Update AccountingJournal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>