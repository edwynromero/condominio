<?php
$this->breadcrumbs=array(
	'Location Geometries',
);

$this->menu = MipHelper::getMenuToList(LocationGeometry::model());

?>

<h1><?php echo MipHelper::t("Location Geometries"); ?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
