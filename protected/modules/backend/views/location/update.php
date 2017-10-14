<?php
$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=MipHelper::getMenuToUpdate($model);
	?>

	<h1><?php echo MipHelper::t("Update Location")?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>