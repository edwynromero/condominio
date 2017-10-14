<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('parentAccount')); ?>:
	<?php echo GxHtml::encode(GxHtml::valueEx($data->parentAccount)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type0')); ?>:
	<?php echo GxHtml::encode(GxHtml::valueEx($data->type0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('code')); ?>:
	<?php echo GxHtml::encode($data->code); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('label')); ?>:
	<?php echo GxHtml::encode($data->label); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('debt')); ?>:
	<?php echo GxHtml::encode($data->debt); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('credt')); ?>:
	<?php echo GxHtml::encode($data->credt); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('balance')); ?>:
	<?php echo GxHtml::encode($data->balance); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('created_at')); ?>:
	<?php echo GxHtml::encode($data->created_at); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('updated_at')); ?>:
	<?php echo GxHtml::encode($data->updated_at); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('access_key')); ?>:
	<?php echo GxHtml::encode($data->access_key); ?>
	<br />
	*/ ?>

</div>