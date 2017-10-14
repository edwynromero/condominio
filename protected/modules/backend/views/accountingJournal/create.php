<?php
$this->breadcrumbs=array(
	'Accounting Journals'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AccountingJournal','url'=>array('index')),
array('label'=>'Manage AccountingJournal','url'=>array('admin')),
);
?>

<h1>Create AccountingJournal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>