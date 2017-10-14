<?php
$this->breadcrumbs=array(
	'Pay Not Cash Infos'=>array('index'),
	'Manage',
);


$this->menu=array(
		array('label'=>MipHelper::t('Admin Pay'),'url'=>array('//backend/pay/admin')),
		array('label'=> MipHelper::t('Create Pay'),'url'=>array('//backend/pay/create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('pay-not-cash-info-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");

?>

<h1>Confirmar Pagos Directo a Banco</h1>
<!-- 
<p>
	Puedes opcionalmente usar el comparador(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	o <b>=</b>) al comienzo del texto de cada valor de busqueda para que la comparación se ejecute
</p>

<?php echo CHtml::link( MipHelper::t('Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pay-not-cash-info-grid',
	'type' => ' striped',
	'dataProvider'=>$model->review(),
	'filter'=>$model,
	'columns'=>array(
			array(
					'header' => MipHelper::t('ID'),
					'name'=>'number',
					'type'=>'text',
					'value'=>'$data->id',
					'htmlOptions' => array('style' => 'width: 50px; text-align: center;'),
					'filterHtmlOptions' => array('style' => 'width: 50px;  text-align: center;'),
					'headerHtmlOptions' => array('style' => 'width: 50px;  text-align: center;'),
			),
			array(
					'header' => MipHelper::t('Payer'),
					'name'=>'pay_id',
					'type'=>'text',
					'value'=>'MipHelper::getPayerNameByPayId($data->pay_id)',
			),
			array(
					'header' => MipHelper::t('Target Account'),
					'name'=>'bank_account_id',
					'type'=>'text',
					'value'=>'BizLogic::getBankAccountShortReference($data->bank_account_id)',
					'filter'=> BizLogic::listBankAccountsShorName(),
					'htmlOptions' => array('style' => 'width: 120px;text-align: center;'),
					'filterHtmlOptions' => array('style' => 'width: 120px;text-align: center;'),
			),
			array(
					'name'=>'type',
					'type'=>'text',
					'filter'=>MipHelper::getNotCashTypeList(),
					'value'=>'$data->type',
					'htmlOptions' => array('style' => 'width: 30px;'),
					'filterHtmlOptions' => array('style' => 'width: 30px;'),
			),
			array(
					'header' => MipHelper::t('Date'),
					'name'=>'pay_date',
					'type'=>'text',
					'value'=>'MipHelper::parseDateFromDb($data->pay_date)',
					'htmlOptions' => array('style' => 'width: 70px; text-align: right;'),
					'filterHtmlOptions' => array('style' => 'width: 70px;  text-align: right;'),
					'headerHtmlOptions' => array('style' => 'width: 70px;  text-align: center;'),
			),
			array(
					'header' => MipHelper::t('Source Bank'),
					'name'=>'source_bank_id',
					'type'=>'text',
					'filter'=> CHtml::listData( MipHelper::getBankListUserInTransfer(), 'id', 'name'),
					'value'=>'($bank_source_id=MipHelper::getBankName($data->source_bank_id))?$bank_source_id:MipHelper::t("")',
					'htmlOptions' => array('style' => 'width: 100px; text-align: right;'),
					'filterHtmlOptions' => array('style' => 'width: 100px;  text-align: right;'),
					'headerHtmlOptions' => array('style' => 'width: 100px;  text-align: center;'),		
			),
			array(
					'header' => MipHelper::t('Number'),
					'name'=>'number',
					'type'=>'text',
					'value'=>'BizLogic::getNotCashInfoShortNumber( $data->number )',
					'htmlOptions' => array('style' => 'width: 120px; text-align: right;'),
					'filterHtmlOptions' => array('style' => 'width: 120px;  text-align: right;'),
					'headerHtmlOptions' => array('style' => 'width: 120px;  text-align: center;'),
			),
			array(
					'name'=>'value',
					'type'=>'text',
					'value'=>'MipHelper::formatCurrency($data->value)',
					'htmlOptions' => array('style' => 'width: 100px; text-align: right;'),
					'filterHtmlOptions' => array('style' => 'width: 100px;  text-align: right;'),
					'headerHtmlOptions' => array('style' => 'width: 50px;  text-align: center;'),
			),
			array(
					'header' => MipHelper::t('Checked'),
					'name'=>'checked',
					'type'=>'text',
					'filter'=>array(
									''=>MipHelper::t(' - '),
									'1'=>MipHelper::t('Yes'),
									'0'=>MipHelper::t('No'),
							),
					'value'=>'MipHelper::showYesNo($data->checked)',
					'htmlOptions' => array('style' => 'width: 50px; text-align: center;'),
					'filterHtmlOptions' => array('style' => 'width: 50px;'),

			),			
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update'=>array(
						'options'=>array(
								'target'=>'blank',
						),
					),
				),
				'htmlOptions' => array('style' => 'width: 50px;'),
			),
	),
)); ?>
