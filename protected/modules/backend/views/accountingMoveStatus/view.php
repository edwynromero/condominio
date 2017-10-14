<?php
/* @var $this AccountingMoveStatusController */
/* @var $model AccountingMoveStatus */

$this->breadcrumbs=array(
	'Accounting Move Statuses'=>array('index'),
	$model->key,
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('index')),
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('create')),
	array('label'=> MipHelper::t('Update')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('update', 'id'=>$model->key)),
	array('label'=>  MipHelper::t('Delete')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('AccountingMoveStatus'), 'url'=>array('admin')),
);
?>

<h1> <?php echo MipHelper::t('View')." ".MipHelper::t('AccountingMoveStatus'); ?> #<?php echo $model->key; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'key',
		'label',
	),
)); ?>
