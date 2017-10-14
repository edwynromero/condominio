<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		
		
		<?php if( empty($person_id) ): ?>	
		<?php echo $form->textFieldRow($model,'person_id',array('class'=>'span5')); ?>
		<?php endif; ?>		
		
		<?php echo $form->textAreaRow($model,'email',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->checkBoxRow($model,'is_main',array()); ?>
		
		

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
