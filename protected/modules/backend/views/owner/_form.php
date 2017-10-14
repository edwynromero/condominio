<?php 

/* @var $this Controller */
/* @var $model Owner */
/* @var $form TbActiveForm */


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'owner-form',
	'enableAjaxValidation'=>false,
)); 




?>
<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'location_id', MipHelper::getDataLocations(), array('class'=>'span5', 'prompt'=>MipHelper::t("Choice a Location"))); ?>

	<div class="row-fluid">
		<div class="span5" >
			<?php
			echo $form->select2Row($model,'person_id', array(
					'data' =>MipHelper::getDataPersons(),
			),array('class'=>'','style'=>'width:100%;','prompt'=>MipHelper::t("Select a Person")));
			?>		
			<?php // echo $form->dropDownListRow($model,'person_id', MipHelper::getDataPersons(), array(,  'prompt'=>MipHelper::t("Choice a Person"))); ?>
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

	<?php echo $form->datepickerRow($model, 'begin_date',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array('class'=>'span5')
		            )
		        );
	?>
	

	<?php echo $form->datepickerRow($model, 'end_date',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array('class'=>'span5')
		            )
		        );
	?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>





<script>
	

	$(document).ready(function(){


		alert($("#AccountingPeriod_to").val());
	})
</script>




<?php $this->endWidget(); ?>
