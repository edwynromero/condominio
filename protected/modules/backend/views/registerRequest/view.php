<?php
$this->breadcrumbs=array(
	MipHelper::t('Register Requests')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>MipHelper::t('List RegisterRequest'),'url'=>array('index')),
	array('label'=>MipHelper::t('Create RegisterRequest'),'url'=>array('create')),
	array('label'=>MipHelper::t('Update RegisterRequest'),'url'=>array('update','id'=>$model->id)),
	array('label'=>MipHelper::t('Delete RegisterRequest'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>MipHelper::t('Manage RegisterRequest'),'url'=>array('admin')),
	array('label'=>MipHelper::t('Process Request'),'url'=>array('beginProcessRequest','id'=>$model->id)),
);
?>

<h1><?php echo MipHelper::t("View RegisterRequest")?>  #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'identity_type',
		'identity_code',
		'user_name',
		'first_name',
		'last_name',
		'full_name',
		'phone_prefix',
		'phone_number',
		'phone_type',
		'person_email',
		'status',
),
)); ?>
