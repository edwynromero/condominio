<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'person-phone-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php if( empty($person_id) ):?>
	<?php echo $form->dropDownListRow($model,'person_id', MipHelper::getDataPersons(), array('class'=>'span5')); ?>
	<?php else: ?>
	<?php echo $form->dropDownListRow($model,'person_id', MipHelper::getDataPersons(), array('class'=>'span5', 'disabled' => true )); ?>
	<?php endif;?>
	
	<?php echo $form->dropDownListRow($model,'country_id', MipHelper::getDataCountries(), array('class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model,'type',  MipHelper::getPhoneTypeList(), array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'prefix',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'number',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'is_main',array()); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<script language="javascript">
	$(document).ready(function(){

		$("#PersonPhone_country_id").val("<?php echo MipHelper::getDefaultCountry()->id; ?>");
	});
</script>

<?php $this->endWidget(); ?>
