<?php 
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>45)); ?>
	
	<?php echo $form->passwordFieldRow($model,'password_confirm',array('class'=>'span5','maxlength'=>45)); ?>

	<?php if($model->isNewRecord):?>		
		<?php echo $form->hiddenField($model,'last_connection',array('class'=>'span5')); ?>
	<?php else:?>
		<?php echo $form->textFieldRow($model,'last_connection',array('class'=>'span5','readOnly'=>true)); ?>
	<?php endif;?>

	<?php echo $form->hiddenField($model,'token',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->hiddenField($model,'person_id',array('class'=>'span5')); ?>
	
	<div class="row-fluid">
		<div class="span3" >
			<?php //echo $form->dropDownListRow($model,'person_id', MipHelper::getDataPersons(), array('style'=>'width:100%;',  'prompt'=>MipHelper::t("Choice a Person"))); ?>
			<?php 
			$criteria = new CDbCriteria();
			$criteria->order = "first_name ASC, last_name ASC, full_name ASC";			
			echo $form->select2Row($model,'person_id', array(
				'data' => CHtml::listData(Person::model()->findAll($criteria), "id", "FullNameList"),
			),array( )); 
			?>		
		</div>
		<div class="span7" style="height: 100%; height: 64px;">
			<?php				
				echo CHtml::ajaxLink(MipHelper::t('Create Person'),$this->createUrl('person/createAjax'),
					array(
			        	'update'=>'#createPerson',
						'type'=>'GET',
						'data'=> array()
						),
			        array('id'=>'launchCreatePerson', 'class'=>'btn', 'style'=>'margin-top:24px;')
				);
			?>
		</div>
		<div id="createPerson"></div>
	</div>	

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
