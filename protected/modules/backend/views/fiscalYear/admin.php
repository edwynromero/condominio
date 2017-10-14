<?php
/* @var $this FiscalYearController */
/* @var $model FiscalYear */

$this->breadcrumbs=array(
	'Fiscal Years'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=> MipHelper::t('Create').' '.MipHelper::t('FiscalYear'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#fiscal-year-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1> 
    <?php echo MipHelper::t("Manage").' '.MipHelper::t("FiscalYears"); ?>
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
	'id'=>'fiscal-year-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'label',
		'from',
		'to',
		
		
		array(
                    "header"=> MipHelper::t("Status"),
                    "name"=>'status',
                    "value"=>function($data){
                        
                                return AccountingPeriodStatus::model()->find('`key`=:key', array(':key'=>$data->status));
                    }
                    
                ), 


         array(
                    "header"=> MipHelper::t("Is Closed"),
                    "name"=>'is_closed',
                    "value"=>function($data){
                        
                               if($data->is_closed){
                               	return MipHelper::t('Yes');
                               }else{
                               	return 'No';
                               }

                    }
                    
                ),        

	
		
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
