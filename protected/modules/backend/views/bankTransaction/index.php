<?php
$this->breadcrumbs=array(
	'Person Emails',
);

/*$this->menu=array(
array('label'=>'Create PersonEmail','url'=>array('create', 'person_id'=>$person_id)),
array('label'=>'Manage PersonEmail','url'=>array('admin', 'person_id'=>$person_id)),
);*/
?>

<h1><?php echo MipHelper::t("Bank Transactions"); ?></h1>

<?php 

	$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
         'itemView'=>'indexItemView',
	));


?>
