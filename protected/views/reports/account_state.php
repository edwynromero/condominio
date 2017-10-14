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
<table cellspacing="0" cellpadding="0" width="100%" class="header-table"> 
        <tr>
            <td colspan="6">
                &nbsp;
            </td>
        </tr>
        <tr class="location-row">
            <td class="cell-location-code">
                <span class="label-report">&nbsp;&nbsp;<?php echo MipHelper::t("Location");?>:</span>
                <?php echo $location->code; ?>
            </td>
            <td class="cell-location-status"  colspan="3">
                <span class="label-report">Estatus:</span>
                <?php echo MipHelper::getLocationStatusName( $location->status );?>
            </td>
            <td class="cell-location-build" colspan="1">
                <span class="label-report">¿Construida?</span>
                <?php echo MipHelper::showYesNo($location->is_built)?>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                &nbsp;
            </td>
        </tr>	
        <tr >
            <td colspan="6" class="cell-location-owners" >
                <span class="label-report">&nbsp;&nbsp;<?php echo MipHelper::t("Owner(s)")?>:</span>
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
            <td colspan="6">
                &nbsp;
            </td>
        </tr>	
        <tr>
            <td colspan="3" >
                    <span class="label-report">&nbsp;&nbsp;<?php echo MipHelper::t("Current Debt")?>:</span>
                    <?php if( $debt > 0 ):?>
                    <span class="deb-current"><?php echo MipHelper::formatCurrency($debt);?></span>
                    <?php else:?>
                    <span class="deb-current-solvent">Bs. 0</span>
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
            <td colspan="6">
                &nbsp;
            </td>
        </tr>	
        <tr>
            <td colspan="3" >
                    <span class="label-report">&nbsp;&nbsp;<?php echo MipHelper::t("Last Pay")?>:</span>
                    <?php if( $last_pay_value > 0 ): ?>
                            <span class="last-pay value"><?php echo MipHelper::formatCurrency($last_pay_value); ?> <span class="">&nbsp;&nbsp;(<?php echo MipHelper::parseDateFromDb($last_pay_date); ?>)</span></span>
                    <?php else:?>
                            <span class="deb-current  value"><?php  echo "No se ha registrado ningún pago"?>.</span>
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
            <td colspan="6">
                &nbsp;
            </td>
        </tr>		
</table>

<br>
<?php if( $debt > 0 ):?>
    <div class="title-unpaid-fees">
    <?php echo MipHelper::t("Unpaid Fees")?>
    <br>
    </div>
    <div>
        <table  align="center">
            <tr>
                <td class="label-feed-pending feed-name">Cuota</td>
                <td class="label-feed-pending feed-value">Monto</td>
                <td class="label-feed-pending feed-date">Fecha</td>
            </tr>
        </table>
    </div>
    <?php $class_td = "odd" ?>
    <?php foreach( $feeds_not_payed as $feed_not_payed ):?>	
    <div>
        <table class="table-feed-pending  <?php echo $class_td ?>" align="center">
            <tr>
                <td class="body-table-feed-pending feed-name"><?php echo $feed_not_payed->name; ?> </td>
                <td class="body-table-feed-pending feed-value"><span class="deb-current"><?php echo MipHelper::formatCurrency($feed_not_payed->value); ?></span></td>
                <td class="body-table-feed-pending feed-date"><?php echo $feed_not_payed->begin_date;?></td>
            </tr>
        </table>
    </div>
    <?php $class_td = ($class_td=="odd"?"even":"odd"); ?>
    <?php endforeach;?>
    <div>
        <table class="table-feed-pending  <?php echo $class_td ?>" align="center">
            <tr>
                <td class="body-table-feed-pending feed-name"></td>
                <td class="body-table-feed-pending feed-value"></span></td>
                <td class="body-table-feed-pending feed-date"></td>
            </tr>
        </table>
    </div>

<?php else:?>
    <div class="solvency-contribution-declaration">
        <?php echo MipHelper::t("You are far solvent") ?>
    </div>
    <br>
    <div class="solvency-contribution-declaration">
        !&nbsp;<?php echo MipHelper::t("Congratulations") ?>&nbsp;!
    </div>
<?php endif;