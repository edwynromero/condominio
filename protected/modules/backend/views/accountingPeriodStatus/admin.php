<?php
/* @var $this AccountingPeriodStatusController */
/* @var $model AccountingPeriodStatus */

$this->breadcrumbs=array(
	'Account Period Statuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>  MipHelper::t('Create AccountPeriodStatus'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#account-period-status-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>
        <?php echo MipHelper::t("Manage Account Period Statuses"); ?>
</h1>



<?php echo CHtml::link(MipHelper::t('Advanced Search'),'#',array('class'=>'btn search-button')); ?>
<div class="search-form" style="display:none">
    <p>
    <?php echo MipHelper::t('You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.');  ?>
        </p>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'account-period-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'key',
		'label',
		//'at_year',
		array(
			'name'=>'at_year',
			'value'=>function($data){

						if($data->at_year){
							return MipHelper::t('Yes');
						}else{
							return "No";
						}
				}
			),
		//'at_period',
		array(
			'name'=>'at_period',
			'value'=>function($data){

						if($data->at_period){
							return MipHelper::t('Yes');
						}else{
							return "No";
						}
				}
			),
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
