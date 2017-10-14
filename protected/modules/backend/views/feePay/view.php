<?php
$this->breadcrumbs=array(
	'Fee Pays'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List FeePay','url'=>array('index')),
array('label'=>'Create FeePay','url'=>array('create')),
array('label'=>'Update FeePay','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete FeePay','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage FeePay','url'=>array('admin')),
);
?>

<h1>View FeePay #<?php echo $model->id; ?></h1>

<?php 
/*$this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
				'name'=>'mip_pay_id',
				'type'=>'text',
				'value'=>MipHelper::getPayFullReference($model->mip_pay_id),
		),
		array(
			'name'=>'mip_fee_id',
			'type'=>'text',
			'value'=>MipHelper::getFeeFullReference($model->mip_fee_id),
		),
), 
)); */

?>

<fieldset >
    <legend ><?php echo MipHelper::t("Pay Info"); ?></legend>
    <div class="row-fluid">
        <?php  
 			echo $this->renderPartial('application.modules.backend.views.pay.__view',array('model'=>Pay::model()->findByPk( $model->mip_pay_id ))); 
		?>
    </div>
</fieldset>

<fieldset >
    <legend ><?php echo MipHelper::t("Fee Info"); ?></legend>
    <div class="row-fluid">
<?php  
 	echo $this->renderPartial('application.modules.backend.views.fee.__view',array('model'=>Fee::model()->findByPk( $model->mip_fee_id ))); 
?>
    </div>
</fieldset>