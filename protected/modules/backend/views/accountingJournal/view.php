<?php
$this->breadcrumbs=array(
	'Accounting Journals'=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>'List AccountingJournal','url'=>array('index')),
array('label'=>'Create AccountingJournal','url'=>array('create')),
array('label'=>'Update AccountingJournal','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AccountingJournal','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AccountingJournal','url'=>array('admin')),
);
?>

<h1>View AccountingJournal #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'code',
		'title',
		'note',
		'journal_type',
		'deprecated',
		'created_at',
		'updated_at',
		'access_key',
),
)); ?>
