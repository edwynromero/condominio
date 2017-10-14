<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */
?>

<?php

$this->breadcrumbs=array(
    'Accounting Moves'=>array('index'),
    $model->id,
);
$this->menu=array(
    array('label'=> MipHelper::t('Back'), 'url'=>array('view', 'id'=>$accountingMove->id)),
);
?>


<h1>
   <?php echo AccountingHelper::t("Creating");?>
   <?php echo AccountingHelper::t("Accounting Seat");?>
</h1>
<?php
    $this->renderPartial('detail',array(
    'model'=>$accountingMove,
    'showCancelButton'=>false,
)); ?>
<?php $this->renderPartial('accountingMoveLine/_form', array('model'=>$model, 'accountingMove'=>$accountingMove )); ?>