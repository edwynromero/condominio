<?php
$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->id,
);

$this->menu = CMap::mergeArray(MipHelper::getMenuToView($model), 
					array(
							array('label'=>MipHelper::t("Show Current Debt"),
								   'url'=>array('showReportCurrentDebt', 'location_id'=>$model->id), 
								   'linkOptions' => array('target'=>'_blank')
							),
							array('label'=>MipHelper::t("Send Current Debt by Email"),
									'url'=>array('sendLocationDebtToEmail', 'location_id'=>$model->id),
									'linkOptions' => array('target'=>'_blank')
							),
					)	
				);
?>

<h1><?php echo MipHelper::t("View Location")?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'code',
		array(
				'name'=>'is_built',
				'type'=>'text',
				'value'=>MipHelper::showYesNo($model->is_built),
		),
		array(
				'name'=>'initial_debt',
				'type'=>'text',
				'value'=>MipHelper::formatCurrency($model->initial_debt),
		),
		array(
				'name'=>'status',
				'type'=>'text',
				'value'=>MipHelper::getLocationStatusName($model->status),
		),
),
)); ?>
