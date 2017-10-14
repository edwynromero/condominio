<?php
$this->breadcrumbs=array(
	'Pays',
);

$this->menu = MipHelper::getMenuToList($dataProvider);

?>

<h1><?php echo MipHelper::getListLabelMenu($dataProvider)?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
