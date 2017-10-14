<?php
$this->breadcrumbs=array(
	'Owners'=>array('index'),
	$model->id,
);

$this->menu = MipHelper::getMenuToView($model); 
?>

<h1><?php echo MipHelper::t("View Owner")?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
			'name' => 'location_id',
			'type' => 'raw',
			'value'=> MipHelper::createLocationLink( $model->location_id )
		),
		array(
			'name' => 'person_id',
			'type'=>'raw',
			'value'=>MipHelper::createPersonLinkById($model->person_id)
		),
		array(
				'name' => 'begin_date',
				'type' => 'text',
				'value'=> MipHelper::parseDateFromDb( $model->begin_date )
		),
		array(
				'name' => 'end_date',
				'type' => 'text',
				'value'=> MipHelper::parseDateFromDb( $model->end_date )
		),
),
)); ?>
