<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'auth-assignment-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'itemname',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'userid',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textAreaRow($model,'bizrule',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'data',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
