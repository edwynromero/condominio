<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('full_name')); ?>:</b>
	<?php echo CHtml::encode($data->full_name); ?>
	<br />

	<b><?php echo CHtml::encode(MipHelper::t('Identity')); ?>:</b>
	<?php echo CHtml::encode($data->identity_type."-".$data->identity_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::showYesNo( $data->active )); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('inactive_description')); ?>:</b>
	<?php echo CHtml::encode($data->inactive_description); 	*/?>
	
	<b><?php  echo CHtml::encode($data->getAttributeLabel('group_person_id')); ?>:</b>
	<?php echo $data->group_person_id?CHtml::encode(MipHelper::getGroupPersonName( $data->group_person_id )):'<span class="null">'.MipHelper::t("Don't assigned").'</span>'; ?>
	<br />

</div>