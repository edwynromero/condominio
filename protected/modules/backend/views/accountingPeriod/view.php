<?php
/* @var $this AccountingPeriodController */
/* @var $model AccountingPeriod */

$this->breadcrumbs=array(
	'Accounting Periods'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('index')),
	array('label'=> MipHelper::t('Create')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('create')),
	array('label'=>  MipHelper::t('Update')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>  MipHelper::t('Delete')." ".MipHelper::t('AccountingPeriod'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=> MipHelper::t('Manage')." ".MipHelper::t('AccountingPeriod'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('View')." ".MipHelper::t('AccountingPeriod');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'label',
		'from',
		'to',
		//'fiscal_year_id',
                array(
                    
                   "header"=> MipHelper::t('FiscalYear'),
                    "name"=>'fiscal_year_id',
                    "value"=>function($data){
        
                    return FiscalYear::model()->find('id=:id', array(':id'=>$data->fiscal_year_id));
                    }
                    
                ),
		
		//'status',
                        
                array(
                    "header"=>"status",
                    "name"=>'status',
                    "value"=>function($data){
                        
                                return AccountingPeriodStatus::model()->find('`key`=:key', array(':key'=>$data->status));
                    }
                    
                ),        
	),
)); ?>
