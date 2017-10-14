<?php
$this->breadcrumbs=array(
	'Person Emails'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List PersonEmail','url'=>array('index', 'person_id'=>$person_id)),
array('label'=>'Create PersonEmail','url'=>array('create', 'person_id'=>$person_id)),
array('label'=>'Update PersonEmail','url'=>array('update','id'=>$model->id, 'person_id'=>$person_id)),
array('label'=>'Delete PersonEmail','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PersonEmail','url'=>array('admin', 'person_id'=>$person_id)),
);
?>

<h1>View PersonEmail #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
				'name'=>'person_id',
				'type'=>'text',
				'value'=> MipHelper::getPersonName($model->person_id)
		),
		'email',
		array(
			'name'=>'is_main',
			'type'=>'text',
			'value'=>MipHelper::showYesNo( $model->is_main )
		)
),
)); ?>
