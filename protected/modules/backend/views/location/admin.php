<?php
$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Manage',
);

$this->menu=MipHelper::getMenuToAdmin($model);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('location-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo MipHelper::t("Manage Locations");?></h1>

<!-- 
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'location-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		array(
				'name'=>'id',
				'type' => 'raw',
				'value'=> 'CHtml::link($data->id, Yii::app()->controller->createUrl("//backend/location/view", array("id"=>$data->id)), array("target"=>"blank"));'
		),
		array(
				'name'=>'code',
				'type' => 'raw',
				'value'=> 'MipHelper::createLocationLink( $data->id )'
		),		
		array(
				'name'=>'is_built',
				'type'=>'text',
				'value'=>'MipHelper::showYesNo($data->is_built)',
				'filter'=>MipHelper::getYesNoOptions(),
		),
		array(
				'name'=>'initial_debt',
				'type'=>'text',
				'value'=>'MipHelper::formatCurrency($data->initial_debt)',
		),
		array(
				'name'=>'status',
				'type'=>'text',
				'value'=>'MipHelper::getLocationStatusName($data->status)',
				'filter'=>MipHelper::getActiveOptions(),
		),
		array(
		'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
