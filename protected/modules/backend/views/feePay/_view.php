<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mip_pay_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getPayFullReference( $data->mip_pay_id )); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mip_fee_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getFeeFullReference( $data->mip_fee_id )); ?>
	<br />


</div>