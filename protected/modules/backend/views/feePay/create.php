<?php
$this->breadcrumbs=array(
	'Fee Pays'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List FeePay','url'=>array('index')),
array('label'=>'Manage FeePay','url'=>array('admin')),
);
?>

<h1>Create FeePay</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>