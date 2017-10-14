<?php 
/* @var $this Controller */
/* @var $model FeeSchedule */
/* @var $form TbActiveForm */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'fee-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	
	
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->labelEx($model,'fee_type_id');?>
			<?php echo $form->dropDownList($model,'fee_type_id', MipHelper::getDataFeeType(), array('style'=>'width:100%;', 'prompt'=>MipHelper::t("Select a Fee Type")) ) ?>
			<?php echo $form->error($model,'fee_type_id');?>		
		</div>
		<div id="row-link-fee-type-copy'" class="span5">
			<?php
				// Boton para crear un nuevo tipo de unidad.
				echo CHtml::ajaxLink(MipHelper::t("Copy Fee Type"),$this->createUrl('feeType/ajaxDataToCopy'),
					array('success'=>'js:
							function(data) {
				        		$("#Fee_name").val(data.title);
								$("#Fee_summary").val(data.summary);
								$("#value_text").val(data.value);
								$("#value_text").keyup();
				            }',
							'dataType'=>'json',
							'type'=>'GET',
							'data'=>array('id'=>'js:function(){ return $("#Fee_fee_type_id").val() }'),
					),
		        	array(	'id'=>'link-fee-type-copy', 
							'class'=>'btn btn-info',
							'style'=>'margin-top:24px;',
					)
		        );
			?>			
		</div>
	</div>	
	<div class="row-fluid">
		<div class="span2">
	<?php echo $form->datepickerRow($model, 'begin_date',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array('class'=>'pull-left', 'style'=>'width:100%;')
		            )
		        );
	?>
		</div>
		<div class="span2 offset1">
	<?php echo $form->datepickerRow($model, 'end_date',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array('class'=>'pull-right', 'style'=>'width:100%;')
		            )
		        );
	?>
		</div>
	</div>	
	
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>60)); ?>

	<?php echo $form->textAreaRow($model,'summary',array('class'=>'span5','maxlength'=>255)); ?>

	<?php  echo $form->labelEx($model, 'value') ?>
	
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
										"htmlOptions"=>array("class"=>"span5")
					                    ));?>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
