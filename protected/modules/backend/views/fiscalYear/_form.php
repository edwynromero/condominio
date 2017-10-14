<?php
/* @var $this FiscalYearController */
/* @var $model FiscalYear */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'fiscal-year-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo MipHelper::getHtmlFieldRequiered(); ?>

	<?php echo $form->errorSummary($model); ?>

	
        <div class="row-fluid"> 
           <div class="span2">
			
			


			<?php echo $form->datepickerRow($model, 'from',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array( 'readonly'=>'readonly','style'=>'width:100%;'),

		            )
		        );
			?>
			
		</div> 
                       
           <div class="span2">
			
			<?php echo $form->datepickerRow($model, 'to',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array( 'readonly'=>'readonly','style'=>'width:100%;'),

		            )
		        );
			?>
			
		</div> 
            
            
            
        </div>    

        
  
        <div class="row">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>64,'style'=>'width:33%;')); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>
         

	
            
          
        <div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', GxHtml::listDataEx(AccountingPeriodStatus::model()->findAll('at_year=:at_year', array(':at_year'=>true))),array('style'=>'width:18%;')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

        
        
        
        

	<div class="row">
		<?php echo $form->labelEx($model,'is_closed'); ?>
		<?php echo $form->checkBox($model,'is_closed'); ?>
		<?php echo $form->error($model,'is_closed'); ?>
	</div>
        
        <br>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? MipHelper::t('Create') : MipHelper::t('Save'), array("class"=>"btn btn-primary")); ?>
	</div>
        

<?php $this->endWidget(); ?>

</div><!-- form -->