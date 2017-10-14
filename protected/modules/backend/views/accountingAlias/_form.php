<div class="form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'accounting-alias-form',
	'enableAjaxValidation' => false,
));
?>

	<?php echo MipHelper::getHtmlFieldRequiered(); ?>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model, 'key', array('maxlength' => 6,'style'=>'width:7%;')); ?>
		<?php echo $form->error($model,'key'); ?>
        </div><!-- row -->
        
        <div class="row">
		<?php echo $form->labelEx($model,'account_id'); ?>
		<?php echo $form->dropDownList($model, 'account_id', GxHtml::listDataEx(AccountingAccount::model()->findAllAttributes(array('id','label'), false))); ?>
		<?php echo $form->error($model,'account_id'); ?>
	</div><!-- row -->
        
        
        <div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model, 'label', array('maxlength' => 64,'style'=>'width:34%;')); ?>
		<?php echo $form->error($model,'label'); ?>
	</div><!-- row -->
        
       <div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model, 'alias', array('maxlength' => 64,'style'=>'width:34%;')); ?>
		<?php echo $form->error($model,'alias'); ?>
        </div><!-- row -->
                
		
       


<?php
echo GxHtml::submitButton(MipHelper::t('Save'), array('class'=>'btn btn-primary'));
$this->endWidget();
?>
</div><!-- form -->