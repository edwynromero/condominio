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
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'process-register-request-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="row-fluid">
	<div class="span6">
		<div class="row-fluid">
			<div class="span12">
				<h4>Datos Solicitud</h4>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<?php	if( Person::checkIsNotCompany( $request->identity_type ) ): ?>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('first_name')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->first_name); ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('last_name')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->last_name); ?></div>
				</div>
				<?php else:?>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('full_name')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->full_name); ?></div>
				</div>
				<?php endif; ?>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('identity_type')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->identity_type); ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('identity_code')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->identity_code); ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('person_email')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->person_email); ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4"><b><?php echo CHtml::encode($request->getAttributeLabel('user_name')); ?>:</b></div>
					<div class="span8"><?php echo CHtml::encode($request->user_name); ?></div>
				</div>			
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="row-fluid">
			<div class="span12">
				<div class="alert" style="background-color: #EFEFEF;">
					<div class="row-fluid">
						<div class="span12">
							<h4 class="info">Parcelamiento en la Solicitud</h4>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<?php  $request_locations = split(',', $request->locations); ?>
							<?php foreach( $request_locations as $request_location ):?>
							<?php echo TbHtml::badge($request_location, array('class'=>'badge-warning'));?>
							<?php endforeach;?>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">									
							<h5>El parcelamiento de la Solicitud se usará por defecto y reemplazará al existente.</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="alert">
					<div class="row-fluid">
						<div class="span12">
							<div class="row-fluid">
								<div class="span12">
									<h4>Parcelamiento Enlazado Actualmente</h4>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span12">
									<?php  $request_locations = split(',', $request->locations); ?>
									<?php foreach( $request_locations as $request_location ):?>
									<?php echo TbHtml::badge($request_location, array('class'=>'badge-warning'));?>
									<?php endforeach;?>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span1"><h5><?php echo TbHtml::checkBox('not_change_location',false)?></h5></div>
								<div class="span11">									
									<h5>Deseo matener el parcelamiento existente y hacer los cambios posteriormente.</h5>
								</div>
							</div>
						</div>		
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if( !empty($message_fail) ):?>
<div class="row-fluid">
	<div class="span12">
		<div class="alert alert-error">
			<h2>Error procesando la solicitud</h2>
			<p><?php echo $message_fail ?></p>
		</div>
	</div>	
</div>
<?php endif;?>
<div class="row-fluid">
	<div class="span8">
		<div class="row-fluid">
			<div class="span8">
				<label for="confirm"><?php echo TbHtml::checkBox('confirm',false)?>Confirmo que los Datos fueron Verificados</label>
			</div>
		</div>
	</div>
	<div class="span6">
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php echo TbHtml::submitButton("Process Request with New Information", array('class'=>'btn-primary', 'onclick'=>'if( !$("confirm").checked ) alert("Debe chequear")')); ?>
	</div>
	<div class="span6">
	</div>
</div>
<?php $this->endWidget(); ?>