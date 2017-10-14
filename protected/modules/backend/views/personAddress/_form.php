<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'person-address-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'person_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'address_1',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'address_2',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'state_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'city',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'is_main',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
