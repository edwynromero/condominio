<?php
/* @var $this RegisterRequestController */
/* @var $model RegisterRequest */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-request-register_request_form-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name'); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_name'); ?>
		<?php echo $form->textField($model,'full_name'); ?>
		<?php echo $form->error($model,'full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identity_code'); ?>
		<?php echo $form->textField($model,'identity_code'); ?>
		<?php echo $form->error($model,'identity_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identity_type'); ?>
		<?php echo $form->textField($model,'identity_type'); ?>
		<?php echo $form->error($model,'identity_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_prefix'); ?>
		<?php echo $form->textField($model,'phone_prefix'); ?>
		<?php echo $form->error($model,'phone_prefix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_number'); ?>
		<?php echo $form->textField($model,'phone_number'); ?>
		<?php echo $form->error($model,'phone_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_type'); ?>
		<?php echo $form->textField($model,'phone_type'); ?>
		<?php echo $form->error($model,'phone_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'person_email'); ?>
		<?php echo $form->textField($model,'person_email'); ?>
		<?php echo $form->error($model,'person_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name'); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_password'); ?>
		<?php echo $form->textField($model,'user_password'); ?>
		<?php echo $form->error($model,'user_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reference'); ?>
		<?php echo $form->textField($model,'reference'); ?>
		<?php echo $form->error($model,'reference'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->