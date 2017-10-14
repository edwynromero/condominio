<?php
$this->breadcrumbs=array(
	'Person Addresses',
);

$this->menu=array(
array('label'=>'Create PersonAddress','url'=>array('create')),
array('label'=>'Manage PersonAddress','url'=>array('admin')),
);
?>

<h1>Person Addresses</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
