<?php
$this->breadcrumbs=array(
	'Person Phones'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PersonPhone','url'=>array('index', 'person_id' => $person_id )),
array('label'=>'Manage PersonPhone','url'=>array('admin', 'person_id' => $person_id )),
);
?>

<h1><?php echo MipHelper::t("Create Phone")?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'person_id' => $person_id )); ?>