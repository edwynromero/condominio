<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bank-account-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'bank_id', MipHelper::getDataBanks(), array('class'=>'span5','prompt'=>MipHelper::t("Nothing selected"))); ?>

	<?php echo $form->dropDownListRow($model,'account_type', MipHelper::getAccountTypeList(),array('class'=>'span5','maxlength'=>1, 'prompt'=>MipHelper::t("Nothing selected"))); ?>


	<?php echo $form->textFieldRow($model,'number',array('class'=>'span5','maxlength'=>255)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
