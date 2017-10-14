<?php
$this->breadcrumbs=array(
	'Fee Types'=>array('index'),
	'Manage',
);

$this->menu = MipHelper::getMenuToAdmin($model);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('fee-type-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo MipHelper::t("Manage Fee Types")?></h1>
<!-- 
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> -->

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'fee-type-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'title',
		'summary',
		array(
				'name'=>'value',
				'type'=>'text',
				'value'=>'MipHelper::formatCurrency( $data->value )'
		),
		array(
				'name'=>'active',
				'type'=>'text',
				'value'=>'MipHelper::showYesNo( $data->active )'
		),
		array(
				'name'=>'is_regular',
				'type'=>'text',
				'value'=>'MipHelper::showYesNo( $data->is_regular )'
		),
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
