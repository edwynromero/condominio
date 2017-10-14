<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id, 'person_id'=>$data->person_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getPersonName( $data->person_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->prefix . "-" . $data->number ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_main')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::showYesNo($data->is_main)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::getCountryName( $data->country_id)); ?>
	<br />


</div>