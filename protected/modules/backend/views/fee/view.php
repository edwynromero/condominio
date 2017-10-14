<?php
$this->breadcrumbs=array(
	'Fees'=>array('index'),
	$model->name,
);

$this->menu= CMap::mergeArray(	MipHelper::getMenuToView($model), 
								array(array('label'=>MipHelper::t('Location Pay Status'), 'url'=>array('locationPayStatus', 'fee_id'=>$model->id))));

?>

<h1>View Fee #<?php echo $model->id; ?></h1>

<?php  echo $this->renderPartial('__view', array( 'model'=>$model) );?>
