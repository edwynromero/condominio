<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'person-email-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php if( empty($person_id) ): ?>	
	<?php echo $form->dropDownListRow($model,'person_id', MipHelper::getDataPersons() ,array('class'=>'span5')); ?>
	<?php else: ?>
	<?php echo $form->dropDownListRow($model,'person_id', MipHelper::getDataPersons() , array('class'=>'span5', 'disabled'=>true)); ?>
	<?php endif; ?>
	
	<?php echo $form->telFieldRow($model,'email',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->checkBoxRow($model,'is_main',array()); ?>
	
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
