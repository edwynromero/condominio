<?php 

/* @var $form TbActiveForm */
/* @var $this Controller */
/* @var $model PayNotCashInfo */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pay-not-cash-info-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'pay_id'); ?>
	
	<?php echo $form->dropDownListRow($model,'type', MipHelper::getNotCashTypeList(),array('class'=>'span5', 'prompt'=>MipHelper::t('Choice Account Type'), 'disabled'=>'disabled', 'readonly'=>'readonly' )); ?>
	
	<?php echo $form->dropDownListRow($model,'source_bank_id', MipHelper::getDataBanks(), array('class'=>'span5', 'prompt'=>MipHelper::t('Choice a Bank') , 'disabled'=>'disabled', 'readonly'=>'readonly' ) ); ?>	

	<?php echo $form->textFieldRow($model,'number',array('class'=>'span5','maxlength'=>255, 'disabled'=>'disabled', 'readonly'=>'readonly' )); ?>	
	
	<?php echo $form->dropDownListRow($model,'bank_account_id', MipHelper::getDataBankAccount(), array('class'=>'span5', 'prompt'=>MipHelper::t('Choice a Bank Account'), 'disabled'=>'disabled', 'readonly'=>'readonly' )); ?>
		
	<?php  echo $form->label($model, 'value', array( 'class' => $model->hasErrors('value')?$form->errorMessageCssClass:'' )) ?>
		
	<?php $this->widget("FormatCurrency",
					                array(
					                   "model" => $model,
					                    "attribute" => "value",
					                	"value"=>$model->value,
					                    "options" => array( "negativeFormat"=>'-%s%n',
												            "roundToDecimalPlace" => 2,
												            "region"=> 'es-VE',
												            "decimalSymbol" => ',',
												            "digitGroupSymbol" => '.'),
										"htmlOptions"=>array("class"=>"span3", 'disabled'=>'disabled', 'readonly'=>'readonly' )
					                    ));?>
					                    
	<?php echo $form->error($model,"value"); ?>
	<div >
		<br>	
		<?php  echo $form->checkBoxRow($model, 'checked', array( 'class' => '' )) ?>
		<br>	
	</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(					
			'buttonType'=>'submit',
			'type'=>'btn',
			'label'=>MipHelper::t('Close'),
			'htmlOptions'=>array('submit'=>array('//backend/payNotCashInfo/review'))
		)); ?>			
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? MipHelper::t('Create') : MipHelper::t('Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
