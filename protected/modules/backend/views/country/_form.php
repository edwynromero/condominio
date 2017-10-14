<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'country-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>4)); ?>
	
	<?php echo $form->textFieldRow($model,'iso_code',array('class'=>'span5','maxlength'=>2)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
