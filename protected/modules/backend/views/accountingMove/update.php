<?php
/* @var $this AccountingMoveController */
/* @var $model AccountingMove */

$this->breadcrumbs=array(
	'Accounting Moves'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>  AccountingHelper::t('Create'), 'url'=>array('create')),
	array('label'=> AccountingHelper::t('View'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>  AccountingHelper::t('List'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('AccountingMove'); ?> <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>