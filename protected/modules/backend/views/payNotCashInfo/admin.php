<?php
$this->breadcrumbs=array(
	'Pay Not Cash Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PayNotCashInfo','url'=>array('index')),
	array('label'=>'Create PayNotCashInfo','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('pay-not-cash-info-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1>Manage Pay Not Cash Infos</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pay-not-cash-info-grid',
	'type' => ' striped',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			array(
					'name'=>'pay_id',
					'type'=>'text',
					'value'=>'MipHelper::getPayFullReference($data->pay_id)'
			),
			array(
					'name'=>'bank_account_id',
					'type'=>'text',
					'value'=>'MipHelper::getBankAccountFullReference($data->bank_account_id)'
			),
			array(
					'name'=>'type',
					'type'=>'text',
					'value'=>'MipHelper::getNotCashTypeName($data->type)'
			),
			array(
					'name'=>'bank_account_id',
					'type'=>'text',
					'value'=>'($bank_source_id=MipHelper::getBankName($data->bank_account_id))?$bank_source_id:MipHelper::t("")',
			),
			array(
					'name'=>'number',
					'type'=>'text',
					'value'=>'$data->number'
			),
			array(
					'name'=>'value',
					'type'=>'text',
					'value'=>'MipHelper::formatCurrency($data->value)'
			),
			array(
					'name'=>'checked',
					'type'=>'text',
					'value'=>'MipHelper::showYesNo($data->checked)'
			),			
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			),
	),
)); ?>
