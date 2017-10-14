<?php
	/* @var $this Controller */ 

?>				
				<div id="section-tabnotcashinfo" class="row-fluid">				
					<div class="span10">
					<table class="table table-striped">
  						<thead>
  							<tr>
  								<th><a class="sort-link"><?php echo MipHelper::t("Checked"); ?></a></th>
  								<th ><a class="sort-link"><?php echo MipHelper::t("Type"); ?></a></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Bank Account"); ?></a></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Bank"); ?></a></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Number"); ?></a></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Amount"); ?></a></th>  								
  								<th><a class="sort-link"></th>
  							</tr>
  						</thead>
  						<tbody>
  							<?php $subtotal = 0;?>
  							<?php $deferred = 0; ?>						
  							<?php foreach($modelPayNotCash as $data):?>
  							<?php /* @var $data PayNotCashInfo */ ?>
  							<tr>
  							  	<td><?php echo MipHelper::showCheckedIcon($data->checked)?></td>
  								<td><?php echo MipHelper::getNotCashTypeName($data->type)?></td>
  								<td><?php echo $data->targetAccount->shortReference?></td>
  								<td><?php echo MipHelper::getBankName($data->source_bank_id)?></td>
  								<td><?php echo $data->number?></td>
  								<td class="text-right" style="text-align: right;"><?php echo MipHelper::formatCurrency($data->value)?></td>
  								<td class="button-column"> 
									<?php
										//
										// Botón para actualizar  pago "no en efectivo"
										//
										echo CHtml::ajaxLink(  '<i class="icon-pencil"></i>',$this->createUrl('pay/ajaxUpdateNotCashInfo', array('pay_not_cash_id'=>$data->id)),
											array(
												'update'=>'#updateNotCashInfo',
												'type'=>'GET',
												'data'=>array()
											),
								        	array(	
												'id'=>'btnUpdateNotCashInfo-' . $data->id,
												'class'=>"update",
												'title'=>MipHelper::t("Update"),
												'data-toggle'=>"tooltip",
												'data-original-title'=>MipHelper::t("Update"),
												'live'=>false,
											)
								        );
										echo CHtml::ajaxLink('<i class="icon-trash"></i>',$this->createUrl('pay/ajaxDeleteNotCashInfo', array('id'=>$data->id)),
												array(
														'type'=>'POST',
														'data'=>array(),
														'beforeSend'=>'function(jqXHR,settings){ if( confirm("' . MipHelper::t("¿Sure, do you want delete item?"). '") ) {  return true; } }',
														'success'=>'function(data, textStatus,jqXHR ){  $("#btnRefreshNotCashInfo").click(); }',
														
												),
												array(
														'id'=>'btnDeleteNotCashInfo-' . $data->id,
														'class'=>"delete",
														'title'=>MipHelper::t("Delete"),
														'data-toggle'=>"tooltip",
														'data-original-title'=>MipHelper::t("Delete"),
														'live'=>false,
												)
										);
									?>
  								</td>
  							</tr>
  							<?php if( $data->checked == 0 ) $deferred += $data->value?>
  							<?php $subtotal += $data->value; ?>
  							<?php endforeach;?>				
  						</tbody>
  						<tfoot>
  							<tr>
  								<th colspan="4"></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Sub-Total")?></a></th>
  								<th style="text-align: right;"><?php echo MipHelper::formatCurrency( $subtotal );?><?php echo CHtml::hiddenField('sub-total', $subtotal)?></th>
  								<th><a class="sort-link"></th>
  							</tr>
  							<tr>
  								<th colspan="4"></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Pay's Deferred")?></a></th>
  								<th style="text-align: right;"><?php echo MipHelper::formatCurrency( $deferred );?></th>
  								<th><a class="sort-link"></th>
  							</tr>   							 
							<tr class="success">
  								<th colspan="4"></th>
  								<th><a class="sort-link"><?php echo MipHelper::t("Total Payed")?></a></th>
  								<th class="btn-primary" style="text-align: right;"><span id="pay_total" ><?php echo MipHelper::formatCurrency( $subtotal - $deferred + $model->value_cash );?></span></th>
  								<th ><a class="sort-link"></th>
  							</tr>  	
  						</tfoot>
					</table>
			</div>
		</div>