<?php
$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Create',
);

$this->menu=MipHelper::getMenuToCreate($model);
?>

<h1><?php echo MipHelper::t("Create Location")?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>