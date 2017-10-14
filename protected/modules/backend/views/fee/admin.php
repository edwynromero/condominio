<?php
$this->breadcrumbs=array(
	'Fees'=>array('index'),
	'Manage',
);

$this->menu=MipHelper::getMenuToAdmin($model);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('fee-grid', {
			data: $(this).serialize()
			});
			return false;
		});
");
?>

<h1><?php echo MipHelper::t('Manage Fees');?></h1>
<!-- 
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
 -->
<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php /* $this->renderPartial('_search',array(
	'model'=>$model,
)); */ ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'fee-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			array(
					'name'=>'fee_type_id',
					'type'=>'text',
					'value'=>'MipHelper::getFeeTypeName($data->fee_type_id)'
			),
			'name',
			array(
					'name'=>'begin_date',
					'type'=>'text',
					'value'=>'MipHelper::parseDateFromDb($data->begin_date)'
			),
			array(
					'name'=>'end_date',
					'type'=>'text',
					'value'=>'MipHelper::parseDateFromDb($data->end_date)'
			),
			array(
					'name'=>'value',
					'type'=>'text',
					'value'=>'MipHelper::formatCurrency($data->value)'
			),
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			),
	),
)); ?>
