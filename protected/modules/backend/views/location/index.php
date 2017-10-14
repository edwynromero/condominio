<?php
$this->breadcrumbs=array(
	'Locations',
);

$this->menu=MipHelper::getMenuToList($dataProvider);

?>

<h1><?php  echo MipHelper::t("Locations")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
