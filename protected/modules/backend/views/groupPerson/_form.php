<?php 

/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'group-person-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>160)); ?>

	<?php echo $form->dropDownListRow($model,'type', MipHelper::getGroupPersonsTypeList() ,array('class'=>'span5','maxlength'=>1)); ?>
	
	<?php echo $form->checkBoxRow($model,'active',array()); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
