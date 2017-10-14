<?php
$this->breadcrumbs=array(
	'Resident Associations'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List ResidentAssociation','url'=>array('index')),
array('label'=>'Manage ResidentAssociation','url'=>array('admin')),
);
?>

<h1>Create ResidentAssociation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>