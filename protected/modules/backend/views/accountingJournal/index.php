<?php
$this->breadcrumbs=array(
	'Accounting Journals',
);

$this->menu=array(
array('label'=>'Create AccountingJournal','url'=>array('create')),
array('label'=>'Manage AccountingJournal','url'=>array('admin')),
);
?>

<h1>Accounting Journals</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
