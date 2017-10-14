<?php 
	/* @var $location Location */
	/* @var $owners array */
	/* @var $owner Owner */
	/* @var $feed_not_payed ViewLocationFeePay */
	/* @var $total_feeds_not_payed integer  Cantidad Total de Cuotas No Canceladas */
	/* @var $person Person */


	
	
?>
<style>

	.label-report
	{
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
		color: red;
	}
	
	.deb-current-solvent
	{
		color: green;
	}
	
	.deb-current-info
	{
		color: blue;
	}	
	
	.label-feed-pending
	{
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
	}
	
	.advertence
	{
		color: red;
		font-size: 10px;
	}
	
	.legend_cuota_pending
	{
		text-align: center;
		color: #333;
		font-size: 10px;
	}
	
	.last-pay
	{
		color: green;
	}
	
	
	table
	{
		font-size:8px;
	}

	table.table-feed-pending 
	{
		font-size:8px;
	}
	
</style>
<table cellspacing="0" cellpadding="0">
	<tr class="head-row">
		<td colspan="6"></td>
	</tr>
	<tr class="location-row">
		<td align="left" colspan="2">  <span class="label-report">CI/RIF:  </span><?php echo $person->getFullIdentity(); ?></td>	
		<td><span class="label-report">Pagador:</span></td>
		<td colspan="3"><?php echo $person->getFullNameList(); ?></td>
	</tr>
	<tr>
		<td colspan="6"><div class="separator-report"></div></td>
	</tr>	
	<tr>
		<td colspan="2">		
			<span class="label-report"><?php echo MipHelper::t("Status")?>:</span>
			<?php if( $payChecked ):?>
			<span class="deb-current-solvent">Verificado</span>
			<?php else:?>
			<span class="deb-current">Por Validar</span>
			<?php endif;?>			
		</td>
		<td colspan="2">
			<span class="label-report">   <?php echo MipHelper::t("Total Pay")?>:</span>
			<span><?php echo MipHelper::formatCurrency( $NotCashAmount + $pay->value_cash)?></span>
		</td>
		<td colspan="2">
			<span class="label-report">   <?php echo MipHelper::t("Pay Date")?>:</span>
			<span><?php echo MipHelper::parseDateFromDb( $pay->pay_date ) ?></span>		
		</td>
	</tr>
	<tr>
		<td colspan="6"><div class="separator-report"></div></td>
	</tr>
	<tr>
		<td colspan="2">		
			<span class="label-report"><?php echo MipHelper::t("Cash")?>:</span>
			<span class="deb-current-info"><?php echo MipHelper::formatCurrency(  $pay->value_cash );?></span>		
		</td>
		<td colspan="4">
			<span class="label-report">   <?php echo MipHelper::t("Checks, Transfers and Vouchers")?>:</span>
			<span class="deb-current-info"><?php echo MipHelper::formatCurrency( $NotCashAmount ) ?></span>		
		</td>
	</tr>	
	<tr>
		<td colspan="6"><div class="separator-report"></div></td>
	</tr>	
	<tr >
		<td colspan="6">
			<span class="label-report"><?php echo MipHelper::t("Fees Paid")?>:</span>
			<br>
		</td>
	</tr>	
	<tr >	
		<td colspan="1">
		</td>	
		<td colspan="5">
			<br>
			<table class="table-feed-pending">	
				<tr>
					<td class="label-feed-pending">Parcela</td>
					<td class="label-feed-pending feed-name">Cuota</td>
					<td class="label-feed-pending">Monto</td>
					<td  class="label-feed-pending">Fecha</td>
				</tr>			
				<?php foreach( $locationFeePays as $locationFeePay):?>
				<tr>
					<td class="body-table-feed-pending"><span class="deb-current-info"> <?php echo $locationFeePay->code ?> </span></td>
					<td class="body-table-feed-pending feed-name"> <?php echo $locationFeePay->name ?> </td>
					<td class="body-table-feed-pending"><span class="deb-current-solvent"> <?php echo MipHelper::formatCurrency( $locationFeePay->value ) ?> </span></td>
					<td class="body-table-feed-pending"><span class="deb-current-solvent"> <?php echo MipHelper::parseDateFromDb( $locationFeePay->begin_date ) ?> </span></td>
				</tr>		
				<?php endforeach;?>
			</table>
			
		</td>	
	</tr>	
</table>
