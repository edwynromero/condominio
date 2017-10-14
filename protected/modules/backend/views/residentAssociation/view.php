<?php
$this->breadcrumbs=array(
	'Resident Associations'=>array('index'),
	$model->id,
);

$this->menu = MipHelper::getMenuToView($model);

?>

<h1><?php echo MipHelper::t("View ResidentAssociation") ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
			'name'=>'person_id',
			'type'=>'text',
			'value'=>MipHelper::getPersonName($model->person_id)
		),
		array(
				'name'=>'mip_association_position_id',
				'type'=>'raw',
				'value'=>MipHelper::createPersonLinkById($model->person_id)
		),
),
)); ?>
