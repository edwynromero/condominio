<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="row-fluid">
	
    <div id="login_form_section" class="span4 offset7 img-rounded">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"Acceso Privado",
		'htmlOptions'=>array( 'style'=>'borders: 0px;')
	));
	
?>



    <p class="note"><?php echo MipHelper::t("Please fill out the following form with your login credentials")?>:</p>
    
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    
        <p class="note-required"><?php echo MipHelper::t("Fields with");?><span class="required">*</span> <?php echo MipHelper::t("are required");?>.</p>
    
        <div class="row">
            <?php echo $form->labelEx($model,'username', array('style'=>'color:#c09853;')); ?>
            <?php echo $form->textField($model,'username', array('style'=>'text-align:center;')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    
        <div class="row">
            <?php echo $form->labelEx($model,'password', array('style'=>'color:#c09853;')); ?>
            <?php echo $form->passwordField($model,'password', array('style'=>'text-align:center;')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
    
        <div class="row buttons">
        	<div class="span3">
        		<?php echo CHtml::link( MipHelper::t('Forget Password'), $this->createAbsoluteUrl("//site/forget"),array('class'=>'text-warning forget-link')); ?>
        	</div>
        	<div class="span6" >
        	   <?php echo CHtml::submitButton('Login',array('class'=>'btn btn btn-inverse')); ?>
        	</div>
        	<div class="span3"></div>
         
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>
    </div>
</div>