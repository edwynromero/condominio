<?php
$this->breadcrumbs=array(
	'Pays'=>array('index'),
	'Create',
);

$this->menu = MipHelper::getMenuToCreate($model);
?>

<h1><?php echo MipHelper::getCreateLabelMenu($model)?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>