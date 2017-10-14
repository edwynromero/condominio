<?php

/* @var $this SiteController */
/* @var $form TbActiveForm */
/* @var $pay Pay */
/* @var $person Person */
/* @var $pay_not_cash PayNotCashInfo */

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 
 $total_fees = 0;
?>
<h3 class="text-success"><?php echo MipHelperFront::t("Payment Information") ?> #<?php echo $pay->id ?></h3>
<div class="row-fluid">
    <div class="span12 text-right">
        <a class="btn btn-success" href="<?php echo $this->createUrl("//site/downloadPayReceipt", array("id"=>$pay->id)) ?>" target="blank"><i class="icon-download-alt"></i>&nbsp;&nbsp;Descargar Recibo</a>
    </div>
</div>
<br>
<div class="row-fluid">
    <div class="span3"><h4 class="text-success"><?php echo MipHelperFront::t("Date") ?> </h4><?php echo MipHelper::parseDateFromDb($pay->pay_date) ?></div>
    <div class="span3"><h4 class="text-success"><?php echo MipHelperFront::t("Payer") ?> </h4><?php echo $person->getFullNameList() ?></div>
    <div class="span3"><h4 class="text-success"><?php echo MipHelperFront::t("Total Amount") ?> </h4><?php echo MipHelper::formatCurrency(  $total_amount ); ?></div>
    <div class="span3"><h4 class="text-success"><?php echo MipHelperFront::t("Status") ?> </h4><?php echo $deferred_amount == 0? 'Validado':'Por Validar'; ?></div>
</div>
<br>
<div class="row-fluid">
    <div class="span7">
        <div class="well well-small">
            <div class="row-fluid">
                <div class="span4">
                    <strong><?php echo MipHelperFront::t("Cash") ?>:&nbsp;&nbsp;</strong><?php echo MipHelper::formatCurrency( $total_amount - $not_cash_amount ); ?>
                </div>
                <div class="span8">
                    <strong><?php echo MipHelperFront::t("Checks, Receipts Bank, Transfers");?>:&nbsp;&nbsp;</strong><?php echo MipHelper::formatCurrency( $not_cash_amount ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="well well-small">
            <div class="row-fluid">
                <div class="span9">                
                    <strong><?php echo MipHelperFront::t("Deferred") ?>:&nbsp;&nbsp;</strong><?php echo MipHelper::formatCurrency($deferred_amount ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<?php if( count($pay_not_cash_list) > 0 ): ?>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped" >
            <thead>
                <tr>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Type") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Bank") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Date") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Reference") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Amount") ?></h4></td>                    
                    <td class="col_current_debt" colspan="2"><h4><?php echo MipHelperFront::t("Destination account") ?></h4></td>
                     <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Validated") ?></h4></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $pay_not_cash_list as $pay_not_cash ): ?>
                <?php $account = $account_list[$pay_not_cash->bank_account_id];?>
                <tr>
                    <td><?php echo MipHelper::getNotCashTypeName($pay_not_cash->type); ?></td>
                    <td><?php echo isset( $bank_list[$pay_not_cash->source_bank_id] )? $bank_list[$pay_not_cash->source_bank_id]: ""; ?></td>
                    <td><?php echo MipHelper::parseDateFromDb( $pay_not_cash->pay_date ); ?></td>
                    <td><?php echo str_pad($pay_not_cash->number, 16, '0', STR_PAD_LEFT);  ?></td>
                    <td><?php echo MipHelper::formatCurrency( $pay_not_cash->value ); ?></td>                    
                    <td><?php echo $account->number; ?></td>
                    <td><?php echo $bank_list[$account->bank_id]; ?></td>
                    <td><?php echo MipHelper::showYesNo($pay_not_cash->checked); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
<!--  Aqui comienza la Info -->
<br>
<div class="well">
    <div class="row-fluid">
        <div class="span12">
            <center><h4 class="text-success"><?php echo MipHelper::t("Fees binding to Pay"); ?></h4></center>
        </div>
    </div>
<?php if( count($fees) > 0 ): ?>
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-striped" >
                <thead>
                    <tr>
                        <td class="col_current_debt" ><strong><?php echo MipHelperFront::t("Fee Name") ?></strong></td>
                        <td class="col_current_debt" ><strong><?php echo MipHelperFront::t("Location") ?></strong></td>
                        <td class="col_current_debt" ><strong><?php echo MipHelperFront::t("Value") ?></strong></td>
                        <td class="col_current_debt" ><strong><?php echo MipHelperFront::t("Begin Date") ?></strong></td>
                        <td class="col_current_debt" ><strong><?php echo MipHelperFront::t("End Date") ?></strong></td>                    
                        <td class="col_current_debt"><strong><?php echo MipHelperFront::t("Type") ?></strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $fees as $fee ): ?>
                        <?php $total_fees += $fee["value"]; ?>
                            <tr>
                                <td class=""><?php echo $fee["name"]; ?></td>
                                <td class=""><?php echo $fee["code"]; ?></td>
                                <td class=""><?php echo MipHelper::formatCurrency($fee["value"]); ?></td>
                                <td class=""><?php echo MipHelper::parseDateFromDb($fee["begin_date"]); ?></td>
                                <td class=""><?php echo MipHelper::parseDateFromDb($fee["end_date"]); ?></td>                    
                                <td class=""><?php echo $this->getLabelIsFeeTypeNotRegular($fee["fee_type_id"], $feetype_not_regular_list); ?></td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                    	<td></td>	
                        <td ><strong><?php echo MipHelper::t("Total Fees Payed") ?></strong></td>
                        <td colspan="4"><strong><?php echo MipHelper::formatCurrency($total_fees); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="row-fluid">
        <div class="span12 text-warning">
            <center><h5><?php echo MipHelper::t("No registered feeds to pay"); ?></h5></center>
        </div>
    </div>
    <br>
<?php endif; ?>
<div class="row-fluid">
    <div class="span12">
        <center><h4 class="text-success"><?php echo MipHelper::t("Balance from Operation"); ?></h4></center>
        <?php $total_pay_validated = $total_amount - $deferred_amount ?>
        <?php $amount_to_favor_before_pay = MipHelper::getCreditBalanceBeforePay($pay) ?>
        <?php $amount_to_favor_before_pay = $amount_to_favor_before_pay > 0 ? $amount_to_favor_before_pay : 0; ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td class="text-success Bold"><strong><?php echo MipHelper::t("Payment balance before") ?></strong></td>
                    <td class="text-success"></td>
                    <td class="text-success"><strong><?php echo MipHelper::t("Total Payment - Validated") ?></strong></td>
                    <td class="text-success"></td>
                    <td class="text-success"><strong><?php echo MipHelper::t("Total Fees Paid") ?></strong></td>
                    <td class="text-success"></td>
                    <td class="text-success"><strong><?php echo MipHelper::t("Balance in Favor to Date") ?></strong></td>                    
                </tr>   
            </thead>
            <tbody>
                <tr>
                    <td class="col-pay-balance align-center "><strong> <?php echo MipHelper::formatCurrency($amount_to_favor_before_pay); ?></strong></td>
                    <td class="col-pay-balance-header align-center"><strong> + </strong></td>
                    <td class="col-pay-balance align-center"><strong> <?php echo MipHelper::formatCurrency( $total_pay_validated ); ?></strong></td>
                    <td class="col-pay-balance-header align-center"><strong> - </strong></td>
                    <td class="col-pay-balance align-center"><strong> <?php echo MipHelper::formatCurrency($total_fees); ?></strong></td>
                    <td class="col-pay-balance-header align-center"><strong> = </strong></td>
                    <td class="col-pay-balance align-center"><strong> <?php echo MipHelper::formatCurrency( $amount_to_favor_before_pay + $total_pay_validated - $total_fees ); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
