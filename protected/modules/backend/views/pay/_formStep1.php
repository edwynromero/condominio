<?php 
/* @var $form TbActiveForm */
/* @var $this Controller */
/* @var $model Pay */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pay-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model, "id"); ?>
	<div class="row-fluid">
		<div class="span3">
			<?php
			echo $form->select2Row($model,'person_id', array(
					'data' =>MipHelper::getDataOwnerPersons($this->location_id),
			),array(''=>'','style'=>'margin-bottom:200xmen;','prompt'=>MipHelper::t("Select a Person")));
			?>
			<?php echo $form->error($model, 'person_id'); ?>
		</div>
		<div class="span2">
			<?php echo $form->datePickerRow($model, 'pay_date',
			            array(
			                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
								'htmlOptions'=>array('style'=>'width:100%;')
			            )
			        );
			?>

		</div>
		<div class="span2">
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
												"htmlOptions"=>array('style'=>'width:100%;', 'disabled' => Yii::app()->user->checkAccess('admin')?'':'disabled')
							                    ));?>		
			<?php echo $form->error($model, 'value_cash')?>
		</div>
	</div>
	<div class="row-fluid">
		<div span="span12">
			<fieldset>
				<legend><?php echo MipHelper::t("Checks, Transfers and Vouchers")?></legend>
				<div class="row-fluid">
					<div class="offset3 span3">
						<?php
							// Boton para crear un nuevo tipo de unidad.
							echo CHtml::ajaxLink(MipHelper::t("Refresh"),$this->createUrl('pay/ajaxNotCashInfo'),
								array(
									'replace'=>'#section-tabnotcashinfo',
									'type'=>'GET',
									'data'=> array('pay_id'=>'js:function(){ return $("#Pay_id").val(); }'),
								),
					        	array(	'id'=>'btnRefreshNotCashInfo', 
									'class'=>'hide',
								)
					        );
						?>						
					</div>
					<div class="offset3 span2">				
						<?php
							//
							// Botón para crear nuevo pago "no en efectivo"
							//
							echo CHtml::ajaxLink(MipHelper::t("Add Not Cash"),$this->createUrl('pay/ajaxCreateNotCashInfo'),
								array(
									'update'=>'#createNotCashInfo',
									'type'=>'GET',
									'data'=> array('person_id'=>'js:function(){ return $("#Pay_person_id").val(); }', 'pay_id'=>'js:function(){ return $("#Pay_id").val(); }'),
									'beforeSend'=>$model->isNewRecord?'alertSavePayForNotCash':'beforeAddNotCash',
								),
					        	array(	'id'=>'btnCreateNotCashInfo', 
										'class'=>'btn btn-success',
								)
					        );
						?>
						<div id="createNotCashInfo"></div>
						<div id="updateNotCashInfo"></div>				
					</div>
				</div>
				<?php $this->renderPartial('_table_notcashinfo', array( 'model'=> $model, 'modelPayNotCash'=>$modelPayNotCash ))?>
			</fieldset>
		</div>
	</div>
<div class="form-actions">
	<div class="row-fluid">
		<div class="span4">
			<?php $this->widget('bootstrap.widgets.TbButton', array(					
					'buttonType'=>'submit',
					'type'=>'btn',
					'label'=>MipHelper::t('Close'),
					'htmlOptions'=>array('submit'=>array('//backend/pay/admin'))
				)); ?>			
			<?php 
				$submitOptions = array('pay_id'=>$model->id);
				if( !is_null($this->fee_id) && !is_null($this->location_id))
				{
					$submitOptions['fee_id']=$this->fee_id;
					$submitOptions['location_id']=$this->location_id;
				}
				$submitOptions['step'] = 1;

				$this->widget('bootstrap.widgets.TbButton', array(					
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>MipHelper::t('Save'),
					'htmlOptions'=>array('submit'=>$this->createUrl($this->step1Action, $submitOptions))
				)); ?>				
		</div>
		<div class="offset5 span3">
			<?php
                            if( Yii::app()->user->checkAccess(BizLogic::CONST_ROL_ADMIN_KEY)  ){
				$submitOptions['step'] = 2;
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>$this->isActionAddSingleFee()?MipHelper::t('Save and End'):MipHelper::t('Continue - Feeds'),
					'htmlOptions'=>array('submit'=>$this->createUrl($this->step1Action,$submitOptions))
				));   
                            }

                         ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
<script>
	function updatePayNotCash(pay_id)
	{
		jQuery("#Pay_id").val(pay_id);
		jQuery("#btnRefreshNotCashInfo").click();
		jQuery("#createPayNotCashInfoDialog").modal("hide");
	}

	function beforeAddNotCash (jqXHR,settings){
		if( $("#Pay_person_id").val() == "" ) 
		{ 
			alert("Debe seleccionar a una persona"); return false; 
		} 
	}

	function alertSavePayForNotCash()
	{
		alert("Debe guardar el registro antes de agregar un Pago no en Efectivo"); 
		return false;	
	}
</script>
