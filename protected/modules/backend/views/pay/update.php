<?php
$this->breadcrumbs=array(
	'Pays'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu = MipHelper::getMenuToUpdate($model);
?>

	<h1><?php echo MipHelper::getUpdateLabelMenu($model)?> # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>