<?php 
/* @var $this RegisterRequestController */
/* @var $model RegisterRequest */
/* @var $form TbActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'register-request-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

	<?php echo $form->errorSummary($model); ?>
	
	
	<?php if($model->isNewRecord ):?>
		<?php echo $form->hiddenField($model,'status',array('class'=>'span5')); ?>
	<?php else:?>
		<?php echo $form->dropDownListRow($model, 'status', RegisterRequest::getStatusList() )?>
	<?php endif;?>

	<?php echo $form->dropDownListRow($model,'identity_type', MipHelper::getIdentityTypeList(),array('class'=>'span5','maxlength'=>1, 'onchange'=>'onChangeIdentityType(this)')); ?>
	
	<?php echo $form->textFieldRow($model,'identity_code',array('class'=>'span5','maxlength'=>16)); ?>

	<span class="register-first-name"  style="<?php echo $this->displayCompany($model)?"display:none":"" ?>" >
	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>60)); ?>
	</span>

	<span class="register-last-name" style="<?php echo $this->displayCompany($model)?"display:none":"" ?>" >
	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>60)); ?>
	</span>

	<span class="register-full-name" style="<?php echo $this->displayCompany($model)?"":"display:none" ?>" >
	<?php echo $form->textFieldRow($model,'full_name',array('class'=>'span5 ','maxlength'=>120)); ?>
	</span>

	<?php echo $form->textAreaRow($model,'reference',array('rows'=>6, 'cols'=>50, 'class'=>'span5','maxlength'=>512)); ?>
	
	<?php echo $form->dropDownListRow($model,'phone_type',  MipHelper::getPhoneTypeList(), array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'phone_prefix',array('class'=>'span5','maxlength'=>5)); ?>

	<?php echo $form->textFieldRow($model,'phone_number',array('class'=>'span5','maxlength'=>9)); ?>

	<?php echo $form->textFieldRow($model,'person_email',array('class'=>'span5')); ?>
	
	<?php echo $form->textFieldRow($model,'person_email_confirm',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_name',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->passwordFieldRow($model,'user_password',array('class'=>'span5','maxlength'=>45)); ?>
	
	<?php echo $form->passwordFieldRow($model,'user_password_confirm',array('class'=>'span5','maxlength'=>45)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
<!--
	function onChangeIdentityType( element )
	{
		var identityType =  $(element).val();
	
		if( identityType == '<?php echo Person::IDENTITY_TYPE_COMPANY ?>' ||  identityType == '<?php echo Person::IDENTITY_TYPE_FIRM ?>' ||  identityType == '<?php echo Person::IDENTITY_TYPE_GOVERN ?>'  )
		{
			$('.register-first-name').hide();
			$('.register-last-name').hide();
			$('.register-full-name').show();	
		}
		else
		{
			$('.register-first-name').show();
			$('.register-last-name').show();
			$('.register-full-name').hide();	
		}
	}
//-->
</script>
