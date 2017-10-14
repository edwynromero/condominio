<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('is_built')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::showYesNo($data->is_built)); ?>
	<br />	
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('initial_debt')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::formatCurrency($data->initial_debt)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getLocationStatusName($data->status)); ?>
	<br />
</div>