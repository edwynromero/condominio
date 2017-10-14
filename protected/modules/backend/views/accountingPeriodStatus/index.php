<?php
/* @var $this AccountingPeriodStatusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Account Period Statuses',
);

$this->menu=array(
	array('label'=>'Create AccountPeriodStatus', 'url'=>array('create')),
	array('label'=>'Manage AccountPeriodStatus', 'url'=>array('admin')),
);
?>

<h1>Account Period Statuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
