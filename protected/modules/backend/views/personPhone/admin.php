<?php
$this->breadcrumbs=array(
	'Person Phones'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PersonPhone','url'=>array('index', 'person_id' => $person_id)),
array('label'=>'Create PersonPhone','url'=>array('create', 'person_id' => $person_id)),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('person-phone-grid', {
				data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1>Manage Person Phones</h1>

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

<?php 
/* @var $this Controller */
/* @var $model PersonPhone */
/* @var $form TbActiveForm */
			
$columns =  array('id');

$columns[] = array(
		'name'=>'country_id',
		'type'=>'text',
		'value' => 'MipHelper::getCountryName( $data->country_id)');

if( empty($person_id) )
	$columns[] = array( 'name'=>'person_id',
						'type'=>'text',
						'value' => 'MipHelper::getPersonName( $data->person_id)');
$columns[] = array(
				'name'=>'number',
				'type'=>'text',
				'value'=>'$data->prefix . "-" . $data->number');

$columns[] = array(
		'name' 	=> 'type',
		'type'	=> 'text',
		'value'	=> 'MipHelper::getPhoneTypeName($data->type)');

$columns[] = array(
				'name' 	=> 'is_main',
				'type'	=> 'text',
				'value'	=> 'MipHelper::showYesNo($data->is_main)');

$columns[] = array('class'=>'bootstrap.widgets.TbButtonColumn',);


$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'person-phone-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$columns,
)); ?>
