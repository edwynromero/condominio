<?php
/* @var $this AccountingMoveController */
/* @var $model AccountingMove */

$this->breadcrumbs=array(
	'Accounting Moves'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array('label'=> MipHelper::t('Create'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounting-move-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

    <h1>
        <?php echo MipHelper::t('Manage')." ".MipHelper::t('Accounting Moves');   ?>
</h1>



<?php echo CHtml::link(MipHelper::t('Advanced Search'),'#',array('class'=>'btn search-button')); ?>
<div class="search-form" style="display:none">
    <p>
    <?php echo MipHelper::t("You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.");   ?>
</p>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->





<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'accounting-move-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'header'=> AccountingHelper::t('Journal'),
			'name'=>'status',
			'value'=>function($data){
				return AccountingJournal::model()->findByPk($data->journal_id)->title;

				}

			),
		'label',
		'date_at',
		array(
			'header'=>MipHelper::t('Status'),
			'name'=>'status',
			'value'=>function($data){
				$status = AccountingMoveStatus::model()->find('`key`=:key', array(':key'=>$data->status));
				return $status->label;

				}

			),
		/*
		'updated_at',
		
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
