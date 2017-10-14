<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'parent_account_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_account_id', GxHtml::listDataEx(AccountingAccount::model()->findAllAttributes(null, true)), array('prompt' => 'All')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'type'); ?>
		<?php echo $form->dropDownList($model, 'type', GxHtml::listDataEx(AccountingAccountType::model()->findAllAttributes(array('`key`','label'), false))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'code'); ?>
		<?php echo $form->textField($model, 'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'label'); ?>
		<?php echo $form->textField($model, 'label', array('maxlength' => 45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'access_key'); ?>
		<?php echo $form->textField($model, 'access_key', array('maxlength' => 6)); ?>
	</div>

	<div class="row buttons form-actions">
		<?php echo GxHtml::submitButton(MipHelper::t('Search'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
