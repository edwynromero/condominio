<?php
/* @var $this SiteController */
/* @var $model RecoveryPassword */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Recover Password';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="row-fluid">
	
    <div id="login_form_section" class="span4 offset7 img-rounded">
	<?php
	
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>MipHelper::t("Recovery your access password"),
			'htmlOptions'=>array( 'style'=>'borders: 0px;', 'class'=>'warning')
		));
		
	?>
    <p class="note"><?php echo MipHelper::t("Please fill out the following form for recover password")?>:</p>
    
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'recovery-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        	'afterValidate'=>'js:disableEmailForm',
        ),
    )); ?>
    
        <p class="text-warning"><?php echo MipHelper::t("Fields with");?><span class="required">*</span> <?php echo MipHelper::t("are required");?>.</p>
    
        <div class="row">
            <?php echo $form->labelEx($model,'email', array('style'=>'color:#c09853;')); ?>
            <?php echo $form->textField($model,'email', array('style'=>'text-align:center;')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
    
        <div class="row">
            <?php echo $form->labelEx($model,'email_confirm', array('style'=>'color:#c09853;')); ?>
            <?php echo $form->textField($model,'email_confirm', array('style'=>'text-align:center;')); ?>
            <?php echo $form->error($model,'email_confirm'); ?>
        </div>
    
        <div class="row buttons">
            <?php echo CHtml::submitButton( MipHelper::t('Recovery'),array('class'=>'btn btn btn-inverse btn-recovery')); ?>
            <div id="msg_processing_request" class="row-fluid" style="display:none">
            	<div class="span1"></div>
            	<div class="span10">
					<div class="alert alert-warning  alert-block" >
						<div class="row-fluid">
							<div class="span12">
								<h5>Procesando la solicitud ... </h5>
							</div>
						</div>
					</div>
            	</div>
            	<div class="span1"></div>
            </div>
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>
    </div>
</div>
<script>
    function disableEmailForm(form, data, hasError) 
    {
        if( !hasError )
        {
			$('.btn-recovery').hide();
			$('#msg_processing_request').show();
        }
        return true;
    }
</script>