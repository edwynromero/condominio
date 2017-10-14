<?php
$this->breadcrumbs=array(
	'Location Geometries'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List LocationGeometry','url'=>array('index')),
array('label'=>'Manage LocationGeometry','url'=>array('admin')),
);
?>

<h1>Create LocationGeometry</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>