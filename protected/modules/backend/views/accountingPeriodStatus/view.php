<?php
/* @var $this AccountingPeriodStatusController */
/* @var $model AccountingPeriodStatus */

$this->breadcrumbs=array(
	'Account Period Statuses'=>array('index'),
	$model->key,
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('index')),
	array('label'=> MipHelper::t('Create')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('create')),
	array('label'=>  MipHelper::t('Update')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('update', 'id'=>$model->key)),
	array('label'=>  MipHelper::t('Delete')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('AccountPeriodStatus'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('AccountPeriodStatus'); ?>  #<?php echo $model->key; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'key',
		'label',
		//'at_year',
		array(
			'name'=>'at_year',
			'value'=>function($data){

						if($data->at_year){
							return MipHelper::t('Yes');
						}else{
							return "No";
						}
				}
			),
		//'at_period',
		array(
			'name'=>'at_period',
			'value'=>function($data){

						if($data->at_period){
							return MipHelper::t('Yes');
						}else{
							return "No";
						}
				}
			),
		
	),
)); ?>
