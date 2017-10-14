<?php
/* @var $this AccountingMoveController */
/* @var $model AccountingMove */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'accounting-move-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo MipHelper::getHtmlFieldRequiered();  ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->datepickerRow($model, 'date_at',
            array(
                'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
                                    'htmlOptions'=>array( 'readonly'=>'readonly'),
            )
        );
        ?>
    </div>
        
    <div class="row">
		<?php echo $form->labelEx($model,'journal_id'); ?>
        <?php echo $form->dropDownList($model, 'journal_id', GxHtml::listDataEx(AccountingJournal::model()->findAllAttributes(array('id','title'), false), "id", "title"), array('style'=>'width:30%;')); ?>
		<?php echo $form->error($model,'journal_id'); ?>
	</div>
     
	<div class="row">
            <?php echo $form->labelEx($model,'label'); ?>
            <?php echo $form->textArea($model,'label',array('size'=>60,'maxlength'=>128,'style'=>'width:40%;','rows'=>'4')); ?>
            <?php echo $form->error($model,'label'); ?>
	</div>
             
	<div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->dropDownList($model, 'status', GxHtml::listDataEx(AccountingHelper::getAccountingMoveStatus($model->isNewRecord )),array('style'=>'width:10%;')); ?>
            <?php echo $form->error($model,'status'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
    
</div><!-- form -->