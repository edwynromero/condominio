<?php
/* @var $this AccountingMoveStatusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accounting Move Statuses',
);

$this->menu=array(
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('create')),
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('admin')),
);
?>

<h1>
    <?php echo MipHelper::t("AccountingMoveStatuses") ?>
</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
