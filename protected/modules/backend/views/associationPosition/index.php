<?php
$this->breadcrumbs=array(
	'Association Positions',
);

$this->menu=array(
array('label'=>'Create AssociationPosition','url'=>array('create')),
array('label'=>'Manage AssociationPosition','url'=>array('admin')),
);
?>

<h1>Association Positions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
