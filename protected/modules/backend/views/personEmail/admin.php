<?php
$this->breadcrumbs=array(
	'Person Emails'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PersonEmail','url'=>array('index','person_id'=>$person_id)),
	array('label'=>'Create PersonEmail','url'=>array('create','person_id'=>$person_id)),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('person-email-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1>Manage Person Emails</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('backend.views.personEmail._search',array(
	'model'=>$model,
	'person_id'=>$person_id
)); ?>
</div><!-- search-form -->
<?php 

	$columns = array();
	$columns[] = 'id';
	if( empty($person_id) )
	{
		$columns[] = array(
				'name'=>'person_id',
				'type'=>'text',
				'value'=> 'MipHelper::getPersonName($data->person_id)'
		);
	}	
	$columns[] = 'email';
	$columns[] = array(
			'name'=>'is_main',
			'type'=>'text',
			'value'=>'MipHelper::showYesNo( $data->is_main )'
		);
	$columns[] = array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					);

	$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'person-email-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$columns
	)); ?>
