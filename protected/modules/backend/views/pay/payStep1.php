<?php

/*  @var $model Pay */

$this->breadcrumbs=array(
	'Pays'=>array('index'),
	'Create',
);

if($model->isNewRecord)
	$this->menu = MipHelper::getMenuToCreate($model);
else
	$this->menu = MipHelper::getMenuToUpdate($model);
?>

<?php if($model->isNewRecord): ?>
	<h1><?php echo MipHelper::getCreateLabelMenu($model)?></h1>
<?php else: ?>
	<h1><?php echo MipHelper::getUpdateLabelMenu($model)?></h1>
<?php endif;?>

<?php 
	echo $this->renderPartial('_formStep1', array('model'=>$model, 'modelPayNotCash'=>$modelPayNotCash));
?>