<?php
$this->breadcrumbs=array(
	'Pay Not Cash Infos'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PayNotCashInfo','url'=>array('index')),
array('label'=>'Manage PayNotCashInfo','url'=>array('admin')),
);
?>

<h1>Create PayNotCashInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>