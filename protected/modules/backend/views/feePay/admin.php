<?php
$this->breadcrumbs=array(
	'Fee Pays'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List FeePay','url'=>array('index')),
array('label'=>'Create FeePay','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('fee-pay-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Fee Pays</h1>

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
'id'=>'fee-pay-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		array(
			'name'=>'mip_pay_id',
			'type'=>'text',
			'value'=>'MipHelper::getPayFullReference( $data->mip_pay_id )',
		),
		array(
				'name'=>'mip_fee_id',
				'type'=>'text',
				'value'=>'MipHelper::getFeeFullReference( $data->mip_fee_id )',
		),
		array(
		'class'=>'bootstrap.widgets.TbButtonColumn',
		),
),
)); ?>
