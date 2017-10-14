<?php

/* @var $this SiteController */
/* @var $form TbActiveForm */
/* @var $pay Pay */

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 

$balance = ($total_amount - $fee_amount_payed) > 0? $total_amount - $fee_amount_payed: 0.00;
$flashes = Yii::app()->user->getFlashes();

?>
<h3><?php echo MipHelperFront::t("My payments");  ?></h3>
<hr>
<br>
<div class="row-fluid">
	<span class="payments-summary">El saldo de los montos abonados es
		Personal, del monto en Cuenta se deduce el total del Monto que haya
		sido relacionado a las Cuotas de las Parcelas de las que se es
		Propietario. Los montos abonados por Transferencia o Depósito, sólo se
		abonarán cuando sean confirmados en la cuenta.</span>
</div>
<br>
<div class="row-fluid row-debt btn-success">
	<div class="span6 text-right">
		<h4><?php echo MipHelperFront::t("Balance in Favor"); ?>:</h4>
	</div>
	<div class="span6 text-left">
		<h4><?php echo MipHelper::formatCurrency( $balance ); ?></h4>
	</div>
</div>
<br>
<div class="row-fluid">
	<div class="span12 text-center">
		<strong>Si requiere información más detallada puede consultar usando el
		Botón "Detalle"</strong>
	</div>
</div>
<br>
<?php if( isset($flashes["success"]) ): ?>
<div class="row-fluid alert-payment-success">
	<div class="span12">    
		<div class="alert alert-success text-center">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo  $flashes["success"] ?> 
		</div>
	</div>
</div>
<?php endif; ?>
<?php if( count($payments) > 0 ): ?>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped">
			<thead>
				<tr>
					<td class="col_current_debt"><h4><?php echo MipHelperFront::t("ID") ?></h4></td>
					<td class="col_current_debt"><h4><?php echo MipHelperFront::t("Date") ?></h4></td>
					<td class="col_current_debt"><h4><?php echo MipHelperFront::t("Payer") ?></h4></td>
					<td class="col_current_debt"><h4><?php echo MipHelperFront::t("Reported") ?></h4></td>
					<td class="col_current_debt"><h4><?php echo MipHelperFront::t("Taken") ?></h4></td>
					<td class="btn-pay-detail"></td>
				</tr>
			</thead>
			<tbody>
                <?php foreach( $payments as $payment ): ?>
                <tr>
					<td><?php echo $payment["id"]; ?></td>
					<td><?php echo MipHelper::parseDateFromDb( $payment["date"] ); ?></td>
					<td><?php echo $payment["payer"]; ?></td>
					<td><?php echo MipHelper::formatCurrency( $payment["amount"] );?></td>
					<td><?php echo MipHelper::formatCurrency( $payment["taken"] );?></td>
					<td class="btn-pay-detail"><?php echo CHtml::link( '<i class="icon-zoom-in btn-pay-detail"></i>&nbsp;'.MipHelperFront::t('Show'), $this->createUrl('//site/showPay', array('id'=>$payment["id"] )), array('class'=>'btn btn-success btn-pay-detail') ) ?></td>
				</tr>
                <?php endforeach; ?>
            </tbody>
		</table>
	</div>
</div>
<?php else: ?>
<div>
	<span><?php echo MipHelperFront::t("You haven't nothing payment register"); ?>.</span>
</div>
<?php endif; ?>

<script>
    var urlTemplate = "<?php echo $this->createUrl("//site/payments", array("location_id"=>"valueid")) ?>";
    jQuery(function(){
        
       jQuery("#location_id_selected").change(function(){
           var url = urlTemplate.replace("valueid", jQuery(this).val() );
           window.location.replace( url );
       });

    });
</script>