<?php
$this->breadcrumbs=array(
	'Person Emails'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List PersonEmail','url'=>array('index', 'person_id'=>$person_id)),
	array('label'=>'Create PersonEmail','url'=>array('create', 'person_id'=>$person_id)),
	array('label'=>'View PersonEmail','url'=>array('view','id'=>$model->id, 'person_id'=>$person_id)),
	array('label'=>'Manage PersonEmail','url'=>array('admin', 'person_id'=>$person_id)),
	);
	?>

	<h1>Update PersonEmail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'person_id'=>$person_id)); ?>