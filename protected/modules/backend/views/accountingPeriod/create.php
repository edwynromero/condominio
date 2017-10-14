<?php
/* @var $this AccountingPeriodController */
/* @var $model AccountingPeriod */

$this->breadcrumbs=array(
	'Accounting Periods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>  MipHelper::t('Manage').' '.MipHelper::t('AccountingPeriod'), 'url'=>array('admin')),
);
?>

<h1>
        <?php echo MipHelper::t("Create"); ?>
        <?php echo MipHelper::t("AccountingPeriod"); ?>
</h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>