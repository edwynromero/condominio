<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */

$this->breadcrumbs=array(
	'Accounting Move Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
	
	
	array('label'=>  MipHelper::t('Update')." ".MipHelper::t('AccountingMoveLine'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>  MipHelper::t('Delete')." ".MipHelper::t('AccountingMoveLine'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('AccountingMoveLine'), 'url'=>array('admin')),
);
?>

<h1> <?php echo MipHelper::t('View')." ".MipHelper::t('AccountingMoveLine');?>  #<?php echo $model->id; ?></h1>




<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		//'accounting_move_id',
                array(
                  "name"=>"accountingMove",
                    "value"=>function($data){
                       return AccountingMove::model()->find('id=:id', array(':id'=>$data->accounting_move_id));
                    }
                ),
		//'accounting_account_id',
                 array(
                     "name"=>"accountingAccount",
                    "value"=>function($data){
                       return AccountingAccount::model()->find('id=:id', array(':id'=>$data->accounting_account_id));
                    }
                 ),
		//'accounting_period_id',
                  array(
                     "name"=>MipHelper::t("AccountingPeriod"),
                    "value"=>function($data){
                       return AccountingPeriod::model()->find('id=:id', array(':id'=>$data->accounting_period_id));
                    } 
                      
                  ),      
		'debt',
		'credt',
		'balance',
		'date_at',
		//'created_at',
		//'updated_at',
		//'reconciled',
                array(
                  "name"=>"reconciled",
                    "value"=>function($data){
                    if($data->reconciled){
                            return MipHelper::t("Yes");
                    }else{
                           return MipHelper::t("No"); 
                    }
                    },
                ),
	),
)); ?>
