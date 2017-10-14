<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'accounting-move-ref-type-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'key',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'associated_name',array('class'=>'span5','maxlength'=>64)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
