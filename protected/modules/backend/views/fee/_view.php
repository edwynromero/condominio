<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('fee_type_id')); ?>:</b>
	<?php echo CHtml::encode( MipHelper::getFeeTypeName( $data->fee_type_id ) ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('begin_date')); ?>:</b>
	<?php echo CHtml::encode( MipHelper::parseDateFromDb($data->begin_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::parseDateFromDb($data->end_date)); ?>
	<br />	
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('summary')); ?>:</b>
	<?php echo CHtml::encode($data->summary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::formatCurrency($data->value)); ?>
	<br />





</div>