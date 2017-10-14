<?php
$this->breadcrumbs=array(
	'Banks',
);

$this->menu=array(
array('label'=>'Create Bank','url'=>array('create')),
array('label'=>'Manage Bank','url'=>array('admin')),
);
?>

<h1>Banks</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
