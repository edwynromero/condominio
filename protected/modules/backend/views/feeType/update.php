<?php
$this->breadcrumbs=array(
	'Fee Types'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

	
	$this->menu = MipHelper::getMenuToUpdate($model);
	?>

	<h1>Update FeeType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>