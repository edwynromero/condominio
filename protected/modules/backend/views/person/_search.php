<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>
		
		<?php echo $form->dropDownListRow($model,'identity_type', MipHelper::getIdentityTypeList(),array('class'=>'span5','maxlength'=>1)); ?>
		
		<?php echo $form->textFieldRow($model,'identity_code',array('class'=>'span5','maxlength'=>16)); ?>

		<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>60)); ?>

		<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>60)); ?>

		<?php echo $form->textFieldRow($model,'full_name',array('class'=>'span5','maxlength'=>120)); ?>
		
		<?php echo $form->checkBoxRow($model,'active'); ?>

		<?php echo $form->textAreaRow($model,'inactive_description',array('class'=>'span5','maxlength'=>255)); ?>
		
		<?php echo $form->dropDownListRow($model,'group_person_id', MipHelper::getDataGroupPerson(), array('class'=>'span5', 'prompt'=>'-- Puede seleccionar si lo desea --')); ?>
		
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
