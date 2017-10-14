<?php
$this->breadcrumbs=array(
	'People',
);

$this->menu = MipHelper::getMenuToList(Person::model());
?>

<h1><?php echo MipHelper::t("People")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
