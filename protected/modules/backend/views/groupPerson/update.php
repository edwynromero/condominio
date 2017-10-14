<?php
$this->breadcrumbs=array(
	'Group People'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu = MipHelper::getMenuToUpdate($model);
	?>

	<h1><?php echo MipHelper::t("Update GroupPerson")?> #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>