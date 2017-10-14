<?php 
/* @var $this Controller */
/* @var $model ResidentAssociation */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'resident-association-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model, 'person_id', MipHelper::getDataPersons(), array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'association_position_id', MipHelper::getDataAssociationPosition(),array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
