<div class="row-fluid ">
	<div class="span12">
		<div class="well well-small">
			<div class="row-fluid ">
				<div class="span6">
					<h5 class="text-success"><?php echo MipHelper::t("Debt after Pay") ?>: <span class="badge badge-success"  style="text-align: right; width:120px;padding:10px;font-size:14px;"><?php echo MipHelper::formatCurrency($debtAfterPay); ?></span></h5>
				</div>
				<div class="span6">
					<h5 class="text-success"><?php echo MipHelper::t("Balance after Pay") ?>: <span class="<?php echo $balanceAfterPay >= 0?'badge badge-success':'badge badge-warning'?>" style="<?php echo $balanceAfterPay>=0?'':'background-color: #b94a48;'?>;text-align: right; width:120px;padding:10px;font-size:14px;"><?php echo MipHelper::formatCurrency($balanceAfterPay); ?></span></h5>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">{pager}</div>
	<div class="span6">{summary}</div>
</div>
{items}
<div class="row-fluid">
	<div class="span6">{pager}</div>
	<div class="span6">{summary}</div>
</div>