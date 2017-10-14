<?php

$this->breadcrumbs = array(
	AccountingAccountType::label(2),
	'Index',
);

$this->menu = array(
	array('label'=>'Create' . ' ' . AccountingAccountType::label(), 'url' => array('create')),
	array('label'=>'Manage' . ' ' . AccountingAccountType::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(AccountingAccountType::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 