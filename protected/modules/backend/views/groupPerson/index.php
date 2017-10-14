<?php
$this->breadcrumbs=array(
	'Group People',
);

$this->menu = MipHelper::getMenuToList(GroupPerson::model());

?>

<h1><?php echo MipHelper::t("Group People")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
