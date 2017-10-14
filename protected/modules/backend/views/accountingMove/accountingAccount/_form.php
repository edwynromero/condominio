<div class="form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'accounting-account-form',
	'enableAjaxValidation' => false,
));
?>

	<?php echo MipHelper::getHtmlFieldRequiered(); ?>
        
	<?php echo $form->errorSummary($model); ?>

		
        
        <div class="row">   
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model, 'type', GxHtml::listDataEx(AccountingAccountType::model()->findAllAttributes(array('`key`','label'), false))); ?>
		<?php echo $form->error($model,'type'); ?>
        </div>
        
         <div class="row">    
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model, 'code', array('style'=>'width:20%;')); ?>
		<?php echo $form->error($model,'code'); ?>
        </div>
        
         <div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model, 'label', array('maxlength' => 45,'style'=>'width:34%;')); ?>
		<?php echo $form->error($model,'label'); ?>
         </div>
        
        

        <div class="row-fluid well well-small" style="width:98.5%;">
                <div class="span">
                    
                </div>
            
                <div class="span2">
		<?php echo $form->labelEx($model,'debt'); ?>
		<?php echo $form->textField($model, 'debt', array('maxlength' => 10,'style'=>'width:80%;')); ?>
		<?php echo $form->error($model,'debt'); ?>
                </div>
            
                <div class="span2">
		<?php echo $form->labelEx($model,'credt'); ?>
		<?php echo $form->textField($model, 'credt', array('maxlength' => 10,'style'=>'width:80%;')); ?>
		<?php echo $form->error($model,'credt'); ?>
                </div>
                    
                <div class="span2">
		<?php echo $form->labelEx($model,'balance'); ?>
		<?php echo $form->textField($model, 'balance', array('maxlength' => 10,'style'=>'width:80%;')); ?>
		<?php echo $form->error($model,'balance'); ?>
                </div>
        </div>
        
        
        <br>
        <br>
        
        <div class="row"> 
		<?php echo $form->labelEx($model,'parent_account_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_account_id', GxHtml::listDataEx(AccountingAccount::model()->findAllAttributes(array('id','label'), false)), array('empty'=>'NULL')); ?>
		<?php echo $form->error($model,'parent_account_id'); ?>
        </div>
        
        <div class="row">
                    
                <div class="span2">
		<?php echo $form->labelEx($model,'access_key'); ?>
		<?php echo $form->textField($model, 'access_key', array('maxlength' => 6,'style'=>'width:50%;')); ?>
		<?php echo $form->error($model,'access_key'); ?>
                </div>
        </div>
        
        <br>
<?php
echo GxHtml::submitButton(MipHelper::t('Save'), array('class'=>'btn btn-primary'));
$this->endWidget();
?>
</div><!-- form -->