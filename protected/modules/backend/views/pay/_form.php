<?php 
/* @var $form TbActiveForm */
/* @var $this Controller */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pay-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'person_id', MipHelper::getDataOwnerPersons() ,array('class'=>'span3', 'prompt'=>MipHelper::t("Select a Person"))); ?>
	
	<?php echo $form->datepickerRow($model, 'pay_date',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array('class'=>'span3')
		            )
		        );
	?>

	<?php  echo $form->labelEx($model, 'value_cash	') ?>
	
	<?php $this->widget("FormatCurrency",
					                array(
					                   "model" => $model,
					                    "attribute" => "value_cash",
					                	"value"=>$model->value_cash,
					                    "options" => array( "negativeFormat"=>'-%s%n',
												            "roundToDecimalPlace" => 2,
												            "region"=> 'es-VE',
												            "decimalSymbol" => ',',
												            "digitGroupSymbol" => '.'),
										"htmlOptions"=>array("class"=>"span3")
					                    ));?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create and Add not Cash' : 'Save and Add not Cash',
		)); ?>
</div>

<?php $this->endWidget(); ?>
