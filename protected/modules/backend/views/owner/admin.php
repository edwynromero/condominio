<?php
/* @var $owner Owner */

$this->breadcrumbs=array(
	'Owners'=>array('index'),
	'Manage',
);

$this->menu = MipHelper::getMenuToAdmin($model);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('owner-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo MipHelper::t("Manage Owners")?></h1>

<br>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'owner-grid',
	'dataProvider'=>$model->searchPersonLocation(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			array(
					'name' => 'location_id',
					'type' => 'raw',
					'value'=> 'MipHelper::createLocationLink( $data->location_id )'
			),
			array(
					'name' => 'person_id',
					'type'=>'raw',
					'value'=>'MipHelper::createPersonLinkById($data->person_id)'					
			),
			array(
					'name' => 'begin_date',
					'type' => 'text',
					'value'=> 'MipHelper::parseDateFromDb( $data->begin_date )'
			),
			array(
					'name' => 'end_date',
					'type' => 'text',
					'value'=> 'MipHelper::parseDateFromDb( $data->end_date )'
			),
		/*	array(
					'name' => 'end_date',
					'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'attribute'=>'end_date',
							'language' => 'es',
							// 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
							'htmlOptions' => array(
									'id' => 'datepicker_for_end_date',
									'size' => '10',
							),
							'defaultOptions' => array(  // (#3)
									'showOn' => 'focus',
									'dateFormat' => 'dd/mm/yy',
									'showOtherMonths' => true,
									'selectOtherMonths' => true,
									'changeMonth' => true,
									'changeYear' => true,
									'showButtonPanel' => true,
							)
					),
							true), // (#4)*/
							
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
			),
	),
)); ?>
