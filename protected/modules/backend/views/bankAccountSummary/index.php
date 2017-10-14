<?php
/* @var $this BankAccountSummaryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	MipHelper::t( 'Bank Account Summaries'),
);

$this->menu=array(
	array('label'=>'Create BankAccountSummary', 'url'=>array('create', "bank_account_id"=>$bankAccount->id)),
	array('label'=>'Manage BankAccountSummary', 'url'=>array('admin',"bank_account_id"=>$bankAccount->id)),
);
?>

<h1><?php echo MipHelper::t("Bank Account Summaries"); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
