<?php 
/* @var $model Pay */

$valueNotCash = $model->getValueNotCash();

$this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
			'name'=>'person_id',
			'type'=>'raw',
			'value'=>MipHelper::createPersonLinkById($model->person_id),
		),
		array(
			'name'=>'pay_date',
			'type'=>'text',
			'value'=>MipHelper::parseDateFromDb($model->pay_date),
		),
		array(
			'name'=>'value_cash',
			'type'=>'text',
			'value'=>MipHelper::formatCurrency($model->value_cash),
		),
		array(
			'name'=>MipHelper::t('Not Cash'),
			'type'=>'text',
			'value'=>MipHelper::formatCurrency($valueNotCash['checked']),
		),
),
)); ?>
