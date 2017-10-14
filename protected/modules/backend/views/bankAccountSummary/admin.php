<?php
/* @var $this BankAccountSummaryController */
/* @var $model BankAccountSummary */


$this->breadcrumbs=array(
	MipHelper::t('Bank Account Summaries')=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>MipHelper::t('Create BankAccountSummary'), 'url'=>array('create', "bank_account_id"=>$bankAccount->id)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bank-account-summary-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$columns = array(
			array(
					'header'=>'ID',
					'name'=>'id',
					/*'type'=>'text',
					'value'=>'MipHelper::parseDateFromDb($data->pay_date)',*/
			),
    			array(
					'header'=>MipHelper::t( 'Account'),
					'name'=>'bank_account_id',
					'type'=>'text',
					'value'=>array($this,"showAccountNumber"),
			),
			array(
					'header'=> MipHelper::t( 'Year'),
					'name'=>'year',
			),
			array(
					'header'=> MipHelper::t( 'Month'),
					'name'=>'month',
					'type'=>'text',
			),	
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{view}{update}{delete}',
				'buttons'=>array(
					'update'=>array(
                                                'url'=> 'Yii::app()->createUrl("backend/bankAccountSummary/update", array("id" => $data->id, "bank_account_id" => $data->bank_account_id) )',
						'options'=>array(
                                                    'target' => 'blank',
						),
					),
					'view'=>array(
                                                'url'=> 'Yii::app()->createUrl("backend/bankAccountSummary/view", array("id" => $data->id, "bank_account_id" => $data->bank_account_id) )',
                                                'options'=>array(
                                                    'target' => 'blank',
                                                ),
					),
				),
			),
	);
?>

<h1><?php echo MipHelper::t("Manage Bank Account Summaries") ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'bank-account-summary-grid',
	'type' => ' striped',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$columns
)); ?>
