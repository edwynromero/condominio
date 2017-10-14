<?php
/* @var $this AccountingPeriodStatusController */
/* @var $model AccountingPeriodStatus */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'key'); ?>
		<?php echo $form->textField($model,'key',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'at_year'); ?>
		<?php echo $form->textField($model,'at_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'at_period'); ?>
		<?php echo $form->textField($model,'at_period'); ?>
	</div>

	

	<div class="row buttons form-actions">
		<?php echo CHtml::submitButton(MipHelper::t('Search'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->