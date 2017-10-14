<div class="view" >

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
		<?php echo MipHelper::createPersonLinkById($data->person_id); ?>
	<br />	

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_date')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::parseDateFromDb($data->pay_date)); ?>
	<br />-

	<b><?php echo CHtml::encode($data->getAttributeLabel('value_cash')); ?>:</b>
	<?php echo CHtml::encode(MipHelper::formatCurrency($data->value_cash)); ?>
	<br />

</div>