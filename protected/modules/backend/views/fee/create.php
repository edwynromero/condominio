<?php
$this->breadcrumbs=array(
	'Fees'=>array('index'),
	'Create',
);

$this->menu = MipHelper::getMenuToCreate($model); 

?>

<h1>Create Fee</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>