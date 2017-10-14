<?php
/* @var $this BankAccountEntryController */
/* @var $model BankAccountEntry */
/* @var $form CActiveForm */
?>


<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'bank-account-entry-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div><?php echo $form->errorSummary($model); ?></div>

	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->labelEx($model,'begin_date'); ?>
			<?php $form->Widget('bootstrap.widgets.TbDatePicker',   array(
																	        'name' => 'BankAccountEntry[begin_date]',
																	        'htmlOptions' => array('readonly'=>'readonly','id'=>'date'),
																	        'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
																	    )
																	);


			?>
			<?php echo $form->error($model,'begin_date'); ?>
		</div>
		<div class="span2 offset1">
			<?php echo $form->labelEx($model,'end_date'); ?>
			<?php  $form->Widget('bootstrap.widgets.TbDatePicker',  array(
																	        'name' => 'BankAccountEntry[end_date]',
																	        'htmlOptions' => array('readonly'=>'readonly',"style"=>"width:100%;"),
																	        'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
																	    )
																	); ?>
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div>

	<div class="row-fluid">

		<div class="span5">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number',array("style"=>"width:100%;")); ?>
		<?php echo $form->error($model,'number'); ?>
		</div>

	
	</div>

	
	<div class="row-fluid">
	
		<div class="span5">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo $form->textArea($model,'summary',array("style"=>"width:100%; height:100px;")); ?>
		<?php echo $form->error($model,'summary'); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span3">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array("style"=>"width:80%;")); ?>
		<?php echo $form->hiddenField($model,'bank_account_summary_id',array('value'=>$bank_account_summary_id)); ?>
		<?php echo $form->error($model,'value'); ?>
		</div>
	</div>	

	
	
	
	
	<?php 
		$radioInput = array('I'=>'ingreso', 'O'=>'Egreso');
         echo $form->radioButtonList($model,'type',$radioInput,array('separator'=>" "));
	?>
		
	<div class="form-actions">
		<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-primary']); ?>
		</div>
	<?php $this->endWidget(); ?>
	</div>
	</div><!-- form -->
