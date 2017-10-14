<?php
$this->breadcrumbs=array(
	'Resident Associations',
);

$this->menu = MipHelper::getMenuToList( ResidentAssociation::model()); 

?>

<h1><?php echo MipHelper::t("Resident Associations")?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
