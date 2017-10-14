<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>10)); ?>
	
	<?php echo $form->dropDownListRow($model,'status', MipHelper::getLocationStatusList(),array('class'=>'span5', 'prompt'=>MipHelper::t('Choice a Status'))); ?>
	
	<?php echo $form->checkBoxRow($model,'is_built',array()); ?>	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
