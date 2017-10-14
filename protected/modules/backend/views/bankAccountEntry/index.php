<?php
/* @var $this BankAccountEntryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bank Account Entries',
);

$this->menu=array(
	array('label'=>'Create BankAccountEntry', 'url'=>array('create')),
	array('label'=>'Manage BankAccountEntry', 'url'=>array('admin')),
);
?>

<h1>Bank Account Entries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
