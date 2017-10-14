<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>60)); ?>

		<?php echo $form->textFieldRow($model,'summary',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'begin_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'end_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'value',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'fee_type_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
