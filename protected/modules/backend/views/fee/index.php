<?php
$this->breadcrumbs=array(
	'Fees',
);

$this->menu = MipHelper::getMenuToList(Fee::model()); 

?>

<h1>Fees</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
