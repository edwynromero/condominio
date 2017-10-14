<?php
/* @var $this AccountingPeriodController */
/* @var $model AccountingPeriod */

$this->breadcrumbs=array(
	'Accounting Periods'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('index')),
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('create')),
	array('label'=> MipHelper::t('View')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=> MipHelper::t('Manage')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('Update')." ".  MipHelper::t('AccountingPeriod') ?> <?php echo $model->id; ?></h1>

<?php  $this->renderPartial('_form', array('model'=>$model,'from'=>$from, 'to'=>$to)); ?>