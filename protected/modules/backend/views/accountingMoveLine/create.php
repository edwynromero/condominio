<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */

$this->breadcrumbs=array(
	'Accounting Move Lines'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=> MipHelper::t('Manage')." ".MipHelper::t('AccountingMoveLine'), 'url'=>array('admin')),
);
?>

<h1>
   <?php echo MipHelper::t("Create");?>
    <?php echo MipHelper::t("AccountingMoveLine");?>
</h1>

<?php $this->renderPartial('_form', array(  'model'=>$model,
                                            'accountingMoveLine'=>$accountingMoveLine, 
        ) ); ?>