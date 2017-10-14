<?php

	/* @var $this Controller */
	/* @var $model Person */

	$this->breadcrumbs=array(
		'People'=>array('index'),
		'Manage',
	);
	
	
	$this->menu = MipHelper::getMenuToAdmin($model);
	
	Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('person-grid', {
				data: $(this).serialize()
			});
			return false;
		});
	");
?>

<h1><?php echo MipHelper::t("Manage People")?></h1>
<!-- 
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
 -->
<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php

$connection = $model->getDbConnection();
$connection->enableProfiling = true;

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'person-grid',
	'dataProvider'=>$model->searchToAdmin(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			array(
					'header'=>MipHelper::t("Family/Company"),
					'name'=>'group_person_id',
					'type'=>'text',
					'value'=>'MipHelper::getGroupPersonName( $data->group_person_id )',
			),
			array(
					'header'=>MipHelper::t("Identity"),
					'name'=>'identity_code',
					'type'=>'text',
					'value'=>'$data->FullIdentity',
			),
			array(
					'header'=>MipHelper::t("Full Name"),
					'name'=>'first_name',
					'type'=>'text',
					'value'=>'$data->FullNameList',
			),
			array(
					'name'=>'active',
					'type'=>'text',
					'value'=>'MipHelper::showYesNo( $data->active )',
					'filter'=>MipHelper::getYesNoOptions(),
			),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
			),
	),
));
 
$connection->enableProfiling = true;
?>
