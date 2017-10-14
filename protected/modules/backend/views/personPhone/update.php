<?php
$this->breadcrumbs=array(
	'Person Phones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>MipHelper::t('List Phones'),'url'=>array('index', 'person_id'=>$person_id )),
	array('label'=>MipHelper::t('Create Phone'),'url'=>array('create', 'person_id'=>$person_id )),
	array('label'=>MipHelper::t('View Phone'),'url'=>array('view','id'=>$model->id, 'person_id'=>$person_id )),
	array('label'=>MipHelper::t('Manage Phone'),'url'=>array('admin', 'person_id'=>$person_id )),
	);
	?>

	<h1><?php echo MipHelper::t('Update Phone')?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'person_id'=>$person_id )); ?>