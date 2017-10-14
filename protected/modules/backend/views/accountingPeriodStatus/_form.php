<?php
/* @var $this AccountingPeriodStatusController */
/* @var $model AccountingPeriodStatus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-period-status-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo MipHelper::getHtmlFieldRequiered(); ?>

	<?php echo $form->errorSummary($model); ?>

        
   
	<div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model,'key',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>64,'style'=>'width:32%;')); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>
     
        
        <div class="row-fluid">
                <div class="span1">
                   <?php echo $form->checkBox($model,'at_period'); ?> 
		
                <div class="span1" style="position:relative;left:30%;">   
		<?php echo $form->labelEx($model,'at_period', array('style'=>'width:80px')); ?>
		<?php echo $form->error($model,'at_period'); ?>
                </div>    
                </div>
        
 
                <div class="span2">
		
                    <?php echo $form->checkBox($model,'at_year'); ?>
                <div class="span1" style="position:relative;left:15%;">    
		<?php echo $form->labelEx($model,'at_year',array('style'=>'width:60px')); ?>
		<?php echo $form->error($model,'at_year'); ?>
                </div>
                </div>    
        </div>
	
        <br>
     
        

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? MipHelper::t('Create') : MipHelper::t('Save'), array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


      