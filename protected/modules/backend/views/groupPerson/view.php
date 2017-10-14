<?php
$this->breadcrumbs=array(
	'Group People'=>array('index'),
	$model->name,
);

$this->menu = MipHelper::getMenuToView($model);

?>

<h1><?php echo MipHelper::t("View GroupPerson")?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		array(
				'name'=>'type',
				'type'=>'text',
				'value'=>MipHelper::getGroupPersonTypeName($model->type ),
		),
		array(
				'name'=>'active',
				'type'=>'text',
				'value'=>MipHelper::showYesNo($model->active),
		),
),
)); ?>
