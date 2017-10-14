<?php
    /* @var $this SiteController */
    /* @var $payNotCash PayNotCashInfo */
    /* @var $form TbActiveForm */

    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'pay-form',
            'enableAjaxValidation'=>false,
    ));
?>
<h3><?php echo MipHelperFront::t("Report payment");  ?></h3>
<hr>
<br>
<div class="row-fluid">
	<span class="payments-summary">Sólo se pueden Reportar Pagos por Transferencias, o Depósitos en Bancos mediante el Voucher.</span>
</div>
<br>
<div class="row-fluid">
    <div class="span4">
        <h4><?php echo MipHelperFront::t("Payment Type"); ?></h4>
        <div class="btn-group" data-toggle="buttons-radio" style="width:100%">
            <button id="btn-transfer" type="button" class="btn "  style="width:50%"><?php echo MipHelperFront::t("Transfer"); ?></button>
            <button id="btn-voucher" type="button" class="btn " style="width:50%"><?php echo MipHelperFront::t("Voucher"); ?></button>
        </div>
        <?php  echo $form->error($payNotCash, 'type') ?>
        <?php echo $form->hiddenField($payNotCash, 'type', array("id"=>"pay-type")) ?>
    </div>
    <div class="span4">
    	<h4><?php echo MipHelperFront::t("Date"); ?></h4>
		<?php echo $form->datepickerRow($payNotCash, 'pay_date',
			            array(
			                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
								'htmlOptions'=>array('class'=>'', 'readonly'=>'readonly')
			            ),
						array(  'label'=>'', 'errorOptions' => false )
			        );
		?>
    	<?php  echo $form->error($payNotCash, 'pay_date') ?>
    </div>
    <div class="span3">

    </div>
</div>
<div class="row-fluid">
     <div class="span4">
     	<div id="bank_selector_container" style="display:none;">
	        <h4><?php echo MipHelperFront::t("Bank"); ?></h4>
	        <?php echo $form->dropDownList($payNotCash, "source_bank_id", $bankList, array('style'=>'width:95%;', "empty" => "- ". MipHelperFront::t("Select a Bank") ." -") ) ?>
	        <?php  echo $form->error($payNotCash, 'source_bank_id') ?>
        </div>
    </div>
    <div class="span4">
        <h4><span id="label-reference">N°&nbsp;<?php echo MipHelperFront::t("Reference"); ?></span></h4>
        <?php echo $form->telField($payNotCash, "number", array('style'=>'width:95%;', 'maxlength'=>16, "id"=>"pay-number" )  ) ?>
        <?php  echo $form->error($payNotCash, 'number') ?>
    </div>
    <div class="span4">
        <h4><?php echo MipHelperFront::t("Amount"); ?></h4>
        <?php $this->widget("FormatCurrency",
                                                array(
                                                   "model" => $payNotCash,
                                                    "attribute" => "value",
                                                    "value"=>$payNotCash->value,
                                                    "options" => array( "negativeFormat"=>'-%s%n',
                                                                                                    "roundToDecimalPlace" => 2,
                                                                                                    "region"=> 'es-VE',
                                                                                                    "decimalSymbol" => ',',
                                                                                                    "digitGroupSymbol" => '.'),
                                                                        "htmlOptions"=>array('style'=>'width:100%;' )
                                                    ));?>
        <?php  echo $form->error($payNotCash, 'value') ?>
    </div>   
</div>

<div class="row-fluid">
     <div class="span4">
         <br>
         <h4 class="text-success"><?php echo MipHelperFront::t("Select the account you made the transfer or deposit"); ?></h4>
    </div>
    <div class="span8">
        <h4><?php echo MipHelperFront::t("Target Account"); ?></h4>
        <?php echo $form->dropDownList($payNotCash, "bank_account_id", $accountList, array('style'=>'width:100%;') ) ?>
        <?php  echo $form->error($payNotCash, 'bank_account_id') ?>
    </div>
</div>
<br>
<div class="well well-small">
    <div class="row-fluid">
        <div class="span12 text-center">
            <?php echo CHtml::submitButton(MipHelperFront::t("Send"), array('class'=>'btn btn-success')); ?>
        </div>
    </div>
</div>
<br>
<?php $this->endWidget(); ?>
<script>
        
    jQuery(document).ready(function(){
       
       jQuery("#btn-voucher").on("click", function(){
    	   jQuery("#bank_selector_container").hide();
    	   jQuery("#selected-source-pay-empty" ).hide();
    	   jQuery("#selected-source-pay" ).show();    	   
    	   jQuery("#voucher-error" ).show();
    	   jQuery("#bank-number-error" ).hide();
    	   jQuery("#label-reference").html("Número de Depósito");
           jQuery("#pay-type").val("<?php echo PayNotCashInfo::PAY_TYPE_VOUCHER ?>");
       });

       jQuery("#btn-transfer").on("click", function(){
    	   jQuery("#bank_selector_container").show();
    	   jQuery("#selected-source-pay-empty" ).hide();
    	   jQuery("#selected-source-pay" ).show();    	   
    	   jQuery("#voucher-error" ).hide();
    	   jQuery("#bank-number-error" ).show();
    	   jQuery("#label-reference").html("Cuenta Bancaria Origen");
           jQuery("#pay-type").val("<?php echo PayNotCashInfo::PAY_TYPE_TRANSFER ?>");
       });

       
        $('#pay-number').bind('keypress', function (e) {
            return (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57) ) ? false : true;
        });
        
        $('#value_text').bind('keypress', function (e) {
            return (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57) && e.which !== 44   ) ? false : true;
        });       

        <?php if($payNotCash->type == PayNotCashInfo::PAY_TYPE_VOUCHER ): ?>
        	jQuery("#btn-voucher").click();
        <?php elseif($payNotCash->type == PayNotCashInfo::PAY_TYPE_TRANSFER ):?>
        	jQuery("#btn-transfer").click();
        <?php endif;?>

    });
</script>