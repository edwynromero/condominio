<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Manage',
);

$this->menu = array(
		
		array('label'=> MipHelper::t('Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('accounting-alias-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo MipHelper::t("Manage AccountingAliases") ?></h1>



<?php echo GxHtml::link(MipHelper::t('Advanced Search'), '#', array('class' => 'btn search-button')); ?>
<div class="search-form" style="display:none">
    <p>
    <?php echo MipHelper::t("You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.");   ?>
</p>
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'accounting-alias-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'key',
		array(
				'name'=>'account_id',
				'value'=>'GxHtml::valueEx($data->account)',
				'filter'=>GxHtml::listDataEx(AccountingAccount::model()->findAllAttributes(null, true)),
				),
		'label',
		'alias',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>