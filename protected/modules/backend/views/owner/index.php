<?php
$this->breadcrumbs=array(
	'Owners',
);

$this->menu = MipHelper::getMenuToList(Owner::model());
?>

<h1><?php echo MipHelper::t("Owners")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
