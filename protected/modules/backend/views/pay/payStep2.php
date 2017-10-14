<?php
$this->breadcrumbs=array(
	'Pays'=>array('index'),
	'Create',
);

if($model->isNewRecord)
	$this->menu = MipHelper::getMenuToCreate($model);
else
	$this->menu = MipHelper::getMenuToUpdate($model);
?>

<h1><?php echo MipHelper::t("Select Feeds");?></h1>

<?php 
	echo $this->renderPartial('_formStep2', array('model'=>$model, 	'modelPayNotCash'=>$modelPayNotCash, 
																	'modelViewLocationFeePay'=>$modelViewLocationFeePay, 
																	'debtBeforePay' => $debtBeforePay,
																	'balanceBeforePay' => $balanceBeforePay
																	));
?>