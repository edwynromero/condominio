<?php

/* @var $this Controller */

/* @var $model Location  */
$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->id,
);

$this->menu = CMap::mergeArray(MipHelper::getMenuToView($model), 
					array(
							array('label'=>MipHelper::t("Show Current Debt"),
								   'url'=>array('showReportCurrentDebt', 'location_id'=>$model->id), 
								   'linkOptions' => array('target'=>'_blank')
							),
					)	
				);
?>

<div class="row-fluid">
	<div class="span6 text-right"><h3><?php echo MipHelper::t("Sending Debt to Owners from")?>:</h3></div>
	<div class="span6 text-left"><h2 style="color:green;"><?php echo $model->code ; ?></h2></div>
</div> 
<div class="row-fluid">
	<div class="span10">

		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Estatus</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
                           
	<?php 
		foreach( $person_email_list as $person_email_item ){
			/* @var $person Person */
			/* @var $person_email PersonEmail */
			$person = $person_email_item['person'];
                        $person_email = $person_email_item['email'];
                        if( !empty($person_email)){
	?>
				<tr>
					<td><?php echo CHtml::checkBox('person_email',true, array('value'=>$person_email, 'id'=>'pe-'.$person_email->id ))?></td>
					<td><?php echo $person->first_name; ?></td>
					<td><?php echo $person->last_name; ?></td>
					<td><?php echo empty($person_email->email)?"(No tiene email)":$person_email->email ?></td>
					<td>							 			
						<div class="progress progress-striped progress-success">
						  	<div class="bar step1" style="width:0%;"></div>
						</div>
						<input type="hidden" class="person_email_id" data-checkbox="<?php echo 'pe-'.$person_email->id ?>" data-url="<?php echo $this->createAbsoluteUrl('//backend/location/sendDebtReportToEmail', array('location_id'=>$location_id, 'person_mail_id' =>  $person_email->id)) ?>" value ="0" style="width:20%">						
					</td>
				</tr>
                                 
	<?php
                        }
                   } 
                
	?>
			</tbody>
		</table>
	
	</div>
	<div class="span2"></div>	
</div>
<div class="row-fluid">
	<div class="span12">
		<?php  echo TbHtml::linkButton( MipHelper::t('Send'), array('class'=>'btn-primary', 'onClick'=>'processEmailDebt(); return false;','name'=>'send') ) ?>
		<?php  echo TbHtml::linkButton( MipHelper::t('Reset'), array('class'=>'btn-default') ) ?>
	</div>
</div>
<script type="text/javascript">

	function processEmailDebt()
	{
		jQuery(".person_email_id").each(function( i, e ){		
			
			var el = jQuery(e);
			
			if( jQuery("#"+el.data('checkbox')).attr('checked')=='checked'){
	

				var prog = el.prev();
                                
                                prog.removeClass('progress');
                                prog.removeClass('progress-striped');
                                prog.removeClass('progress-success');
                                prog.removeClass('progress-danger');
                                
                                prog.addClass('progress');
                                prog.addClass('progress-striped');

				prog.find('.step1').css('width', '30%'); 
							
				var jqxhr = $.post(  el.data('url') )
				  .done(function(response) {		
	
					  var data = $.parseJSON(response);
					  			  
					  if( !data.process )
					  {
						  prog.removeClass('progress-success');
						  prog.addClass('progress-danger');
					  }	
					 
				  })
				  .fail(function() {
					  prog.removeClass('progress-success');
					  prog.addClass('progress-danger');
                                          prog.find('.step1').addClass('faild');
				  })
				  .always(function() {
					  prog.find('.step1').css('width', '100%'); 
                                          prog.find('.step1').addClass('success');
                                       
				});
			}
		});

	}

</script>
