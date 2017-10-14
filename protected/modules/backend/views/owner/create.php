<?php
$this->breadcrumbs=array(
	'Owners'=>array('index'),
	'Create',
);

$this->menu = MipHelper::getMenuToCreate($model);
?>

<h1><?php echo MipHelper::t("Create Owner")?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>