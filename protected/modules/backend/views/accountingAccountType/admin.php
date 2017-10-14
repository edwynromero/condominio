<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>  MipHelper::t('Manage') . ' ' . $model->label(2), 'url' => array('admin')),
		array('label'=>MipHelper::t('Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('accounting-account-type-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo MipHelper::t('Manage AccountingAccountTypes'); ?></h1>

<?php echo GxHtml::link(MipHelper::t('Advanced Search'), '#', array('class' => 'btn search-button')); ?>
<div class="search-form" style="display: none;">
    <p><br>
<?php echo MipHelper::t('You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.') ?>
</p>
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'accounting-account-type-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'key',
		'label',
		array(
                'header'=>MipHelper::t('Type'),
                'name' => 'is_debt',
                'value' => function($data){
                    return ($data->is_debt == 1) ? AccountingHelper::t('Account Type Debt Value') : AccountingHelper::t('Account Type Credt Value');
                },
                'filter' => array('0' => 'No', '1' => MipHelper::t('Yes')),
                ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>