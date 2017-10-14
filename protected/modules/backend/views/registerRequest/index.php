<?php
$this->breadcrumbs=array(
	MipHelper::t('Register Requests')
);

$this->menu=array(
array('label'=>MipHelper::t('Create RegisterRequest'),'url'=>array('create')),
array('label'=>MipHelper::t('Manage RegisterRequest'),'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t("Register Requests")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
