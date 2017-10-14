<?php
/* @var $this AccountingMoveStatusController */
/* @var $model AccountingMoveStatus */

$this->breadcrumbs=array(
	'Accounting Move Statuses'=>array('index'),
	$model->key=>array('view','id'=>$model->key),
	'Update',
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('index')),
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('create')),
	array('label'=> MipHelper::t('View')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('view', 'id'=>$model->key)),
	array('label'=> MipHelper::t('Manage')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('Update')." ".  MipHelper::t('AccountingMoveStatus');  ?><?php echo $model->key; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>