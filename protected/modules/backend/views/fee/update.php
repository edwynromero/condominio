<?php

$this->breadcrumbs=array(
	'Fees'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu = MipHelper::getMenuToUpdate($model);
	
?>

	<h1>Update Fee <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>