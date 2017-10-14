<?php
$this->breadcrumbs=array(
	'Resident Associations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu = MipHelper::getMenuToUpdate($model);
	
	?>

	<h1><?php echo MipHelper::t("Update ResidentAssociation")?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>