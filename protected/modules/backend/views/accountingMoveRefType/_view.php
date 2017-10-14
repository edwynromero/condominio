<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->key),array('view','id'=>$data->key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('associated_name')); ?>:</b>
	<?php echo CHtml::encode($data->associated_name); ?>
	<br />


</div>