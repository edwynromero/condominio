<?php
$this->breadcrumbs=array(
	'Location Geometries'=>array('index'),
	$model->id,
);

$this->menu = MipHelper::getMenuToView($model);

?>

<h1><?php echo MipHelper::t("View LocationGeometry")?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'the_geom',
		array(
				'name'=>'location_id',
				'type'=>'text',
				'value'=>MipHelper::getLocationCode($model->location_id),
		),
),
)); ?>
