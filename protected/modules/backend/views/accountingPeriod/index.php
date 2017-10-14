<?php
/* @var $this AccountingPeriodController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accounting Periods',
);

$this->menu=array(
	array('label'=>'Create AccountingPeriod', 'url'=>array('create')),
	array('label'=>'Manage AccountingPeriod', 'url'=>array('admin')),
);
?>

<h1>Accounting Periods</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
