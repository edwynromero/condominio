<?php	
	$debt_class = ($current_debt == 0)? "text-success": "text-error";
	$percentual_feeds_payed = round ( (($total_feeds -$outstanding_contributions)/$total_feeds) * 100, 2);
	$percentual_feeds_not_payed = round( ($outstanding_contributions/$total_feeds) * 100, 2);
?>
<h3><?php echo MipHelperFront::t("My panel");  ?></h3>
<hr>
<div class="row-fluid">
	<div class="span3">
		<div class="well">
			<div class="row-fluid">
				<div class="span12" >
					<h4>Deuda</h4>
				</div>
			</div>
			<div class="row-fluid"s>
				<div class="span12 text-center">
					<h3 class="<?php  echo $debt_class ?>" ><?php echo MipHelper::formatCurrency($current_debt) ?></h3>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12 text-right">
					<a href="<?php echo $this->createUrl("//site/currentDebt") ?>" class="<?php  echo $debt_class ?>">Ver más</a>
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
		<div class="well">
			<div class="row-fluid">
				<div class="span12">
					<h4>Saldo a Favor</h4>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12 text-center">
					<h3 class="text-success" ><?php echo MipHelper::formatCurrency($current_balance) ?></h3>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12 text-right">
					<a href="<?php echo $this->createUrl("//site/payments") ?>">Ver más</a>
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
		<div class="well">
			<div class="row-fluid">
				<div class="span12">
					<h4>Cuotas Pendientes</h4>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12 text-center" >
					<h2 class="<?php  echo $debt_class ?>" ><?php echo $outstanding_contributions ?></h2>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12 text-right">
					<a href="<?php echo $this->createUrl("//site/currentDebt") ?>" class="<?php  echo $debt_class ?>">Ver más</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="last-payment" class="row-fluid">
	<div class="span9">
		<div class="well">
			<div class="row-fluid ">
				<span class="span12 last-payment-label">
					<h4>Último Pago</h4>
				</span>
			</div>
			<div class="row-fluid last-payment-data text-success">
				<div class="span4">
					<strong>Fecha:</strong>
					<?php echo $last_pay["date"]; ?>
				</div>
				<div class="span4">
					<strong>Monto:</strong>
					<?php echo $last_pay["amount"]; ?>
				</div>
				<div class="span4">
					<strong>Acreditado:</strong>
					<?php echo $last_pay["credited"]; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="feed-chart" class="row-fluid hidden-phone hidden-tablet">
	<div class="span9">
		<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'<h4>Relación de Cuotas Pendientes</h4>',
			'titleCssClass'=>''
		));
		?>
        
        <div class="pieFeeds" style="height: 230px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
        
        <?php $this->endWidget(); ?>
	</div>
</div>
<script>

	$(document).ready(function() {

		/**
		*  Esta seccion verifica si existen los elementos HTML para la presentacion de los PIE
		*  la data ha sido definida desde el backend previamente.
		**/
		var divElement = $('div'); 
		
		if (divElement.hasClass('pieFeeds')) {
			$(function () {
			   var data = [
				    { label: "%<?php echo $percentual_feeds_payed ?> Pagadas",  data: <?php echo $percentual_feeds_payed?>, color: "#468847"},
				    { label: "%<?php echo $percentual_feeds_not_payed ?> Pendientes",  data: <?php echo $percentual_feeds_not_payed?>, color: "#b94a48"}
				];
				
				$.plot($(".pieFeeds"), data, 
				{
					series: {
						pie: { 
							show: true,
							highlight: {
								opacity: 0.1
							},
							stroke: {
								color: '#fff',
								width: 3
							},
							startAngle: 2,
							label: {
								radius:1
							}
						},
						grow: {	active: false}
					},
					legend: { 
			        	position: "ne", 
			        	labelBoxBorderColor: null
			    	},
					grid: {
			            hoverable: true,
			            clickable: true
			        },
			        tooltip: true,
					tooltipOpts: {
						content: "%s : %y.1",
						shifts: {
							x: -30,
							y: -50
						}
					}
				});
			});
		}
	});
	//end if
</script>