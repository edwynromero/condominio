<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveReference */
/* @var $form TbActiveForm */
?>
<div class="form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'accounting-move-line-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <?php echo MipHelper::getHtmlFieldRequiered(); ?>
    <div class="row-fluid">
        <div class="span4" >
            <?php echo $form->labelEx($model,'label'); ?>
            <?php echo $form->textField($model, 'label', array('size'=>'64', 'style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'label'); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2" >
            <?php echo $form->labelEx($model,'value'); ?>
            <?php echo $form->textField($model, 'value', array('size'=>'16', 'style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'value'); ?>
        </div>
    </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? MipHelper::t( 'Create'): 'Save', array('class'=>'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
