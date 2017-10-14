<?php 
/* @var $form TbActiveForm */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 

?>
		<br>
		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>
		<br>
		<div>
		<?php 
		$criteria = new CDbCriteria();
		$criteria->order = "first_name ASC, last_name ASC, full_name ASC";
		
		echo $form->select2Row($model,'person_id', array(
			'data' => CHtml::listData(Person::model()->findAll($criteria), "id", "FullNameList"),
		),array(''=>'','style'=>'margin-bottom:200xmen;')); 
		?>
		<br>
		<br>
		</div>
		<?php echo $form->textFieldRow($model,'pay_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'input',
			'label'=>MipHelper::t('Close'),
			'htmlOptions'=>array('onclick'=>'jQuery("a.search-button").click();')
		)); ?>	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>MipHelper::t('Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
