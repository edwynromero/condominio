<?php
$this->breadcrumbs=array(
	'Accounting Move Ref Types',
);

$this->menu=array(
array('label'=>'Create AccountingMoveRefType','url'=>array('create')),
array('label'=>'Manage AccountingMoveRefType','url'=>array('admin')),
);
?>

<h1>Accounting Move Ref Types</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
