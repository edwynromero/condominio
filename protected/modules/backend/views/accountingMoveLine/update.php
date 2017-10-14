<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */

$this->breadcrumbs=array(
	'Accounting Move Lines'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	
	
	array('label'=> MipHelper::t('View')." ".MipHelper::t('AccountingMoveLine'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=> MipHelper::t('Manage')." ".MipHelper::t('AccountingMoveLine'), 'url'=>array('admin')),
);
?>

<h1> <?php echo MipHelper::t('Update')." ".  MipHelper::t('AccountingMoveLine'); ?> <?php echo $model->id; ?></h1>



<?php $this->renderPartial('_form', array('model'=>$model, 'date_update'=>$date_update)); ?>