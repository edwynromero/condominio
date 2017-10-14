<?php

/* @var $this SiteController */
/* @var $form TbActiveForm */
/* @var $fee Fee */

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 
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
<h3><?php echo MipHelperFront::t("My current debt");  ?></h3>
<hr>
<br>
<div class="row-fluid">
	<span class="payments-summary">El monto representa el TOTAL de las Cuotas que faltan por cancelar.  Igual se presenta un listado con las cuotas pendientes.  Puede usar el botón "Estado de Cuenta" para descargar un PDF con el Estado de Cuenta de su parcela. 
	Si tiene más de una parcela, deberá elegir la correspondiente en el combo desplegable.</span>
</div>
<br>
<div class="well well-large">
    <div class="row-fluid">
        <div class="span8 text-left">
            <span class="label-location-select-debt"><?php echo MipHelperFront::t("Locations available"); ?>:&nbsp;&nbsp;</span>
            <?php echo TbHtml::dropDownList('location_id_selected', $location_id, $locations, $drowpdown_parameters); ?>
        </div>
        <div class="span4 text-right">
            <?php if( $location_id > 0  ): ?>
            <a class="btn btn-success" href="<?php echo $this->createUrl("//site/downloadAccountState", array("location_id"=>$location_id)) ?>" target="blank"><i class="icon-download-alt"></i>&nbsp;&nbsp;Estado Cuenta</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if( count($fee_list) > 0 ): ?>
<div class="row-fluid row-debt btn-danger">
    <div class="span6 text-right">
        <h4>Monto Total Deuda:</h4>
    </div>
    <div class="span6 text-left">
        <h4><?php echo MipHelper::formatCurrency( $amount ); ?></h4>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped" >
            <thead>
                <tr>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Fee Name") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Amount") ?></h4></td>
                    <td class="col_current_debt"><h4><?php echo MipHelperFront::t("Fee Type") ?></h4></td>
                    <td class="col_current_debt text-center" align="center"><h4><?php echo MipHelperFront::t("Period") ?></h4></td>             
                </tr>
            </thead>
            <tbody>
                <?php foreach( $fee_list as $fee ): ?>
                <tr>
                    <td><?php echo $fee->name ?></td>
                    <td><?php echo MipHelper::formatCurrency( $fee->value ) ?></td>
                    <td><?php echo  $this->getLabelIsFeeTypeNotRegular($fee->fee_type_id, $feetype_not_regular_list) ?></td>
                    <td><?php echo MipHelper::parseDateFromDb($fee->begin_date) . " " ?>-<?php echo " " . MipHelper::parseDateFromDb($fee->end_date) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
    <?php if($location_id > 0 ):?>
    <div class="row-fluid">
        <div class="span10 text-center text-success"><h5><?php echo MipHelperFront::t("Congratulations, you haven't some debt"); ?>.</h5></div>
    </div>
    <?php else: ?>
    <div class="row-fluid">
        <div class="span12 text-center text-success"><h5><?php echo MipHelperFront::t("You must select a location"); ?>.</h5></div>
    </div>
    <?php endif; ?>
<?php endif; ?>
<script>
    var urlTemplate = "<?php echo $this->createUrl("//site/currentDebt", array("location_id"=>"valueid")) ?>";
    jQuery(function(){
        
       jQuery("#location_id_selected").change(function(){
           var url = urlTemplate.replace("valueid", jQuery(this).val() );
           window.location.replace( url );
       });

    });
</script>