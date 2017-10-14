<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(
			'name'=>'mip_fee_schedule_id',
			'type'=>'text',
			'value'=>MipHelper::getFeeTypeName($model->fee_type_id)
		),
		'name',
		array(
				'name'=>'begin_date',
				'type'=>'text',
				'value'=>MipHelper::parseDateFromDb($model->begin_date)
		),
		array(
				'name'=>'end_date',
				'type'=>'text',
				'value'=>MipHelper::parseDateFromDb($model->end_date)
		),
		array(
				'name'=>'value',
				'type'=>'text',
				'value'=>MipHelper::formatCurrency($model->value)
		),
),
)); ?>
