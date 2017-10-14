<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_id')); ?>:</b>
	<?php echo MipHelper::createLocationLink( $data->location_id ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
	<?php echo MipHelper::createPersonLinkById($data->person_id); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('begin_date')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::parseDateFromDb( $data->begin_date )); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::parseDateFromDb( $data->end_date )); ?>
	<br />


</div>