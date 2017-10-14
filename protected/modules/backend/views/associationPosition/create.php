<?php
$this->breadcrumbs=array(
	'Association Positions'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AssociationPosition','url'=>array('index')),
array('label'=>'Manage AssociationPosition','url'=>array('admin')),
);
?>

<h1>Create AssociationPosition</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>