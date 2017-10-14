<?php
$this->breadcrumbs=array(
	'Pays'=>array('index'),
	'Manage',
);

$this->menu = MipHelper::getMenuToAdmin($model);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('pay-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo MipHelper::getManageLabelMenu($model)?></h1>
	

<?php echo CHtml::link( MipHelper::t('Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="well text-center" style="margin-bottom:0px;padding: 5px;margin-top:10px;">
	<button id="refresh-button" class="btn "><?php echo MipHelper::t("Refresh")?>!</button>
</div>
<?php Yii::app()->clientScript->registerScript('initRefresh',<<<JS
    $('#refresh-button').on('click',function(e) {
        e.preventDefault();
        $('#pay-grid').yiiGridView('update');
    });
JS
,CClientScript::POS_READY); ?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pay-grid',
	'type' => ' striped',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			array(
					'header'=>'Fecha Pago',
					'name'=>'pay_date',
					'type'=>'text',
					'value'=>'MipHelper::parseDateFromDb($data->pay_date)',
			),
			array(
					'header'=>'Propietario',
					'name'=>'person_id',
					'type'=>'raw',
					'value'=>'MipHelper::createPersonLinkById($data->person_id)'
			),
			array(
					'header'=>'Pago Efectivo',
					'name'=>'actual_pay',
					'type'=>'text',
					'filter'=>'<div style="width:50px;"></div>',
					'value'=>'MipHelper::formatCurrency($data->actualPay)',
			),
			array(
				'header'=>'Pago Diferido',
				'name'=>'deferredPay',
				'type'=>'text',
				'filter'=>'<div style="width:50px;"></div>',
				'value'=>'MipHelper::formatCurrency($data->deferredPay)',
			),		
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{view}{update}{delete}',
				'buttons'=>array(
					'update'=>array(
						'options'=>array(
								'target'=>'blank',
						),
					),
					'view'=>array(
							'options'=>array(
									'target'=>'blank',
							),
					),
                                        'delete'=>array('options' => array('id'=>'delete'),),
				),
			),
	),
)); ?>
