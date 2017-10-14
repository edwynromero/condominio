<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */
?>

<?php

$this->breadcrumbs=array(
    'Accounting Move Reference'=>array('index'),
    $model->id,
);
$this->menu=array(
    array('label'=> MipHelper::t('Back'), 'url'=>array('view', 'id'=>$accountingMove->id)),
);
?>


<h1>
   <?php echo AccountingHelper::t("Creating");?>
   <?php echo AccountingHelper::t("Reference");?>
</h1>
<?php $this->renderPartial('accountingMoveReference/_form', array('model'=>$model, 'accountingMove'=>$accountingMove)); ?>