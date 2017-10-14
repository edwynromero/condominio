<?php
$this->breadcrumbs=array(
	'Accounting Move Ref Types'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AccountingMoveRefType','url'=>array('index')),
array('label'=>'Manage AccountingMoveRefType','url'=>array('admin')),
);
?>

<h1>Create AccountingMoveRefType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>