<?php
$this->breadcrumbs=array(
	'Pay Not Cash Infos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	
	$this->menu=array(
			array('label'=>MipHelper::t('Admin Pay'),'url'=>array('//backend/pay/admin')),
			array('label'=> MipHelper::t('Create Pay'),'url'=>array('//backend/pay/create')),
	);
	?>

	<h1>Actualizar Pago Directo Banco -  #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>