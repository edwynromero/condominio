<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Create',
);

$this->menu = array(
	
	array('label'=>  MipHelper::t ('Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo MipHelper::t('Create') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create', 
        'accountingKinds' => $accountingKinds
        )
    );
?>