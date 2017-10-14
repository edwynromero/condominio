<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_account_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getBankAccountFullReference($data->bank_account_id)); ?>
	<br />	

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getPayFullReference($data->pay_id)); ?>
	<br />	
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getNotCashTypeName($data->type)); ?>
	<br />
		
	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::formatCurrency($data->value)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getBankName($data->bank_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />	

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked')); ?>:</b>
	<?php echo CHtml::encode( MipHelper::showYesNo($data->checked) ); ?>
	<br />	

</div>