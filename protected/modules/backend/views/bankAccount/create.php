<?php
$this->breadcrumbs=array(
	'Bank Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List BankAccount','url'=>array('index')),
array('label'=>'Manage BankAccount','url'=>array('admin')),
);
?>

<h1>Create BankAccount</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>