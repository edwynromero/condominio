<?php
$this->breadcrumbs=array(
	MipHelper::t('Register Requests')=>array('index'),
	$request->id,
);

$this->menu=array(
	array('label'=>MipHelper::t('List RegisterRequest'),'url'=>array('index')),
	array('label'=>MipHelper::t('Create RegisterRequest'),'url'=>array('create')),
	array('label'=>MipHelper::t('Update RegisterRequest'),'url'=>array('update','id'=>$request->id)),
	array('label'=>MipHelper::t('Manage RegisterRequest'),'url'=>array('admin')),
);
?>

<h1><?php echo MipHelper::t("Process Register Request")?>  #<?php echo $request->id; ?></h1>

<div class="row-fluid">
	<div class="span6">
		<div class="alert alert-success">
			<h2>El resultado del Registro ha sido Exitoso</h2>
			<p>
				El usuario ha sido exitosamente, si desea notificarle que el registro fue exitoso, puede hacer click aquí.
			</p>
		</div>
	</div>
</div>
