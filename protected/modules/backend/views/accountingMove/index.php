<?php
/* @var $this AccountingMoveController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accounting Moves',
);

$this->menu=array(
	array('label'=>  MipHelper::t('Create'), 'url'=>array('create')),
	array('label'=> MipHelper::t('Manage'), 'url'=>array('admin')),
);
?>


<h1>
        <?php
        echo MipHelper::t("AccountingMoves");
        ?>
</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
