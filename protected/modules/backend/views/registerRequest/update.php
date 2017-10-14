<?php
$this->breadcrumbs=array(
	MipHelper::t('Register Requests')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>MipHelper::t('List RegisterRequest'),'url'=>array('index')),
	array('label'=>MipHelper::t('Create RegisterRequest'),'url'=>array('create')),
	array('label'=>MipHelper::t('View RegisterRequest'),'url'=>array('view','id'=>$model->id)),
	array('label'=>MipHelper::t('Manage RegisterRequest'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo MipHelper::t("Update RegisterRequest")?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>