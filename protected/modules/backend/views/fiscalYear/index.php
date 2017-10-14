<?php
/* @var $this FiscalYearController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fiscal Years',
);

$this->menu=array(
	array('label'=>'Create FiscalYear', 'url'=>array('create')),
	array('label'=>'Manage FiscalYear', 'url'=>array('admin')),
);
?>

<h1>Fiscal Years</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
