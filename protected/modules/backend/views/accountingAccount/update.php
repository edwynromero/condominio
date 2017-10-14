<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	'Update',
);

$this->menu = array(
	array('label' => MipHelper::t('Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label' =>  MipHelper::t('View') . ' ' . $model->label(), 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
	array('label' => MipHelper::t('Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t( 'Update' ) . " " . AccountingHelper::t( 'Account' ) ?></h1>

<?php
$this->renderPartial('_form', array(
		'model' => $model, 
        'accountingKinds' => $accountingKinds
        )
    );
?>