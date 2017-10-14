<?php 

/* @var $this AccountingJournalController */
/* @var $model AccountingJournal*/
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'accounting-journal-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>64)); ?>

<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<?php echo $form->dropDownListRow($model,'journal_type', GxHtml::listDataEx( AccountingJournalType::getDefaults(), "key", "label"), array('class'=>'span5','maxlength'=>4)); ?>

<?php echo $form->dropDownListRow($model,'credt_account_id', GxHtml::listDataEx(AccountingAccount::findAllWithoutChildrens(), "id", "label"), array('class'=>'span5','maxlength'=>4)); ?>

<?php echo $form->dropDownListRow($model,'debt_account_id', GxHtml::listDataEx(AccountingAccount::findAllWithoutChildrens(), "id", "label"), array('class'=>'span5','maxlength'=>4)); ?>

<?php echo $form->checkBoxRow($model,'deprecated',array('class'=>'', 'uncheckValue'=>0, 'checkValue'=>1)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
