<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('key')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->key), array('view', 'id' => $data->key)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('label')); ?>:
	<?php echo GxHtml::encode($data->label); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('is_debt')); ?>:
	<?php echo GxHtml::encode($data->is_debt); ?>
	<br />

</div>