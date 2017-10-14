<?php 
	/* @var $location Location */
	/* @var $owners array */
	/* @var $owner Owner */
	/* @var $feed_not_payed ViewLocationFeePay */
	/* @var $total_feeds_not_payed integer  Cantidad Total de Cuotas No Canceladas */
	/* @var $last_pay Pay */


	$max_feeds_unpaied = Yii::app()->params["report_max_feeds_unpaied"];
	
	if( is_null($last_pay) )
	{
		$last_pay_value = 0;
		$last_pay_date = null;
	}
	else
	{
		$last_pay_value = $last_pay->value_cash + $value_pay_not_cash;
		$last_pay_date 	=  $last_pay->pay_date;
	}
	
	
?>
<style>

	.label-report
	{
		font-size: 8px;
		font-weight: bold;	
	}
	
	.separator-report
	{
		border-bottom-color: #EEE;
		border-bottom-width: 1px;
		
	}
	
	.location-row
	{
		
	}
	
	.head-row
	{
		
	}
	
	.deb-current
	{
		font-size: 8px;
		color: red;
	}
	
	.deb-current-solvent
	{
		font-size: 8px;
		color: green;
	}	
	
	.label-feed-pending
	{
		font-size: 8px;
		font-weight: bold;
		background-color: #EEE;
		line-height: 2px;
	}
	
	.feed-name
	{
		width: 160px;
	}
	
	.table-feed-pending
	{
		width: 300px;
	}
	
	.separator-feed-pending
	{
		background-color: #EEE;
		height: 2px;
	}
	
	.body-table-feed-pending
	{
		line-height: 3px;
		border-bottom-color: #EEE;
		border-bottom-width: 1px;
		font-size: 8px;
	}
	
	.advertence
	{
		color: red;
		font-size: 8px;
	}
	
	.legend_cuota_pending
	{
		text-align: center;
		color: #333;
		font-size: 8px;
	}
	
	.last-pay
	{
		color: blue;
	}
	
	.value {
		font-size: 8px;
	}
	
	.last-pay-unchecked
	{
		color: orange;
	}
	
	.last-pay-unchecked-legend
	{
		font-size: 8px;
		color: orange;
	}

	
</style>
<table cellspacing="0" cellpadding="0">
	<tr class="head-row">
		<td colspan="6"></td>
	</tr>
	<tr class="location-row">
		<td><span class="label-report"><?php echo MipHelper::t("Location")?>:</span></td>
		<td class="value"><?php echo $location->code; ?></td>
		<td><span class="label-report">Estatus:</span></td>
		<td class="value"><?php echo MipHelper::getLocationStatusName( $location->status );?></td>
		<td><span class="label-report">¿Construida?</span></td>
		<td class="value"><?php echo MipHelper::showYesNo($location->is_built)?></td>
	</tr>
	<tr>
		<td colspan="6"  style="height:10px;"><div class="separator-report"></div></td>
	</tr>	
	<tr >
		<td><span class="label-report"><?php echo MipHelper::t("Owner(s)")?>:</span></td>
		<td colspan="5" class="value">
			<?php if( count( $owners ) > 0 ):?>
				<?php foreach( $owners as $owner):?>
				<?php echo MipHelper::getPersonName($owner->person_id); ?>;
				<?php endforeach;?>
			<?php else:?>
				<?php echo MipHelper::t("No defined owners for this location");?>
			<?php endif;?>
		</td>	
	</tr>
	<tr>
		<td colspan="6" style="height:10px;"><div class="separator-report"></div></td>
	</tr>
	<tr>
		<td colspan="3" >
			<span class="label-report"><?php echo MipHelper::t("Current Debt")?>:</span>
			<?php if( $debt > 0 ):?>
			<span class="deb-current"><?php echo MipHelper::formatCurrency($debt);?></span>
			<?php else:?>
			<span class="deb-current-solvent">Bs. 0 <br>(Felicitaciones Vecino)</span>
			<?php endif;?>
		</td>
		<td colspan="3" >
			<?php  if($total_payed > 0):?>
			<span class="label-report"><?php echo MipHelper::t("Unused Balance")?>:</span>
			<span class="deb-current-solvent"><?php echo MipHelper::formatCurrency($total_payed)?></span>
			<?php  endif; ?>
		</td>
	</tr>
	<tr>
		<td colspan="6"><div class="separator-report"></div></td>
	</tr>
	<tr>
		<td colspan="3" >
			<span class="label-report"><?php echo MipHelper::t("Last Pay")?>:</span>
			<?php if( $last_pay_value > 0 ): ?>
				<span class="last-pay value"><?php echo MipHelper::formatCurrency($last_pay_value); ?> <span class="">&nbsp;&nbsp;(<?php echo MipHelper::parseDateFromDb($last_pay_date); ?>)</span></span>
			<?php else:?>
				<span class="deb-current  value"><?php  echo "No se ha registrado ningún pago."?></span>
			<?php endif;?>
		</td>
		<td colspan="3" >
			<?php if( $valuePayNotCashUnChecked > 0 ): ?>
				<span class="label-report"><?php echo MipHelper::t("Amount Unchecked")?>:</span>
				<span class="last-pay-unchecked value"><?php echo MipHelper::formatCurrency($valuePayNotCashUnChecked); ?> </span>
				<br><span class="last-pay-unchecked-legend">(<?php echo MipHelper::t("Transfers or deposits unverified"); ?>)</span>
			<?php endif;?>
		</td>
	</tr>
	<tr>
		<td colspan="6"><div class="separator-report"></div></td>
	</tr>
	<tr >
		<td colspan="2">
			<span class="label-report"><?php echo MipHelper::t("Unpaid Fees")?>:</span>
			<br>
		</td>
		<td colspan="4">
			<br>
			<table class="table-feed-pending">	
				<tr>
					<td class="label-feed-pending feed-name">Cuota</td>
					<td class="label-feed-pending">Monto</td>
					<td  class="label-feed-pending">Fecha</td>
				</tr>			
				<?php foreach( $feeds_not_payed as $feed_not_payed ):?>				
				<tr>
					<td class="body-table-feed-pending feed-name"><?php echo $feed_not_payed->name; ?> </td>
					<td class="body-table-feed-pending"><span class="deb-current"><?php echo MipHelper::formatCurrency($feed_not_payed->value); ?></span></td>
					<td class="body-table-feed-pending"><?php echo $feed_not_payed->begin_date;?></td>
				</tr>
				<?php endforeach;?>
			</table>
			
		</td>	
	</tr>	
</table>
