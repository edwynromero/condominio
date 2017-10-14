<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'person-form',
        'enableAjaxValidation'=>false,
)); ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3><?php echo MipHelper::t("Deposits or transfers"); ?></h3>
</div>
<div class="modal-body" >

        <div class="row-fluid">
                <div class="span12">	
        <!--
        <div class="row-fluid" style="width:650px">
                <div  style="padding-left:10px;padding-right:10px;">  -->
                            <?php echo MipHelper::getHtmlFieldRequiered() ?>
                            <?php // echo $form->errorSummary($model); ?>

                            <?php echo $form->hiddenField($model,'pay_id'); ?>

                            <div class="row-fluid">
                                    <div class="span4">		
                                            <?php echo $form->dropDownListRow($model,'type', MipHelper::getNotCashTypeList(),array('style'=>'width:100%', 'prompt'=>MipHelper::t('Choice a Option'))); ?>
                                    </div>
                                    <div class="span4">
                                            <?php echo $form->dropDownListRow($model,'source_bank_id', MipHelper::getDataBanks(), array('style'=>'width:100%', 'prompt'=>MipHelper::t('Choice a Option'))); ?>
                                    </div>
                                    <div class="span4">
                                    <?php echo $form->textFieldRow($model,'number',array('class'=>'span12','maxlength'=>255)); ?>
                                    </div>
                            </div>	

                            <div class="row-fluid">
                                    <div class="span4">
                                            <?php echo $form->dropDownListRow($model,'bank_account_id', MipHelper::getDataBankAccount(), array('class'=>'span12', 'prompt'=>MipHelper::t('Choice a Bank Account'))); ?>		
                                    </div>
                                    <div class="span4">
                                                    <?php echo $form->datepickerRow($model, 'pay_date',
                                                        array(
                                                                'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
                                                                                    'htmlOptions'=>array('class'=>'', 'readonly'=>'readonly', 'style'=>'width:95%;')
                                                        ),
                                                                    array(  )
                                                    );
                                                    ?>
                                    </div>
                                    <div id="value_pay_container" class="span4">
                                            <?php  echo $form->label($model, 'value', array( 'class' => $model->hasErrors('value')?$form->errorMessageCssClass:'' )) ?>

                                            <?php $this->widget("FormatCurrency",
                                                                                            array(
                                                                                               "model" => $model,
                                                                                                "attribute" => "value",
                                                                                                    "value"=>$model->value,
                                                                                                "options" => array( "negativeFormat"=>'-%s%n',
                                                                                                                                                "roundToDecimalPlace" => 2,
                                                                                                                                                "region"=> 'es-VE',
                                                                                                                                                "decimalSymbol" => ',',
                                                                                                                                                "digitGroupSymbol" => '.'),
                                                                                                                    "htmlOptions"=>array("style"=>"width:100%;")
                                                                                                ));?>

                                            <?php echo $form->error($model,"value"); ?>
                                    </div>	
                            </div>	
                            <div class="row-fluid">
                                    <div class="span10">
                                    </div>
                                    <div class="span2" style="padding-left:20px;">
                                            <?php  echo $form->checkBoxRow($model, 'checked', array( 'class' => '' )) ?>
                                    </div>	
                            </div>	


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
    
</div>
<div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
        <?php 
                echo CHtml::ajaxSubmitButton(MipHelper::t($model->isNewRecord ? 'Create' : 'Save'),
                CHtml::normalizeUrl(array($model->isNewRecord ? 'pay/ajaxCreateNotCashInfo':'pay/ajaxUpdateNotCashInfo', 'person_id' => $person_id , $model->isNewRecord ? 'pay_id' : 'pay_not_cash_id'=> $model->isNewRecord? $model->pay_id : $model->id )),
                array(
                        'update'=>$model->isNewRecord ? '#createPayNotCashInfoDialog':'#updatePayNotCashInfoDialog',
                        'onclick'=>$model->isNewRecord ? '$("#createPayNotCashInfoDialog").modal("hide")':'$("#updatePayNotCashInfoDialog").modal("hide")'
                ),
                array('id'=>'btnSavePayNotCashInfoDialog', 'class'=>'btn btn-primary', 'live'=>false, )); 
        ?>
</div>
<?php $this->endWidget(); ?>