<?php 
/* @var $form TbActiveForm */
/* @var $this Controller */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'fee-pay-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'mip_pay_id', MipHelper::getDataPay(), array('class'=>'span5', 'prompt'=>MipHelper::t("Choice a Pay"))); ?>

	<?php echo $form->dropDownListRow($model,'mip_fee_id', MipHelper::getDataFee(), array('class'=>'span5', 'prompt'=>MipHelper::t("Choice a Fee"))); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
