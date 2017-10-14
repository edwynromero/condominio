<?php
$this->breadcrumbs=array(
	'Person Phones',
);

$this->menu=array(
array('label'=>MipHelper::t('Create Phone'),'url'=>array('create', 'person_id' => $person_id)),
array('label'=>MipHelper::t('Manage Phone'),'url'=>array('admin', 'person_id' => $person_id )),
);
?>

<h1><?php echo MipHelper::t("Phones List")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=> empty($person_id)?'_view':'_viewByPerson',
)); ?>
