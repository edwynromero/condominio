<?php
$this->breadcrumbs=array(
	'Fee Pays',
);

$this->menu=array(
array('label'=>'Create FeePay','url'=>array('create')),
array('label'=>'Manage FeePay','url'=>array('admin')),
);
?>

<h1>Fee Pays</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
