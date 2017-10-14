<?php
$this->breadcrumbs=array(
	'Bank Accounts',
);

$this->menu=array(

);

if(Yii::app()->user->checkAccess(BizLogic::CONST_ROL_ADMIN_KEY)){
    $this->menu[] = array('label'=>'Manage BankAccount','url'=>array('admin'));
    $this->menu[] = array('label'=>'Create BankAccount','url'=>array('create'));
}
?>

<h1><?php  echo  MipHelper::t("Bank Accounts") ?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
'itemsCssClass' => 'row-fluid',
'summaryCssClass' => 'text-left',
'template'=>'<div class="row-fluid"><div class="span12"> {summary}</div></div> {items}{pager}',
)); ?>
