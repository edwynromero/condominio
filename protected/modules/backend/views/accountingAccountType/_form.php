<div class="form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'accounting-account-type-form',
	'enableAjaxValidation' => false,
));
?>

	<?php echo MipHelper::getHtmlFieldRequiered(); ?>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model, 'key', array('maxlength' => 4,'style'=>'width:7%;')); ?>
		<?php echo $form->error($model,'key'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model, 'label', array('maxlength' => 64,'style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'label'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'is_debt'); ?>
		<?php echo $form->checkBox($model, 'is_debt'); ?>
		<?php echo $form->error($model,'is_debt'); ?>
		</div><!-- row -->
                <br>
<?php
echo GxHtml::submitButton(MipHelper::t('Save'), array('class'=>'btn btn-primary'));
$this->endWidget();
?>
</div><!-- form -->