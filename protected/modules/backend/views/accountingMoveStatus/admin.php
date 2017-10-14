<?php
/* @var $this AccountingMoveStatusController */
/* @var $model AccountingMoveStatus */

$this->breadcrumbs=array(
	'Accounting Move Statuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>  MipHelper::t('Create').' '. MipHelper::t('AccountingMoveStatus'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounting-move-status-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>
    <?php echo MipHelper::t("Manage Accounting Move Statuses");  ?>
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
	'id'=>'accounting-move-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'key',
		'label',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
