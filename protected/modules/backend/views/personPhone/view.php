<?php
$this->breadcrumbs=array(
	'Person Phones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PersonPhone','url'=>array('index', 'person_id'=>$person_id )),
	array('label'=>'Create PersonPhone','url'=>array('create', 'person_id'=>$person_id )),
	array('label'=>'Update PersonPhone','url'=>array('update','id'=>$model->id, 'person_id'=>$person_id )),
	array('label'=>'Delete PersonPhone','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PersonPhone','url'=>array('admin', 'person_id'=>$person_id )),
);
?>

<h1>View PersonPhone #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
				'name'=>'person_id',
				'type'=>'text',
				'value' => MipHelper::getPersonName( $model->person_id)
		),
		array(
			'name'=>'number',
			'type'=>'text',
			'value'=>$model->prefix . "-" . $model->number 
		),
		array(
			'name' 	=> 'type',
			'type'	=> 'text',
			'value'	=> MipHelper::getPhoneTypeName($model->type)
		),
		array(
			'name' 	=> 'is_main',
			'type'	=> 'text',
			'value'	=> MipHelper::showYesNo($model->is_main)
		),
		array(
			'name'=>'country_id',
			'type'=>'text',
			'value' => MipHelper::getCountryName( $model->country_id)
		)
),
)); ?>
