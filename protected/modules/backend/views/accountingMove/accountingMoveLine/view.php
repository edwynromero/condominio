<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */

$this->breadcrumbs=array(
	'Accounting Move Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
    array('label'=> MipHelper::t('Back'), 'url'=>array('view', 'id'=>$accountingMove->id)),
);
?>

<h1> <?php echo AccountingHelper::t('Accounting Seat') ?>  #<?php echo $model->id; ?></h1>




<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            "name"=>"date_at",
            "value"=>function($data){
                 return MipHelper::parseDateFromDb($data->date_at);
            }
        ),
        array(
            "name"=>MipHelper::t("AccountingPeriod"),
            "value"=>function($data){
              return AccountingPeriod::model()->find('id=:id', array(':id'=>$data->accounting_period_id));
            } 

          ),       
		//'accounting_move_id',
        array(
            "name"=>"accountingMove",
            "value"=>function($data){
                 return AccountingMove::model()->find('id=:id', array(':id'=>$data->accounting_move_id));
            }
        ),
        //'accounting_account_id',
        array(
            "name"=>"debt",
            "value"=>function($data){
               return MipHelper::formatCurrency($data->debt);
            }
        ),
        array(
            "name"=>"credt",
            "value"=>function($data){
               return MipHelper::formatCurrency($data->credt);
            }
        ),
        array(
            "name"=>"balance",
            "value"=>function($data){
               return null;
            }
        ),        
        array(
            "name"=>"created_at",
            "value"=>function($data){
               return MipHelper::parseDateFromDb($data->created_at);
            }
        ),
        array(
            "name"=>"updated_at",
            "value"=>function($data){
               return MipHelper::parseDateFromDb($data->updated_at);
            }
        ),
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