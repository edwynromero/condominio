<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'key',array('class'=>'span5','maxlength'=>8)); ?>

		<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'associated_name',array('class'=>'span5','maxlength'=>64)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
