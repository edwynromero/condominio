<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'pay_id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'bank_account_id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'number',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'type',array('class'=>'span5','maxlength'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
