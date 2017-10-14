<?php
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'Manage',
);

$this->menu = array(
		
		array('label'=>  MipHelper::t('Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('accounting-account-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo MipHelper::t("Manage AccountingAccounts") ?></h1>



<?php echo GxHtml::link(MipHelper::t('Advanced Search'), '#', array('class' => 'btn search-button')); ?>
<div class="search-form" style="display:none">
    
    
<p>
    <?php echo MipHelper::t("You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.");  ?>
</p>    
    
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'accounting-account-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'code',
		array(
				'name'=>'type',
				'value'=>'GxHtml::valueEx($data->type0)',
				'filter'=>GxHtml::listDataEx(AccountingAccountType::model()->findAllAttributes(array('`key`','label'), false)),
				),
		array(
				'name'=>'kind',
				'value'=>'GxHtml::valueEx($data->kind0)',
				'filter'=>GxHtml::listDataEx(AccountingAccountKind::model()->findAllAttributes(array('`key`','title'), false)),
				),
		'label',
		array(
                'header' => AccountingHelper::t( 'Parent Account' ),
				'name'=>'parent_account_id',
				'value'=>'GxHtml::valueEx($data->parentAccount)',
				'filter'=>GxHtml::listDataEx(AccountingAccount::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'deprecated',
				'value'=>'MipHelper::getYesNoOptions()[$data->deprecated] ',
				'filter'=> MipHelper::getYesNoOptions(),
				),
		/*'created_at',
		'updated_at',
		'access_key',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>