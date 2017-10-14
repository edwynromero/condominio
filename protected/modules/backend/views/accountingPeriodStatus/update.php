<?php
/* @var $this AccountingPeriodStatusController */
/* @var $model AccountingPeriodStatus */

$this->breadcrumbs=array(
	'Account Period Statuses'=>array('index'),
	$model->key=>array('view','id'=>$model->key),
	'Update',
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('index')),
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('create')),
	array('label'=> MipHelper::t('View')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('view', 'id'=>$model->key)),
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('Update')." ".  MipHelper::t('AccountPeriodStatus');  ?><?php echo $model->key; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>