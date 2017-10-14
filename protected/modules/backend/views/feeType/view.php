<?php
$this->breadcrumbs=array(
	MipHelper::t('Fee Type')=>array('index'),
	$model->title,
);

$this->menu = MipHelper::getMenuToView($model);

?>

<h1><?php echo MipHelper::t('View Fee Type')?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'title',
		'summary',
		array(
			'name'=>'value',
			'type'=>'text',
			'value'=>MipHelper::formatCurrency( $model->value )
		),
		array(
				'name'=>'active',
				'type'=>'text',
				'value'=>MipHelper::showYesNo( $model->active )
		),
		array(
				'name'=>'is_regular',
				'type'=>'text',
				'value'=>MipHelper::showYesNo( $model->is_regular )
		),		
),
)); ?>
