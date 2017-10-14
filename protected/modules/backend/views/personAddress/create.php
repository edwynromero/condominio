<?php
$this->breadcrumbs=array(
	'Person Addresses'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PersonAddress','url'=>array('index')),
array('label'=>'Manage PersonAddress','url'=>array('admin')),
);
?>

<h1>Create PersonAddress</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>