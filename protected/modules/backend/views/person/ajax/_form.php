<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'person-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="row-fluid">
	<div class="span12" style="padding:10px;">
<? echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class="span5">
			<?php  echo $form->labelEx($model, 'identity_type') ?>
			<?php echo $form->dropDownList($model,'identity_type', MipHelper::getIdentityTypeList(),array('style'=>'width:100%;','maxlength'=>1)); ?>	
		</div>
		<div class="span5 offset1">
			<?php  echo $form->labelEx($model, 'identity_code') ?>
			<?php echo $form->textField($model,'identity_code',array('style'=>'width:100%;','maxlength'=>16)); ?>
		</div>		
	</div>
	

	<div class="row-fluid">
		<div id="row_first_name" class="span5">
			<?php  echo $form->labelEx($model, 'first_name') ?>
			<?php echo $form->textField($model,'first_name',array('style'=>'width:100%;','maxlength'=>120)); ?>
		</div>		
		<div id="row_last_name" class="span5 offset1">
			<?php  echo $form->labelEx($model, 'last_name') ?>
			<?php echo $form->textField($model,'last_name',array('style'=>'width:100%;','maxlength'=>60)); ?>
		</div>	
	</div>
	<div class="row-fluid">
		<div id="row_full_name" class="span11">
			<?php  echo $form->labelEx($model, 'full_name') ?>
			<?php echo $form->textField($model,'full_name',array('style'=>'width:100%','maxlength'=>120)); ?>
			<?php  echo $form->error($model, 'full_name') ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php 
			echo CHtml::ajaxSubmitButton(MipHelper::t($model->isNewRecord ? 'Create' : 'Save'),CHtml::normalizeUrl(
			array('person/createAjax')),
			array('update'=>'#createPersonDialog',
				'onclick'=>'$("#createPersonDialog").dialog("close")',
			),
			array('id'=>'closeCreatePersonDialog', 'class'=>'btn btn-primary')); 
		?>
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
	</div>
</div>