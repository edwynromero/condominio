<?php

$this->breadcrumbs = array(
	AccountingAccount::label(2),
	'Index',
);

$this->menu = array(
	array('label'=>  MipHelper::t( 'Create') . ' ' . AccountingAccount::label(), 'url' => array('create')),
	array('label'=>  MipHelper::t('Manage') . ' ' . AccountingAccount::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(AccountingAccount::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 