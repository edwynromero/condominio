<?php
/* @var $this AccountingMoveController */
/* @var $model AccountingMove */

$this->breadcrumbs=array(
	'Accounting Moves'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=>  AccountingHelper::t('Manage'), 'url'=>array('admin')),
);
?>

<h1>
    <?php echo AccountingHelper::t("Create"); ?> 
    <?php echo AccountingHelper::t("AccountingMove"); ?>
</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>