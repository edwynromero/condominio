<?php
/* @var $this FiscalYearController */
/* @var $model FiscalYear */

$this->breadcrumbs=array(
	'Fiscal Years'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>  MipHelper::t('List')." ".MipHelper::t('FiscalYear'), 'url'=>array('index')),
	array('label'=>  MipHelper::t('Create')." ".MipHelper::t('FiscalYear'), 'url'=>array('create')),
	array('label'=> MipHelper::t('Update')." ".MipHelper::t('FiscalYear'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=> MipHelper::t('Delete')." ".MipHelper::t('FiscalYear'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=> MipHelper::t('Manage')." ".MipHelper::t('FiscalYear'), 'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t('FiscalYear');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'label',
		'from',
		'to',
		
                array(
                    'name'=> MipHelper::t('Is Closed'),
                    'value'=>function($data){
                    if($data->is_closed){
                            return MipHelper::t("Yes");
                    }else{
                            return "No";
                    }
                    
                    }
                    
                    
                ),
                
		array(
                    'name'=>'status',
                    'value'=>function($data){
                    
                    return $data->status0;
                    }
                    
                    
                ),
	),
)); ?>
