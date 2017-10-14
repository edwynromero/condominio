<?php 
/* @var $this Controller */
/* @var $model State */
/* @var $form TbActiveForm */

$bank = Bank::model()->findByPk($data->bank_id);
?>
<div class="span4 view account_view">
    
    <div class="row-fluid">
        <div class="span4 logo-container">
            <?php echo  CHtml::image( "/images/" . strtoupper( $bank->akey ) . ".png",  $bank->name,array("class"=>"bank_logo")) ; ?>
        </div>
        <div class="span8">
            <div class="row-fluid">
                <div class="span4"><strong><?php echo CHtml::encode($data->getAttributeLabel('bank_id')); ?>:</strong></div>
                <div class="span8"><?php echo CHtml::encode(MipHelper::getBankName($data->bank_id)); ?></div>
            </div>
            <div class="row-fluid">
                <div class="span4"><strong><?php echo CHtml::encode($data->getAttributeLabel('account_type')); ?>:</strong></div>
                <div class="span8"><?php echo CHtml::encode(MipHelper::getAccountTypeName($data->account_type)); ?></div>
            </div>
            <div class="row-fluid">
                <div class="span4"><strong><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</strong></div>
                <div class="span8"><?php echo CHtml::encode($data->number);  ?></div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 text-center button">
            <?php echo CHtml::link(  MipHelper::t("Monthly summary"), array("//backend/bankAccountSummary/admin", "bank_account_id"=>$data->id), array("class"=>"btn btn-primary ")) ?>
        </div>
    </div>
</div>