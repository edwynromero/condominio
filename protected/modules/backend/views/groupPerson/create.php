<?php
$this->breadcrumbs=array(
	'Group People'=>array('index'),
	'Create',
);

$this->menu = MipHelper::getMenuToCreate($model);

?>

<h1><?php echo MipHelper::t("Create GroupPerson")?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>