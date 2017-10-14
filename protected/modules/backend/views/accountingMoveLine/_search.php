<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accounting_move_id'); ?>
		<?php echo $form->textField($model,'accounting_move_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accounting_account_id'); ?>
		<?php echo $form->textField($model,'accounting_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accounting_period_id'); ?>
		<?php echo $form->textField($model,'accounting_period_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'debt'); ?>
		<?php echo $form->textField($model,'debt',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'credt'); ?>
		<?php echo $form->textField($model,'credt',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'balance'); ?>
		<?php echo $form->textField($model,'balance',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_at'); ?>
		<?php echo $form->textField($model,'date_at'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->label($model,'reconciled'); ?>
		<?php echo $form->textField($model,'reconciled'); ?>
	</div>

	<div class="row buttons form-actions">
		<?php echo CHtml::submitButton(MipHelper::t('Search'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->