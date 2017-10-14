<?php

$this->breadcrumbs = array(
	AccountingAlias::label(2),
	'Index',
);

$this->menu = array(
	array('label'=>'Create' . ' ' . AccountingAlias::label(), 'url' => array('create')),
	array('label'=>'Manage' . ' ' . AccountingAlias::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(AccountingAlias::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 