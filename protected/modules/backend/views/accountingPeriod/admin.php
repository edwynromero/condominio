<?php
/* @var $this AccountingPeriodController */
/* @var $model AccountingPeriod */

$this->breadcrumbs=array(
	'Accounting Periods'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>  MipHelper::t('Create').' '.MipHelper::t('AccountingPeriod'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounting-period-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>
    <?php echo MipHelper::t('Manage').' '.MipHelper::t('AccountingPeriods'); ?>
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
	'id'=>'accounting-period-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'label',
		'from',
		'to',
		//'fiscal_year_id',
            
                array(
                  "header"=>  MipHelper::t('FiscalYear'),
                    "name"=>'fiscal_year_id',
                    "value"=>function($data){
                   
                return FiscalYear::model()->find('id=:id', array(':id'=>$data->fiscal_year_id));
                    }
                ),
                array(
                    "header"=> MipHelper::t("Status"),
                    "name"=>'status',
                    "value"=>function($data){
                        
                                return AccountingPeriodStatus::model()->find('`key`=:key', array(':key'=>$data->status));
                    }
                    
                ),  
		/*'created_at',
		
		'updated_at',
		'status',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
