<?php
	$this->breadcrumbs=array(
		'People'=>array('index'),
		$model->id,
	);

	$this->menu = CMap::mergeArray( array(
		array('label'=>MipHelper::t('Manage Phones'),'url'=>array('//backend/personPhone/admin', 'person_id'=>$model->id)),
		array('label'=>MipHelper::t('Manage Emails'),'url'=>array('//backend/personEmail/admin', 'person_id'=>$model->id)),
	) ,MipHelper::getMenuToView($model));
	
	$owners = Owner::model()->findAll("person_id = :person_id", array(":person_id"=> $model->id));
	if( count($owners) > 0 )
	{
		$this->menu[] = array('label'=>MipHelper::t('Locations'),'url'=>array('//backend/owner/admin', 'person_id'=>$model->id));
	}	

?>

<h1><?php echo MipHelper::t("View Person")?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'full_name',
		array(
				'name'=>'identity_code',
				'type'=>'text',
				'value'=>$model->identity_type . "-" . $model->identity_code,
		),
		array(
				'name'=>'active',
				'type'=>'text',
				'value'=>MipHelper::showYesNo( $model->active ),
		),
		'inactive_description',
		array(
				'name'=>'group_person_id',
				'type'=>'html',
				'value'=>$model->group_person_id?MipHelper::getGroupPersonName( $model->group_person_id ):'<span class="null">'.MipHelper::t("Don't assigned").'</span>',
		),
),
)); ?>
