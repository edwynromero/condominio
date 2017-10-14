<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in ArrayAccesshe editor.
 */

/* @var $fee Fee */

?>
<table class="pay-receipt-header-table">
    <tr>
        <td class="pay-receipt-column"><h5 class="pay-receipt-label-header"><?php echo MipHelperFront::t("Pay Date") ?> </h5><?php echo MipHelper::parseDateFromDb($pay->pay_date) ?></td>
        <td class="pay-receipt-column"><h5 class="pay-receipt-label-header"><?php echo MipHelperFront::t("Payer") ?> </h5><?php echo $person->getFullNameList() ?></td>
        <td class="pay-receipt-column"><h5 class="pay-receipt-label-header"><?php echo MipHelperFront::t("Total Amount") ?> </h5><?php echo MipHelper::formatCurrency(  $total_amount ); ?></td>
        <td class="pay-receipt-column"><h5 class="pay-receipt-label-header"><?php echo MipHelperFront::t("Status") ?> </h5><?php echo $deferred_amount == 0? '<span class="pay-receipt-label-validate">Validado</span>':'<span class="pay-receipt-label-not-validate">Por Validar</span>'; ?></td>
    </tr>
</table>
<table class="pay-receipt-summary-table">
    <tr>
        <td class="pay-receipt-column chash-value"><h5><?php echo MipHelperFront::t("Cash") ?>:&nbsp;&nbsp;</h5><?php echo MipHelper::formatCurrency( $total_amount - $not_cash_amount ); ?></td>
        <td class="pay-receipt-column not-chash-value"><h5><?php echo MipHelperFront::t("Checks, Receipts Bank, Transfers");?>:&nbsp;&nbsp;</h5><?php echo MipHelper::formatCurrency( $not_cash_amount ); ?></td>
        <td class="pay-receipt-column"><h5><?php echo MipHelperFront::t("Deferred") ?>:&nbsp;&nbsp;</h5><?php echo MipHelper::formatCurrency($deferred_amount ); ?></td>
    </tr>
</table>

<br>
<div class="pay-receipt-header-detail">
    <h5><?php echo MipHelper::t("Payment by Deposit or Transfer Detail"); ?></h5>
</div>
<?php if( count($pay_not_cash_list) > 0 ): ?>
    <table class="pay-receipt-detail-table" >
        <tr class="col-pay-detail-header">
            <td class="col-pay-detail-type-header"><h5><?php echo MipHelperFront::t("Type") ?></h5></td>
            <td class="col-pay-detail-date-header"><h5><?php echo MipHelperFront::t("Date") ?></h5></td>
            <td class="col-pay-detail-header"><h5><?php echo MipHelperFront::t("Bank") ?></h5></td>
            <td class="col-pay-detail-header"><h5><?php echo MipHelperFront::t("Reference") ?></h5></td>
            <td class="col-pay-detail-header"><h5><?php echo MipHelperFront::t("Amount") ?></h5></td>                    
            <td class="col-pay-detail-header"><h5><?php echo MipHelperFront::t("Destination account") ?></h5></td>
            <td class="col-pay-detail-header"><h5><?php echo MipHelperFront::t("Validated") ?></h5></td>
        </tr>
    </table>
<?php $class_td = "odd" ?>
<?php foreach( $pay_not_cash_list as $pay_not_cash ): ?>
    <?php $account = $account_list[$pay_not_cash->bank_account_id];?>
    <table class="pay-receipt-detail-table">
        <tr>
            <td class="col-pay-detail-type"><?php echo MipHelper::getNotCashTypeName($pay_not_cash->type); ?></td>
            <td class="col-pay-detail-date"><?php echo MipHelper::parseDateFromDb($pay_not_cash->pay_date); ?></td>
            <td class="col-pay-detail"><?php echo isset( $bank_list[$pay_not_cash->source_bank_id] )? $bank_list[$pay_not_cash->source_bank_id]: ""; ?></td>
            <td class="col-pay-detail"><?php echo str_pad($pay_not_cash->number, 10, '*', STR_PAD_LEFT);  ?></td>
            <td class="col-pay-detail"><?php echo MipHelper::formatCurrency( $pay_not_cash->value ); ?></td>                    
            <td class="col-pay-detail-account"><?php echo substr($account->number, -7) . " - " . $bank_list[$account->bank_id]; ?></td>
            <td class="col-pay-detail"><?php echo MipHelper::showYesNo($pay_not_cash->checked); ?></td>
        </tr>
    </table>
    <?php $class_td = ($class_td=="odd"?"even":"odd"); ?>
<?php endforeach; ?>
<?php else: ?>
<div class="pay-receipt-not-cash-empty">
    <h5><?php echo MipHelperFront::t("No registered vouchers, checks or transfers"); ?>.</h5>
</div>
<?php endif; ?>
<br>
<div class="pay-receipt-header-detail">
    <h5><?php echo MipHelper::t("Fees binding to Pay"); ?></h5>
</div>
<?php if( count($fees) > 0 ): ?>
    <table class="pay-receipt-detail-table" >
        <tr class="col-pay-detail-header">
            <td class="col-pay-fee-header align-center" ><h5><?php echo MipHelperFront::t("Fee Name") ?></h5></td>
            <td class="col-pay-fee-header align-center" ><h5><?php echo MipHelperFront::t("Value") ?></h5></td>
            <td class="col-pay-fee-header  align-center" ><h5><?php echo MipHelperFront::t("Begin Date") ?></h5></td>
            <td class="col-pay-fee-header  align-center" ><h5><?php echo MipHelperFront::t("End Date") ?></h5></td>                    
            <td class="col-pay-fee-header  align-center"><h5><?php echo MipHelperFront::t("Type") ?></h5></td>
        </tr>
    </table>
<?php $class_td = "odd" ?>
<?php $total_fees = 0 ?>
<?php foreach( $fees as $fee ): ?>
    <?php $total_fees += $fee->value; ?>
    <table class="pay-receipt-detail-table">
        <tr>
            <td class="col-pay-fee "><?php echo $fee->name; ?></td>
            <td class="col-pay-fee align-right"><?php echo MipHelper::formatCurrency($fee->value); ?></td>
            <td class="col-pay-fee  align-center"><?php echo MipHelper::parseDateFromDb($fee->begin_date); ?></td>
            <td class="col-pay-fee  align-center"><?php echo MipHelper::parseDateFromDb($fee->end_date); ?></td>                    
            <td class="col-pay-fee  align-center"><?php echo $this->getLabelIsFeeTypeNotRegular($fee->fee_type_id, $feetype_not_regular_list); ?></td>
        </tr>
    </table>
    <?php $class_td = ($class_td=="odd"?"even":"odd"); ?>
<?php endforeach; ?>
    <table class="pay-total-fee-payed-table">
        <tr>
            <td class="col-pay-fee col-total-fee-payed"><strong><?php echo MipHelper::t("Total Fees Payed") ?></strong></td>
            <td class="col-pay-fee align-right"><strong><?php echo MipHelper::formatCurrency($total_fees); ?></strong></td>
            <td class="col-pay-fee align-center">&nbsp;</td>
            <td class="col-pay-fee align-center">&nbsp;</td>
            <td class="col-pay-fee align-center">&nbsp;</td>
        </tr>
    </table>
<?php else: ?>
<div class="pay-receipt-not-cash-empty">
    <h5><?php echo MipHelper::t("No registered feeds to pay"); ?>.</h5>
</div>
<?php endif; ?>
<br>
<div class="pay-receipt-header-detail">
    <h5><?php echo MipHelper::t("Balance from Operation"); ?></h5>
</div>
<?php $total_pay_validated = $total_amount - $deferred_amount ?>
<?php $amount_to_favor_before_pay = MipHelper::getCreditBalanceBeforePay($pay) ?>
<table class="pay-total-fee-payed-table" cellspacing="0">
    <tbody>
    <tr>
        <td class="col-pay-balance-header align-center"><h5><?php echo MipHelper::t("Payment balance before") ?></h5></td>
        <td class="col-pay-balance-header align-center"><h5></h5></td>
        <td class="col-pay-balance-header align-center"><h5><?php echo MipHelper::t("Total Payment - Validated") ?></h5></td>
        <td class="col-pay-balance-header align-center"><h5></h5></td>
        <td class="col-pay-balance-header align-center"><h5><?php echo MipHelper::t("Total Fees Paid") ?></h5></td>
        <td class="col-pay-balance-header align-center"><h5></h5></td>
        <td class="col-pay-balance-header align-center"><h5><?php echo MipHelper::t("Balance in Favor to Date") ?></h5></td>                    
    </tr>
    <tr>
        <td class="col-pay-balance align-center"><?php echo MipHelper::formatCurrency($amount_to_favor_before_pay); ?></td>
        <td class="col-pay-balance-header align-center"><h5> + </h5></td>
        <td class="col-pay-balance align-center"><?php echo MipHelper::formatCurrency( $total_pay_validated ); ?></td>
        <td class="col-pay-balance-header align-center"><h5> - </h5></td>
        <td class="col-pay-balance align-center"><?php echo MipHelper::formatCurrency($total_fees); ?></td>
        <td class="col-pay-balance-header align-center"><h5> = </h5></td>
        <td class="col-pay-balance align-center"><?php echo MipHelper::formatCurrency( $amount_to_favor_before_pay + $total_pay_validated - $total_fees ); ?></td>
    </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>

            </td>
        </tr>
    </tfoot>
</table>
<br>
<table class="pay-receipt-legend" cellspacing="0">
    <tr>
        <td class="col-pay-legend"  bgcolor="white" colspan="2" align="center">
            <br>
            <h4><?php echo strtoupper(MipHelper::t("Legend")); ?></h4>
            <br>
            <br>
        </td>
    </tr>
    <tr>
        <td class="col-pay-legend" bgcolor="white">
            <ins><?php echo MipHelper::t("Payment balance before")?></ins>:
        </td>
        <td class="col-pay-legend" bgcolor="white"> 
            Presenta el Balance o Saldo existente antes del actual pago.
        </td>
    </tr>
    <tr>
        <td class="col-pay-legend" bgcolor="white">
            <ins><?php echo MipHelper::t("Total Payment - Validated") ?></ins>:
        </td>
        <td class="col-pay-legend" bgcolor="white"> 
            Suma de cada uno de los Montos que hayan sido validados (el efectivo es validado automáticamente).
        </td>
    </tr>
    <tr>
        <td class="col-pay-legend" bgcolor="white">
            <ins><?php echo MipHelper::t("Total Fees Paid") ?></ins>:
        </td>
        <td class="col-pay-legend" bgcolor="white"> 
            Suma todas las cuotas asociados al presente pago (estas deben poder ser canceladas con el Balance a la fecha del mismo).
        </td>
    </tr>
    <tr>
        <td class="col-pay-legend" bgcolor="white">
            <ins><?php echo MipHelper::t("Balance in Favor to Date") ?></ins>:
        </td>
        <td class="col-pay-legend" bgcolor="white"> 
            El Balance a la Fecha, más el monto del Pago Actual, restando las Cuotas asociadas, determinan el Balance luego del Pago Actual.
        </td>
    </tr>
    <tr>
        <td colspan="2">
            &nbsp;
        </td>
    </tr>
</table>