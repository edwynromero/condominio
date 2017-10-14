<?php
$this->breadcrumbs=array(
	MipHelper::t('Register Requests')=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>MipHelper::t('List RegisterRequest'),'url'=>array('index')),
array('label'=>MipHelper::t('Manage RegisterRequest'),'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t("Create RegisterRequest")?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>