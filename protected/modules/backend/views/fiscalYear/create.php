<?php
/* @var $this FiscalYearController */
/* @var $model FiscalYear */

$this->breadcrumbs=array(
	'Fiscal Years'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>  MipHelper::t('Manage').' '. MipHelper::t('FiscalYear'), 'url'=>array('admin')),
);
?>



<h1>
        <?php echo MipHelper::t('Create'); ?>
        <?php echo MipHelper::t('FiscalYear'); ?>
</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>