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

<h1><?php echo MipHelper::t("Begin Process Register Request")?>  #<?php echo $request->id; ?></h1>

<div class="row-fluid">
	<div class="span6">
		<div class="row-fluid">
			<div class="span12">
				<h4>Datos Solicitud</h4>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<?php 
				
				$columns = array('identity_type',
								 'identity_code',);
				
				if( Person::checkIsNotCompany( $request->identity_type ) )
				{
					$columns = CMap::mergeArray($columns, array('first_name','last_name',));
				}
				else
				{
					$columns = CMap::mergeArray($columns, array('full_name'));
				}
				
				$columns = CMap::mergeArray($columns, 	array(					
																array(
																	'name'=>'phone_type',
																	'type'=>'text',
																	'value'=>MipHelper::getPhoneTypeName($request->phone_type),
																),
																'phone_prefix',
																'phone_number',
																'person_email',));
				
				
				$this->widget('bootstrap.widgets.TbDetailView',array(
					'data'=>$request,
					'attributes'=>$columns
				)); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="row-fluid">
			<div class="span12">
				<h4>Datos Existentes</h4>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<?php 
				$columns = array('identity_type','identity_code',);
				
				if(  $person->IsNotCompany )
				{
					$columns = CMap::mergeArray($columns, array('first_name','last_name',));
				}
				else
				{
					$columns = CMap::mergeArray($columns, array('full_name'));
				}
				
				$columns = CMap::mergeArray($columns, 	array(
															array(
																'name'=>'phone_type',
																'type'=>'text',
																'value'=>empty($person_phone)?'': MipHelper::getPhoneTypeName($person_phone->type),
															),
															array(
																'name'=>'phone_prefix',
																'type'=>'text',
																'value'=>empty($person_phone)?'':$person_phone->prefix,
															),
															array(
																'name'=>'phone_number',
																'type'=>'text',
																'value'=>empty($person_phone)?'':$person_phone->number,
															),
															array(
																'name'=>'person_email',
																'type'=>'text',
																'value'=>empty($person_email)?'':$person_email->email,
															),
														));
				
				$this->widget('bootstrap.widgets.TbDetailView',array(
					'data'=>$person,
					'attributes'=>$columns	
				)); ?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php echo TbHtml::beginForm( array('//backend/registerRequest/processRequest', 'id'=>$request->id) ); ?>
		<?php echo TbHtml::submitButton("Process Request with New Information", array('class'=>'btn-primary')); ?>
		<?php echo TbHtml::endForm();?>
	</div>
	<div class="span6">
	</div>
</div>