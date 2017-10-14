<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getPersonName($data->person_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mip_association_position_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getAssociationPositionName($data->association_position_id)); ?>
	<br />


</div>