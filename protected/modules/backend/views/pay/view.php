<?php

/* @var $feePay FeePay */
/* @var $fee Fee */

$this->breadcrumbs=array(
	'Pays'=>array('index'),
	$model->id,
);

$this->menu = CMap::mergeArray(MipHelper::getMenuToView($model), array(array('label'=>MipHelper::t("Show Pay Receipt"),'url'=>array('showReceiptCurrentPay', 'pay_id'=>$model->id), 'linkOptions' => array('target'=>'_blank'))));

?>

<h1><?php echo MipHelper::getViewLabelMenu($model)?> #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('__view',array('model'=>$model));?>
<br>
<div class="row-fluid">
	<fieldset class="span6">
		<legend><?php echo MipHelper::t("Fees Paid");?></legend>
		<div class="fieldset-content">			
			<table class="table table-condensed">
              <thead>
                <tr>
                  <th><?php echo MipHelper::t("Fee")?></th>
                  <th><?php echo MipHelper::t("Date")?></th>
                  <th><?php echo MipHelper::t("Amount")?></th>
                  <th><?php echo MipHelper::t("Location")?></th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach( $feePays as $feePay ):; ?>
				<?php $fee = $feePay->fee; ?>
                <tr>
                  <td><?php echo MipHelper::createFeedLink($fee->id); ?></td>
                  <td><?php echo $fee->begin_date; ?></td>
                  <td><?php echo MipHelper::formatCurrency($fee->value); ?></td>
                  <td><?php echo MipHelper::createLocationLink( $feePay->location_id ); ?></td>
                </tr>
				<?php endforeach; ?>                
              </tbody>
            </table>			
		</div>
	</fieldset>
	<fieldset class="span6">
		<legend><?php echo MipHelper::t("Not Cash Info");?></legend>
		<div class="fieldset-content">
			<table class="table table-condensed">	
              <thead>
                <tr>
                  <th><?php echo MipHelper::t("Type")?></th>
                  <th><?php echo MipHelper::t("Number")?></th>
                  <th><?php echo MipHelper::t("UnChecked")?></th>                  
                  <th><?php echo MipHelper::t("Checked")?></th>
                </tr>
              </thead>
              <tbody>
              	<?php $total_notcash_unchecked = 0; $total_notcash_checked = 0;?>
              	<?php foreach( $payNotCashInfos as $payNotCashInfo ):; ?>
              	<?php /* @var $payNotCashInfo PayNotCashInfo */              	
              		$total_notcash_unchecked += $payNotCashInfo->checked?0:$payNotCashInfo->value;
              		$total_notcash_checked += $payNotCashInfo->checked?$payNotCashInfo->value:0;
              	?>
                <tr>
                  <td><?php echo MipHelper::getNotCashTypeName( $payNotCashInfo->type ); ?></td>
                  <td><?php echo $payNotCashInfo->number; ?></td>
                  <td><?php echo $payNotCashInfo->checked?'':MipHelper::formatCurrency($payNotCashInfo->value); ?></td>
                  <td><?php echo $payNotCashInfo->checked?MipHelper::formatCurrency($payNotCashInfo->value):''; ?></td>
                </tr>
				<?php endforeach; ?>
              </tbody>
              <tfoot>
              	<tr style="background-color: #EEF">
              		<th colspan="2" style="text-align: right;"><?php echo MipHelper::t("Total")?></th>
              		<td><?php echo MipHelper::formatCurrency($total_notcash_unchecked); ?></td>
              		<td><?php echo MipHelper::formatCurrency($total_notcash_checked); ?></td>
              	</tr>
              </tfoot>
            </table>			
		</div>
	</fieldset>
</div>