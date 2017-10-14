<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
		
		<?php echo $form->textFieldRow($model,'identity_type',array('class'=>'span5','maxlength'=>1)); ?>

		<?php echo $form->textFieldRow($model,'identity_code',array('class'=>'span5','maxlength'=>16)); ?>
		
		<?php echo $form->textFieldRow($model,'user_name',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>60)); ?>

		<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>60)); ?>

		<?php echo $form->textFieldRow($model,'full_name',array('class'=>'span5','maxlength'=>120)); ?>
		
		<?php echo $form->textFieldRow($model,'phone_type',array('class'=>'span5','maxlength'=>2)); ?>
		
		<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'phone_prefix',array('class'=>'span5','maxlength'=>5)); ?>

		<?php echo $form->textFieldRow($model,'phone_number',array('class'=>'span5','maxlength'=>9)); ?>

		<?php echo $form->textAreaRow($model,'person_email',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>MipHelper::t('Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
