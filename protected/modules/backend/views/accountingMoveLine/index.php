<?php
/* @var $this AccountingMoveLineController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accounting Move Lines',
);

$this->menu=array(
	array('label'=>'Create AccountingMoveLine', 'url'=>array('create')),
	array('label'=>'Manage AccountingMoveLine', 'url'=>array('admin')),
);
?>

<h1>Accounting Move Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
