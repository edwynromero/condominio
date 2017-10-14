<?php 
/* @var $this Controller */
/* @var $model Person */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'person-form',
	'enableAjaxValidation'=>false,
)); ?>

<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'identity_type', MipHelper::getIdentityTypeList(),array('class'=>'span5','maxlength'=>1)); ?>
	
	<div id="row_first_name">
	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>60)); ?>
	</div>
	<div id="row_last_name">
	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>60)); ?>
	</div>
	<div id="row_full_name">
	<?php echo $form->textFieldRow($model,'full_name',array('class'=>'span5','maxlength'=>120)); ?>
	</div>
	<?php echo $form->textFieldRow($model,'identity_code',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->checkBoxRow($model,'active'); ?>

	<div id="row_inactive_description" >
		<?php echo $form->textAreaRow($model,'inactive_description',array('class'=>'span5','maxlength'=>255)); ?>
	</div>

	<br>
	<?php echo $form->dropDownListRow($model,'group_person_id', MipHelper::getDataGroupPerson(), array('class'=>'span5', 'prompt'=>'-- Puede seleccionar si lo desea --')); ?>			


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>

<script language="javascript">
	$(document).ready(function()
	{
		$("#Person_identity_type").on('change', function()
				{
					var identityType = $("#Person_identity_type").val();
					if( identityType == 'V' || identityType == 'E' || identityType == 'F' )
					{
						$("#Person_first_name").val("");
						$("#Person_last_name").val("");
						$("#Person_full_name").val("S/N");
												
						$("#row_first_name").show();
						$("#row_last_name").show();
						$("#row_full_name").hide();
					}
					else
					{
						$("#Person_first_name").val("S/N");
						$("#Person_last_name").val("S/N");
						$("#Person_full_name").val("");
												
						$("#row_first_name").hide();
						$("#row_last_name").hide();
						$("#row_full_name").show();
					} 
				}
			); 

			$("#Person_active").on('change', function()
				{
					if( this.checked )
					{
						$("#row_inactive_description").hide();
					}
					else
					{
						$("#row_inactive_description").show();
					}					
				}
			);

			var tmpFirstName = $("#Person_first_name").val();
			var tmpLastName = $("#Person_last_name").val();
			var tmpFullName = $("#Person_full_name").val();
			$("#Person_active").change();					
			$("#Person_identity_type").change();
			<?php if( !$model->isNewRecord ):?>
			$("#Person_first_name").val(tmpFirstName);
			$("#Person_last_name").val(tmpLastName);
			$("#Person_full_name").val(tmpFullName);
			<?php endif;?>
		}		
	);	
</script>
