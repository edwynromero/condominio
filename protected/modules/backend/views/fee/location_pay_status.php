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

<h1><?php echo MipHelper::t('Location Fee Pay');?></h1>
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
	'dataProvider'=>$model->searchLocationPay(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			'pay_id', 
			'fee_id', 
			'location_id',
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			),
	),
)); ?>
