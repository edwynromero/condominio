<?php
/* @var $this AccountingMoveLineController */
/* @var $data AccountingMoveLine */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accounting_move_id')); ?>:</b>
	<?php echo CHtml::encode($data->accounting_move_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accounting_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->accounting_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accounting_period_id')); ?>:</b>
	<?php echo CHtml::encode($data->accounting_period_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debt')); ?>:</b>
	<?php echo CHtml::encode($data->debt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credt')); ?>:</b>
	<?php echo CHtml::encode($data->credt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('balance')); ?>:</b>
	<?php echo CHtml::encode($data->balance); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_at')); ?>:</b>
	<?php echo CHtml::encode($data->date_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reconciled')); ?>:</b>
	<?php echo CHtml::encode($data->reconciled); ?>
	<br />

	*/ ?>

</div>