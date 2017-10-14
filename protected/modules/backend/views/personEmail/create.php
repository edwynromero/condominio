<?php
$this->breadcrumbs=array(
	'Person Emails'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PersonEmail','url'=>array('index', 'person_id'=>$person_id)),
array('label'=>'Manage PersonEmail','url'=>array('admin', 'person_id'=>$person_id)),
);
?>

<h1>Create PersonEmail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'person_id'=>$person_id)); ?>