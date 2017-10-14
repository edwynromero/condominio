<?php
$this->breadcrumbs=array(
	'Pays'=>array('index'),
	MipHelper::t("Location Fee Pay"),
);

$this->menu = MipHelper::getMenuToAdmin(Pay::model());

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('location-fee-pay-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1><?php echo MipHelper::t("Location Fee Pay")?></h1>
	
<!--
<?php echo CHtml::link( MipHelper::t('Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">

<textarea rows="" cols=""></textarea>
</div> search-form -->
<div class="well text-center" style="margin-bottom:0px;padding: 5px;">
	<button id="refresh-button" class="btn "><?php echo MipHelper::t("Refresh")?>!</button>
</div>
<?php Yii::app()->clientScript->registerScript('initRefresh',<<<JS
    $('#refresh-button').on('click',function(e) {
        e.preventDefault();
        $('#location-fee-pay-grid').yiiGridView('update');
    });
JS
,CClientScript::POS_READY); ?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'location-fee-pay-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
		array(
			'header'=>MipHelper::t("Location"),
			'name'=>'code',
		),
		array(
				'header'=>MipHelper::t("Fee"),
				'name'=>'name',
		),
		array(
				'header'=>MipHelper::t("Begin Date"),
				'name'=>'begin_date',
		),	
		array(
				'header'=>MipHelper::t("Payer"),
				'name'=>'fee_pay_id',
				'filter'=>'<div style="width:100px;"/>',
				'type'=>'text',
				'value'=>'MipHelper::getPayerName($data->fee_pay_id)',
		),
		array(
				'header'=>MipHelper::t("Date Pay"),
				'name'=>'fee_pay_id',
				'filter'=>'<div style="width:100px;"/>',
				'type'=>'text',
				'value'=>'MipHelper::getPayDate($data->fee_pay_id)',
		),
		'value',
		array(
				'header'=>'Pagado',
				'name'=>'fee_payed',
				'type'=>'text',
				'value'=>'MipHelper::showYesNo($data->fee_payed)',
		),		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{add}{update}{delete}',
			'deleteButtonOptions'  => array( 'title' => MipHelper::t('Delete'), ),
			'cssClassExpression' => 'empty($data->feed_id)?"hide_dependency":"otra";',
			'buttons'=>array(
					'delete'=>array(
						'label'=>MipHelper::t("Delete Pay"),
						'icon'=>"icon-trash",
						'url'=>function($data){
							if( empty($data->feed_id) ) return "#";
							return array('//backend/pay/deleteSingleFee', 'pay_id'=>$data->pay_id,'fee_id'=>$data->feed_id, 'location_id'=>$data->location_id);
						},							
						'visible'=>function($row, $data){
							return !empty($data->pay_id);
						},
					),
					'update'=>array(
							'label'=>MipHelper::t("Update Pay"),
							'icon'=>"icon-pencil",
							'url'=>function($data){
								if( empty($data->feed_id) ) return "#";
								return array('//backend/pay/updateSingleFee', 'pay_id'=>$data->pay_id,'fee_id'=>$data->feed_id, 'location_id'=>$data->location_id);
							},
							'options'=>array(
								'class'=>'dependency ',
								'target'=>'blank',
							),
							'visible'=>function($row, $data){								
								return !empty($data->pay_id); 
							},
					),
					'add'=>array(
							'label'=>MipHelper::t("Add Pay"),
							'icon'=>"icon-plus",
							'url'=>function($data){
								if( empty($data->feed_id) ) return "#";
								return array('//backend/pay/addSingleFee', 'fee_id'=>$data->feed_id, 'location_id'=>$data->location_id);
							},
							'options'=>array(
								'class'=>'dependency ',
								'target'=>'blank',
							),
							'visible'=>function($row, $data){					
								return empty($data->pay_id);
							},
					),					
			),
		),
),
)); ?>
