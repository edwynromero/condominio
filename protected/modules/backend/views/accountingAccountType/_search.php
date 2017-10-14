<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'key'); ?>
		<?php echo $form->textField($model, 'key', array('maxlength' => 4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'label'); ?>
		<?php echo $form->textField($model, 'label', array('maxlength' => 64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_debt'); ?>
		<?php echo $form->dropDownList($model, 'is_debt', array('0' => 'No', '1' => 'Yes'), array('prompt' => 'All')); ?>
	</div>

	<div class="row buttons form-actions">
		<?php echo GxHtml::submitButton(MipHelper::t('Search'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
