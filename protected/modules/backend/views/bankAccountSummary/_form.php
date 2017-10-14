<?php
/* @var $this BankAccountSummaryController */
/* @var $model BankAccountSummary */
/* @var $form TbActiveForm */
?>

<div class="form">

<?php 
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'fee-form',
                'enableAjaxValidation'=>false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )); ?>

    <p class="note"><?php echo MipHelper::t( "Fields with" ) ?> <span class="required">*</span> <?php echo MipHelper::t("are required") ?>    .</p>

        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->hiddenField($model,'bank_account_id'); ?>
        <?php echo $form->hiddenField($model,'data'); ?>
        <?php echo $form->hiddenField($model,'file_name'); ?>

        <div class="row-fluid">
                <div class="span2">
                <?php echo $form->labelEx($model,'year');?>
                <?php echo $form->dropDownList($model,'year', MipHelper::getYearLisBankAccountSummary(), array('style'=>'width:100%;', 'prompt'=>MipHelper::t("Select a Year"), 'disabled' => $model->isNewRecord ?'':'disabled') ) ?>
                <?php echo $form->error($model,'year');?>	
                </div>
        </div>
        
        <div class="row-fluid">
                <div class="span2">
                <?php echo $form->labelEx($model,'month');?>
                <?php echo $form->dropDownList($model,'month', MipHelper::getMonthListBankAccountSummary(), array('style'=>'width:100%;', 'prompt'=>MipHelper::t("Select a Month"), 'disabled' => $model->isNewRecord ?'':'disabled') ) ?>
                <?php echo $form->error($model,'month');?> 
                </div>
        </div>

        <div class="row-fluid">
                <div class="span3">
                    <?php echo $form->fileFieldRow($modelFile,'file'); ?>
                    <br>
                    <br>
                </div>
        </div>
        <div class="row-fluid">
            <div class="span5">
                <?php if(Yii::app()->user->hasFlash('error')):?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo Yii::app()->user->getFlash('error'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-actions">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                                'buttonType'=>'submit',
                                'type'=>'primary',
                                'label'=>$model->isNewRecord ? MipHelper::t('Create') : MipHelper::t( 'Save' ),
                        )); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->



<script>
    
    console.log($("#name").val())
</script>