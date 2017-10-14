<?php
/* @var $this FiscalYearController */
/* @var $model FiscalYear */

$this->breadcrumbs=array(
	'Fiscal Years'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('FiscalYear'), 'url'=>array('index')),
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('FiscalYear'), 'url'=>array('create')),
	array('label'=>  MipHelper::t('View')." ".MipHelper::t('FiscalYear'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('FiscalYear'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('Update')." ".MipHelper::t('FiscalYear');  ?> #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>