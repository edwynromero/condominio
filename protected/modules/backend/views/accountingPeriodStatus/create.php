<?php
/* @var $this AccountingPeriodStatusController */
/* @var $model AccountingPeriodStatus */

$this->breadcrumbs=array(
	'Account Period Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=>  MipHelper::t('Manage').' '.MipHelper::t('AccountPeriodStatus'), 'url'=>array('admin')),
);
?>

<h1>
    <?php echo MipHelper::t("Create"); ?> 
    <?php echo MipHelper::t("AccountPeriodStatus");?>
</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>