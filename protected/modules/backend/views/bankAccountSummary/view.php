<?php
/* @var $this BankAccountSummaryController */
/* @var $model BankAccountSummary */


$this->breadcrumbs=array(
	'Bank Account Summaries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>MipHelper::t('Create BankAccountSummary'), 'url'=>array('create', "bank_account_id"=>$bankAccount->id)),
	array('label'=>MipHelper::t('Update BankAccountSummary'), 'url'=>array('update', 'id'=>$model->id, "bank_account_id"=>$bankAccount->id)),
	array('label'=>MipHelper::t('Delete BankAccountSummary'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id, "bank_account_id"=>$bankAccount->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>MipHelper::t('Manage BankAccountSummary'), 'url'=>array('admin', "bank_account_id"=>$bankAccount->id)),
);
?>

<h1><?php echo MipHelper::t("View BankAccountSummary"); #<?php echo $model->id; ?></h1>
<div class="row-fluid">
    <div class="span2">
        <strong><?php echo MipHelper::t("Year") ?>:</strong>
    </div>
    <div class="span2">
        <?php echo $model->year; ?>
    </div>
    <div class="span2">
        <strong><?php echo MipHelper::t("Month") ?>:</strong>
    </div>
    <div class="span2">
        <?php echo $months[$model->month]; ?>
    </div>
    <div class="span2">
        
    </div>
</div>
<div class="row-fluid">
    <div class="span2">
       <strong><?php echo MipHelper::t("Open Balance Account") ?>:</strong>
    </div>
    <div class="span2">
        
    </div>
    <div class="span2">
        <strong><?php echo MipHelper::t("Final Balance Account") ?>:</strong>
    </div>
    <div class="span2">
        
    </div>
    <div class="span2">
        
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
    
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo MipHelper::t("Begin Date"); ?></th>
                        <th><?php echo MipHelper::t("End Date"); ?></th>
                        <th><?php echo MipHelper::t("Code"); ?></th>
                        <th><?php echo MipHelper::t("Summary"); ?></th>
                        <th><?php echo MipHelper::t("Income"); ?></th>
                        <th><?php echo MipHelper::t("Outcome"); ?></th>
                        <th><?php echo MipHelper::t("Balance"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong><?php echo MipHelper::t("Beginning Balance"); ?></strong></td>
                        <td></td>
                        <td></td>
                        <td><?php echo MipHelper::formatCurrency( $balance, "" ); ?></td>
                    </tr>
                    <?php foreach($currentEntries as $entry ): ?>
                        <tr>
                            <td></td>
                            <td><?php echo $entry->begin_date; ?></td>
                            <td><?php echo $entry->end_date; ?></td>
                            <td><?php echo $entry->number; ?></td>
                            <td><?php echo $entry->summary; ?></td>
                            <?php if($entry->isIncome): ?>
                                <?php $balance +=  $entry->value;?>
                                <td><?php echo MipHelper::formatCurrency( $entry->value, "" ); ?></td>
                                <td> - </td>
                            <?php else: ?>
                                <?php $balance -=  $entry->value;?>
                                <td> . </td>
                                <td><?php echo MipHelper::formatCurrency( $entry->value, "" ); ?></td>
                            <?php endif; ?>
                            <td><?php echo MipHelper::formatCurrency( $balance, "" ); ?></td>
                        </tr>
                    <?php endforeach;?>

                    <tr>
                         <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong><?php echo MipHelper::t("Final Balance Account"); ?></strong></td>
                        <td></td>
                        <td></td>
                        <td><?php echo MipHelper::formatCurrency( $balance, "" ); ?></td>
                    </tr>
                </tbody>
            </table>
        
    </div>
</div>
