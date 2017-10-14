<?php
/* @var $this AccountingPeriodStatusController */
/* @var $data AccountingPeriodStatus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->key), array('view', 'id'=>$data->key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label')); ?>:</b>
	<?php echo CHtml::encode($data->label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('at_year')); ?>:</b>
	<?php echo CHtml::encode($data->at_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('at_period')); ?>:</b>
	<?php echo CHtml::encode($data->at_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />


</div>