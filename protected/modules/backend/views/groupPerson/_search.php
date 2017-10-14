<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>160)); ?>

		<?php echo $form->dropDownListRow($model,'type', MipHelper::getGroupPersonsTypeList() ,array('class'=>'span5','maxlength'=>1, 'prompt'=>MipHelper::t("- No Selected -"))); ?>
		
		<?php echo $form->checkBoxRow($model,'active',array()); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
