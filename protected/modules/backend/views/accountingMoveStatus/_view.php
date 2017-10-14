<?php
/* @var $this AccountingMoveStatusController */
/* @var $data AccountingMoveStatus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->key), array('view', 'id'=>$data->key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label')); ?>:</b>
	<?php echo CHtml::encode($data->label); ?>
	<br />


</div>