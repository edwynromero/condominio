<?php
/* @var $this AccountingMoveStatusController */
/* @var $model AccountingMoveStatus */

$this->breadcrumbs=array(
	'Accounting Move Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=>  MipHelper::t('Manage').' '.MipHelper::t('AccountingMoveStatus'), 'url'=>array('admin')),
);
?>

<h1>
   <?php echo MipHelper::t("Create"); ?>  
   <?php echo MipHelper::t("AccountingMoveStatus"); ?>
</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>