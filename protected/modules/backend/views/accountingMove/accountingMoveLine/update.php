<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */

$this->breadcrumbs=array(
	'Accounting Move Lines'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
    array('label'=> MipHelper::t('Back'), 'url'=>array('view', 'id'=>$accountingMove->id)),
);
?>

<h1>
   <?php echo AccountingHelper::t("Updating");?>
   <?php echo AccountingHelper::t("Accounting Seat");?>
</h1>
<?php
    $this->renderPartial('detail',array(
    'model'=>$accountingMove,
    'showCancelButton'=>false,
)); ?>
<?php $this->renderPartial('accountingMoveLine/_form', array('model'=>$model, 'accountingMove'=>$accountingMove )); ?>