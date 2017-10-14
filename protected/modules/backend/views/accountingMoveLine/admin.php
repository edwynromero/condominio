<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */

$this->breadcrumbs=array(
	'Accounting Move Lines'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>  MipHelper::t('Manage')." ".MipHelper::t('AccountingMove'), 'url'=>array('//backend/accountingMove/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounting-move-line-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

    <h1>
     <?php echo MipHelper::t("Manage")." ".MipHelper::t("Accounting Move Lines");  ?>   
        
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
	'id'=>'accounting-move-line-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'accounting_move_id',
                array(
                   "header"=> MipHelper::t("AccountingMove"),
                    "name"=>'accounting_move_id',
                    "value"=>function($data){
        
                        return AccountingMove::model()->find('id=:id', array(':id'=>$data->accounting_move_id));
                    }
                    
                    
                    
                ),
     //'accounting_period_id',
                         
                  array(
                      "header"=> MipHelper::t("AccountingPeriod"),
                      "name"=> 'accounting_period_id',
                      "value"=> function($data){
                       
                         return AccountingPeriod::model()->find('id=:id', array(':id'=>$data->accounting_period_id));
                      }
                      
                          ),
                                


		//'accounting_account_id',
                        
                 array(
                     "header"=>  MipHelper::t("AccountingAccount"),
                     "name"=> 'accounting_account_id',
                     "value"=>function($data){
                        
                        return AccountingAccount::model()->find('id=:id', array(':id'=>$data->accounting_account_id));
                     }
                 ),       
	  
                //debt                  
		array(
                  "header"=>  MipHelper::t("Debt"),
                  "name"=>"debt",
                  "value"=>function($data){
                        if ((float)$data->debt == 0.00){
                                return "";
                        }else{
                                return $data->debt;
                        }
                  }
                ),
                
		//'credt',
                array(
                  "header"=>  MipHelper::t("Credt"),
                  "name"=>"credt",
                  "value"=>function($data){
                        if ((float)$data->credt == 0.00){
                                return "";
                        }else{
                                return $data->credt;
                        }
                  }
                ),
		/*
		'balance',
		'date_at',
		'created_at',
		'updated_at',
		'reconciled',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
