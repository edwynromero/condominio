<div class="form">
<?php 

/* @var $this AccountingAccountController */
/* @var $model AccountingAccount */
/* @var $form TbActiveForm */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'accounting-account-form',
	'enableAjaxValidation' => false,
));

$accountingKinds = isset($accountingKinds)?$accountingKinds:AccountingAccountKind::getDefaults();

?>

	<?php echo MipHelper::getHtmlFieldRequiered(); ?>
        
	<?php echo $form->errorSummary($model); ?>
    
        <div class="row-fluid"> 
            <div class="span4">
                <?php echo $form->labelEx($model,'parent_account_id', array("label"=> AccountingHelper::t("Parent Account"))); ?>
                <?php echo $form->select2Row($model,'parent_account_id', array(
                        'data' => GxHtml::listDataEx( AccountingAccount::findAllAccountViews(), "id", "codeWithLabel"),
                    'htmlOptions'=>array('style'=>'width:100%;')
                    ),array(''=>'', 'label'=>false)  ); ?>
                <?php echo $form->error($model,'parent_account_id'); ?>    
            </div>
        </div>

        <div class="row-fluid">   
            <div class="span5">
                <br>
                <?php echo $form->labelEx($model,'kind'); ?>
                <?php echo $form->dropDownList($model, 'kind', GxHtml::listDataEx($accountingKinds, "key", "title" ) ); ?>
                <?php echo $form->error($model,'kind'); ?>      
            </div>
        </div>
        
        <div class="row-fluid"> 
            <div class="span5">
                <?php echo $form->labelEx($model,'type'); ?>
                <?php echo $form->dropDownList($model, 'type', GxHtml::listDataEx(AccountingAccountType::model()->findAllAttributes(array('`key`','label'), false))); ?>
                <?php echo $form->error($model,'type'); ?>                
            </div>
        </div>
 
         <div class="row-fluid">    
             <div class="span5">
                <?php echo $form->labelEx($model,'code'); ?>
                <?php echo $form->textField($model, 'code', array('style'=>'width:20%;')); ?>
                <?php echo $form->error($model,'code'); ?>                 
             </div>
        </div>
        
         <div class="row-fluid">
            <?php echo $form->labelEx($model,'label'); ?>
            <?php echo $form->textField($model, 'label', array('maxlength' => 45,'style'=>'width:34%;')); ?>
            <?php echo $form->error($model,'label'); ?>
         </div>
    
        <div class="row-fluid">        
            <div class="span6">
                <?php echo $form->labelEx($model,'note'); ?>
                <?php echo $form->textArea($model, 'note', array("row"=>3, "col"=>6, "style" => "width:100%;") ); ?>
                <?php echo $form->error($model,'note'); ?>
            </div>
        </div>
    
        <div class="row-fluid">        
            <div class="span6">
                <?php echo $form->labelEx($model,'deprecated'); ?>
                <?php echo $form->checkBox($model, 'deprecated', array( 'value'=>1,'uncheckValue'=>0 )  ); ?>
                <?php echo $form->error($model,'deprecated'); ?>
            </div>
        </div>

        <div class="row-fluid">        
            <div class="span6">
                <br>
                <?php
                    echo GxHtml::submitButton(MipHelper::t('Save'), array('class'=>'btn btn-primary'));
                ?>
            </div>
        </div> 
    <?php $this->endWidget(); ?>
</div><!-- form -->