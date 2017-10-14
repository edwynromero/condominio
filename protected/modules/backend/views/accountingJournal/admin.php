<?php
$this->breadcrumbs=array(
	'Accounting Journals'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List AccountingJournal','url'=>array('index')),
array('label'=>'Create AccountingJournal','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('accounting-journal-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Accounting Journals</h1>

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

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'accounting-journal-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'code',
		'title',
		'note',
		'journal_type',
		'deprecated',
		/*
		'created_at',
		'updated_at',
		'access_key',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
