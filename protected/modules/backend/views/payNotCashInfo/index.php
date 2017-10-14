<?php
$this->breadcrumbs=array(
	'Pay Not Cash Infos',
);

$this->menu=array(
array('label'=>'Create PayNotCashInfo','url'=>array('create')),
array('label'=>'Manage PayNotCashInfo','url'=>array('admin')),
);
?>

<h1>Pay Not Cash Infos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
