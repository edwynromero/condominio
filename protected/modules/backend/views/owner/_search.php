<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'location_id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'person_id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'begin_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'end_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
