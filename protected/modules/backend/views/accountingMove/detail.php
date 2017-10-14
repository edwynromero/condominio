<?php 
    $accountingMove = AccountingMove::model()->find('id=:id', array(':id'=>$model->id)) ; 
    $statusButtonAction = "";
    $statusButtonLabel  = "Closed";
    $statusLabel = "Opened";
    switch($accountingMove->status ){
        case AccountingMoveStatus::defaultStatusOpen()->key:
            $statusButtonAction = "//backend/accountingMove/close";
            $statusButtonLabel  = "Close";
            $statusLabel        = "Opened";
            break;
        case AccountingMoveStatus::defaultStatusClosed()->key:
            $statusButtonAction = "//backend/accountingMove/open";
            $statusButtonLabel  = "Open";
            $statusLabel        = "Closed";
            break;
        case AccountingMoveStatus::defaultStatusConciliated()->key:
            $statusButtonLabel  = "Close";
            $statusButtonAction = "//backend/accountingMove/close";
            $statusLabel        = "Conciliated";
            break;   
        default:
            $statusButtonLabel  = "Clean ";
            $statusButtonAction = "//backend/accountingMove/open";
            $statusLabel        = "Cleaned";
            break;
    }
    
    if(!isset($showCancelButton)){
        $showCancelButton = true;
    }
    
    $balance_total = AccountingHelper::getBalanceFromAccountingMove( $accountingMove->id  );

 ?>
<div id="accounting_move_detail" class="well well-large">
    <div class="row-fluid">
        <div class="span1"><strong>ID</strong>: </div>
        <div class="span9"><?php echo $accountingMove->id;?></div> 
        <div class="span2 text-right"><strong><?php echo AccountingHelper::t("Date");?></strong>: <?php echo MipHelper::parseDateFromDb($accountingMove->date_at);?></div>
    </div>
    <div class="row-fluid">
        <div class="span1"><strong><?php echo AccountingHelper::t("Description"); ?></strong></div>
        <div class="span10"><?php echo $accountingMove->label;?></div>
    </div>
    <div class="row-fluid"> 
        <div class="span1"><strong><?php echo AccountingHelper::t("Status"); ?></strong></div>
        <div class="span1">
            <?php echo AccountingHelper::t($statusLabel);?>         
        </div>  
        <div class="span1">
            <?php 
                if($showCancelButton){
                    $this->widget('bootstrap.widgets.TbButton', array(
                        'type'=>'success',
                        'label'=> AccountingHelper::t($statusButtonLabel),
                        'url' => array($statusButtonAction, "id" => $accountingMove->id ),
                        'htmlOptions'=>array( 'class' => ' btn-mini'), )
                    );
                }
            ?>
        </div>
        <div class="span3 offset6 text-right">
            <strong>Balance: </strong><?php echo MipHelper::formatCurrency($balance_total); ?> <span class="text-success"><?= $balance_total < 0 ? "(Debe)":$balance_total == 0?"":"(Haber)"; ?></span>
        </div>
    </div>
</div>

