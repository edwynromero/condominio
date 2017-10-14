<?php

    /* @var $this SiteController */
    /* @var $payNotCash PayNotCashInfo */
    /* @var $form TbActiveForm */

    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'pay-form',
            'enableAjaxValidation'=>false,
    ));
    
    $drowpdown_parameters =  array("id"=>"location_id_selected");

    if( empty($location_id) )
    {
            if( count($locations) == 1 )
            {
                    foreach( $locations as $id => $location_code ){
                            $locations_id = $id;
                    }
            }
            if( count($locations) > 1 )
            {
                    $drowpdown_parameters["empty"] = "(". MipHelperFront::t("Select a location") .")" ;
            }
    }
    
?>
<div class="row-fluid">
    <div class="span12">
        <h3><?php echo MipHelperFront::t("Account Historical Title");  ?></h3>
        <hr>
        <br>
        <div class="well well-large">
            <div class="row-fluid">
                <div class="span5 text-left">
                    <span class="label-location-select-debt"><?php echo MipHelperFront::t("Location"); ?>:&nbsp;&nbsp;</span>
                    <?php echo TbHtml::dropDownList('location_id_selected', $location_id, $locations, $drowpdown_parameters); ?>
                </div>
                <div class="span3 text-left">
                    <span class="label-location-select-debt"><strong><?php echo MipHelperFront::t("Balance"); ?>:&nbsp;&nbsp;</strong></span> 
                    <span class="text-info"><strong><?php echo MipHelper::formatCurrency($current_balance) ?></strong></span>
                </div>
                <div class="span3 text-left">
                    <span class="label-location-select-debt"><strong><?php echo MipHelperFront::t("Debt"); ?>:&nbsp;&nbsp;</strong></span> 
                    <span class="text-error"><strong><?php echo MipHelper::formatCurrency($current_debt) ?></strong></span>
                </div>
            </div>
        </div>  
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped" >
            <thead>
                <tr>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("ID") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Date") ?></h4></td>
                    <td class="col_current_debt" style="text-align: right"><h4><?php echo MipHelperFront::t("Before") ?></h4></td>
                    <td class="col_current_debt" style="text-align: right"><h4><?php echo MipHelperFront::t("Amount") ?></h4></td>
                    <td class="col_current_debt" style="text-align: right"><h4><?php echo MipHelperFront::t("After") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Description") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Type") ?></h4></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $historical as $item ): ?>
                    <tr>
                        <td><?php echo $item["id"]; ?></td>
                        <td><?php echo $item["date"]; ?></td>
                        <td  style="text-align: right"><?php echo $item["before"];  ?></td>
                        <td  style="text-align: right"><?php echo $item["amount"];  ?></td>
                        <td  style="text-align: right"><?php echo $item["after"];  ?></td>
                        <td><?php echo $item["description"]; ?></td>
                        <td><?php echo $item["type"];  ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->endWidget(); ?>