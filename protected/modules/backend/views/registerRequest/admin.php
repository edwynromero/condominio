<?php
$this->breadcrumbs=array(
	'Register Requests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>MipHelper::t('List RegisterRequest'),'url'=>array('index')),
	array('label'=>MipHelper::t('Create RegisterRequest'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
			return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('register-request-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo MipHelper::t('Manage RegisterRequest')?></h1>

<p>
	<?php echo MipHelper::t('You may optionally enter a comparison operator')?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	<?php echo MipHelper::t('or')?> <b>=</b>) <?php echo MipHelper::t('at the beginning of each of your search values to specify how the comparison should be done')?>.
</p>

<?php echo CHtml::link(MipHelper::t('Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none; padding-top: 20px;">
	
	<?php $this->renderPartial('_search',array(
				'model'=>$model,
			)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'register-request-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
				'id',
				'identity_type',
				'identity_code',
				'user_name',				
				'first_name',
				'last_name',
				'full_name',				
				'status',
			array('class'=>'bootstrap.widgets.TbButtonColumn',),
		),
	)); ?>
