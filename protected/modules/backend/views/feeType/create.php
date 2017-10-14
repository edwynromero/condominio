<?php
$this->breadcrumbs=array(
	'Fee Types'=>array('index'),
	'Create',
);

$this->menu = MipHelper::getMenuToCreate($model);

?>

<h1>Create FeeType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>