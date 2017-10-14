<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'location-form',
	'enableAjaxValidation'=>false,
));  ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

	<?php echo $form->errorSummary($model); ?>	

	<?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>10)); ?>
	
	<?php echo $form->dropDownListRow($model,'status', MipHelper::getLocationStatusList(),array('class'=>'span5', 'prompt'=>MipHelper::t('Choice a Status'))); ?>
	
	<?php  echo $form->labelEx($model, 'initial_debt') ?>
	
	<?php $this->widget("FormatCurrency",
					                array(
					                   "model" => $model,
					                    "attribute" => "initial_debt",
					                	"value"=>$model->initial_debt,
					                    "options" => array( "negativeFormat"=>'-%s%n',
												            "roundToDecimalPlace" => 2,
												            "region"=> 'es-VE',
												            "decimalSymbol" => ',',
												            "digitGroupSymbol" => '.'),
										"htmlOptions"=>array("class"=>"span3")
					                    ));?>
					                    
	<?php echo $form->textAreaRow($model,'comments',array('class'=>'span5','maxlength'=>120)); ?>
	
	<?php echo $form->checkBoxRow($model,'is_built',array()); ?>	

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? MipHelper::t('Create') : MipHelper::t('Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
