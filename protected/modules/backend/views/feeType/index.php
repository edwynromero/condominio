<?php
/* @var $model CActiveDataProvider */

$this->breadcrumbs=array(
	'Fee Types',
);

$this->menu= MipHelper::getMenuToList(FeeType::model());

?>

<h1><?php echo MipHelper::t('Fee Types')?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
