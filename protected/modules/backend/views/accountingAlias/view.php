<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>  MipHelper::t('List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=> MipHelper::t('Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>  MipHelper::t('Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->key)),
	array('label'=>  MipHelper::t('Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->key), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=> MipHelper::t('Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
'key',
array(
        'name' => 'account',
        'type' => 'raw',
        'value' => $model->account !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->account)), array('accountingAccount/view', 'id' => GxActiveRecord::extractPkValue($model->account, true))) : null,
        ),
        'label',
        'alias',
        ),
)); ?>

