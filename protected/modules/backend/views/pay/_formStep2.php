<?php 
/* @var $form TbActiveForm */
/* @var $this Controller */
/* @var $model Pay */
/* @var $modelViewLocationFeePay ViewLocationFeePay */
/* @var $debtBeforePay double Deuda antes de Pagar*/

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pay-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>
<?php 
	//$currentBalance =  MipHelper::getPayBalancePersonId( $model->person_id ); 

	$currentPay = $model->value_cash;

	/* @var $payNotCashInfo PayNotCashInfo */
	foreach( $modelPayNotCash as $payNotCashInfo )
	{
		if( $payNotCashInfo->checked )
			$currentPay += $payNotCashInfo->value;
	}
	
	$feePayAmount = Fee::getAmountFeeCanceledByPay($model->id);
	
	$balanceAfterPay 	= $balanceBeforePay + $currentPay- $feePayAmount;
	
	$debtAfterPay 		= $debtBeforePay - $feePayAmount;
?>
<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model, "id"); ?>
	<div class="row-fluid">
		<div class="span4">			
			<label><?php echo MipHelper::t("Owner")?></label>
			<span class="uneditable-input" style="width: 100%;"><?php echo MipHelper::getPersonName( $model->person_id	);?></span>					
		</div>
		<div class="span2">		
			<div class="span2">
				<label>&nbsp;</label>
				<i>&nbsp;</i>
			</div>
			<div class="span10">
				<label><?php echo MipHelper::t("Pay Date")?></label>
				<span class="uneditable-input"  style="width: 100%;"><?php echo MipHelper::parseDateFromDb( $model->pay_date );?></span>
			</div>			
		</div>
		<div class="span3">			
			<label><i class="icon-exclamation-sign icon-red"> </i> <?php echo MipHelper::t("Debt before Pay")?></label>
			<span class="uneditable-input" style="width: 75%;"><?php echo MipHelper::formatCurrency( $debtBeforePay );?></span>					
		</div>		
	</div>
	<div class="row-fluid">
		<div class="span2">
			<label><i class="icon-info-sign"></i> <?php echo MipHelper::t("Current Balance")?></label>
			<span class="uneditable-input" style="width: 100%;"><?php echo MipHelper::formatCurrency(  $balanceBeforePay );?></span>		
		</div>
		<div class="span2" >
			<div class="span2">
				<label>&nbsp;</label>
				<i class="icon-plus"></i>
			</div>
			<div class="span10">
				<label><i class="icon-plus-sign"></i> <?php echo MipHelper::t("This Pay")?></label>
				<span class="uneditable-input" style="width: 100%;"><?php echo MipHelper::formatCurrency( $currentPay );?></span>
			</div>		
		</div>		
		<div class="span2">
			<div class="row-fluid">
				<div class="span2">
					<label>&nbsp;</label>
					<i class="icon-arrow-right"></i>
				</div>
				<div class="span10">
					<label><i class="icon-briefcase"></i> <?php echo MipHelper::t("Balance")?></label>
					<span class="uneditable-input"  style="width: 100%;"><?php echo MipHelper::formatCurrency( $balanceBeforePay + $currentPay );?></span>
				</div>
			</div>		
		</div>				
	</div>
	<div class="row-fluid">
		<div span="span12">
			<fieldset>
				<legend><?php echo MipHelper::t("Fees to bind to Pay")?></legend>
				<div class="row-fluid">
					<div class="span12">
					<?php $this->widget('bootstrap.widgets.TbGridView',array(
						'id'=>'view-location-fee-pay',
						'dataProvider'=>$modelViewLocationFeePay->searchByPay(),
						'afterAjaxUpdate'=>'onUpdateGrid',
						'columns'=>array(
											array(
													'header' => MipHelper::t("Fee"),
													'name' => 'feed_id',
													'type' => 'raw',
													'value' => 'MipHelper::createFeedLink( $data->feed_id )'
											),

											array(
													'name' => 'location_id',
													'type' => 'raw',
													'value' => 'MipHelper::createLocationLink( $data->location_id )'
											),
											array(
													'header' => MipHelper::t("Begin Date"),
													'name' => 'begin_date',
													'type' => 'html',
													'value' => 'MipHelper::parseDateFromDb($data->begin_date)'
											),
											array(
													'name' => 'value',
													'type' => 'html',
													'value' => 'MipHelper::formatCurrency($data->value)'
											),					
											array(
													'header'=> MipHelper::t("Fee Payed?"),
													'name' => 'fee_payed',
													'type' => 'raw',
													'value' => function( $data, $row )
															   {
																	return Yii::app()->controller->widget(
																			'bootstrap.widgets.TbToggleButton',
																			array(
																					'value' => $data->fee_payed,
																					'enabledLabel' => MipHelper::t("Yes"),
																					'disabledLabel' => MipHelper::t("No"),
																					'name' => 'toggle-fee-' . $data->feed_id . '_'. $data->location_id,
																					'onChange' => 'js:function( el, status, e){ onCheckFeeGrid( status, '. $data->feed_id . ', '. $data->location_id . ' ) }',
																					'htmlOptions'=>array(
																							'data-fee'=>$data->feed_id,
																							'data-location'=> $data->location_id),
																			),
																			true
																	);
															   },
													'htmlOptions'=>array('class'=>'toggle-check-column'),
											),
										),
										'type'=>TbHtml::GRID_TYPE_STRIPED,
										'template'=>$this->renderPartial('_tpl_grid_location_fee_pay',array('balanceAfterPay' => $balanceAfterPay, 'debtAfterPay' => $debtAfterPay), true),
						)); ?>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
<div class="form-actions">
	<div class="row-fluid">
		<div class="span4">
			<?php $this->widget('bootstrap.widgets.TbButton', array(					
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>MipHelper::t('Go Back'),
					'htmlOptions'=>array('submit'=>array('//backend/pay/payStep1', 'pay_id'=>$model->id))
				)); ?>			
		</div>
		<div class="offset5 span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(					
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>MipHelper::t('Finish'),
					'htmlOptions'=>array('submit'=>array('//backend/pay/admin'))
				)); ?>	
		</div>		
	</div>
</div>

<?php $this->endWidget(); ?>

<script>
	function onCheckFeeGrid(status, fee_id, location_id)
	{
		$.ajax({
            url: status?"<?php echo $this->createUrl("//backend/feePay/ajaxCreate")?>":"<?php echo $this->createUrl("//backend/feePay/ajaxDelete")?>",
            data: { 
                	"fee_id": fee_id,
                	"location_id": location_id,  
                	"pay_id": $("#Pay_id").val()
            },
            type: "POST",
            success: function(data) 
            { 
            	$.fn.yiiGridView.update( 'view-location-fee-pay' );
			}
        });
	}	

	function onUpdateGrid()
	{
		
		jQuery('[data-toggle=popover]').popover();
		jQuery('body').tooltip({"selector":"[data-toggle=tooltip]"});
		$("td.toggle-check-column  div > input").each(function(key,value) {
			var toggleId = "#wrapper-" + $(value).attr("id");
		    var toogle = $(toggleId).toggleButtons({'onChange':function( el, status, e)
														    { 
		    													var checkBox = $(el.context);
														    	onCheckFeeGrid( status, checkBox.data("fee"), checkBox.data("location") ) 
														    },
											    'width':100,
											    'height':25,
											    'animated':true,
											    'label':{'enabled':'Sí','disabled':'No'},
											    'style':{'enabled':'primary'},
												});
		});
	}
			
</script>	