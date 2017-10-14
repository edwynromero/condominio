<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Change Password';
$this->breadcrumbs=array(
	'Changing Password',
);
?>
<div class="row-fluid">
		<?php if( $passwordChanged == false ): ?>
			<?php if($tokenValid):?>
	    	<div class="span4 offset3">
	    		<div class="alert">
	    			<button type="button" class="close" data-dismiss="alert">&times;</button>
	    			<div class="row-fluid">
	    				<div class="span12"><h3>IMPORTANTE:</h3></div>
	    			</div>
	    			<div class="row-fluid">    				
	    				<div class="offset1 span10 text-left">Su nueva contraseña debe:</div>
	    			</div>
	    			<div class="row-fluid">    				
	    				<div class="offset2 span10 text-left">- Poseer entre 6 y 12 caracteres.</div>
	    			</div>
	    			<div class="row-fluid">    				
	    				<div class="offset2 span10 text-left">- Tener al menos un caracter en minúsculas.</div>
	    			</div>
	    			<div class="row-fluid">      				
	    				<div class="offset2 span10 text-left">- Tener al menos un caracter en mayúsculas.</div>
	    			</div>
	    			<div class="row-fluid">  
	    				<div class="offset2 span10 text-left">- Tener al menos un dígito.</div>
	    			</div>
	    		</div>
	    	</div>	
			<?php else:?>
	    	<div class="span4 offset3">
	    		<div class="alert alert-error">
	    			<div class="row-fluid">
	    				<div class="span12">
	    					<h3>SOLICITUD INVÁLIDA:</h3>
	    				</div>
		    			<div class="row-fluid">
		    				<div class="span12">
			    				<p>La URL utilizada para el cambio de password ha vencido, o no es correcta.</p>
			    				<p>Por favor, revise la misma (si la copió y pegó) e inténtelo de nuevo.</p>
			    				<p>Si está vencida, deberá solicitar la recuperaciónde las contraseña nuevamente.</p>
		    				</div>
		    			</div>    	    							
	    			</div>
	    		</div>
	    	</div>		
			<?php endif;?>
		<?php else:?>
			<div class="span4 offset3"></div>
		<?php  endif; ?>
	
    <div id="login_form_section" class="span4  img-rounded">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"Cambiando el Password",
		'htmlOptions'=>array( 'style'=>'borders: 0px;')
	));
	
?>
    	<?php if ($passwordChanged) :?>
    		<br>
    		<div class="row-fluid">
    			<div class="span1"></div>
		    	<div class="span10">
		    		<div class="alert alert-success  alert-block">
		    			<div class="row-fluid">
		    				<div class="span12">
		    					<h3>Solicitud Exitosa:</h3>
		    				</div>
				        	<?php if($tokenValid):?>
							<div class="row-fluid">
								<div class="span12">Recuerde que su usuario es:  <span class="label label-success" style="font-size:medium;"><?php echo $username; ?></span></div>
							</div>
							<?php endif;?>		    				
			    			<div class="row-fluid">
			    				<div class="span12">
				    				<p>El cambio de Contraseña fué realizado con éxito.  El sistema lo redireccionará automáticamente para que ingrese con su usuario y password, en aproximadamente <strong>diez (10) segundos</strong>.</p>
				    				<p> Si no desea esperar, puede hacer click en el siguiente Link:  </p>
				    				<p><h4><?php echo  CHtml::link(MipHelper::t('Go to Login'), $this->createAbsoluteUrl('//site/login', array('username'=>$username) ))?></h4></p>
			    				</div>
			    			</div>    	    							
		    			</div>
		    		</div>
		    	</div>	
		    	<div class="span1"></div>
	    	</div>
	    	<br>
    	<?php  else:?>
       <p class="note"><?php echo MipHelper::t("Please fill out the following form for change password")?>:</p>
    
		    <div class="form">
		    <?php $form=$this->beginWidget('CActiveForm', array(
		        'id'=>'change-password-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true,
		        ),
		    )); ?>
		        <p class="note-required"><?php echo MipHelper::t("Fields with");?><span class="required">*</span> <?php echo MipHelper::t("are required");?>.</p>
		        
		        <?php if($tokenValid):?>
				<div class="row-fluid">
					<div class="span12">Recuerde que su usuario es:  <span class="label label-warning" style="font-size:medium;"><?php echo $username; ?></span></div>
				</div>
				<?php endif;?>
				
		        <div class="row-fluid">
		            <?php echo $form->labelEx($model,'password', array('style'=>'color:#c09853;')); ?>
		            <?php echo $form->passwordField($model,'password'); ?>
		            <?php echo $form->error($model,'password'); ?>
		        </div>
		    
		        <div class="row-fluid">
		            <?php echo $form->labelEx($model,'password_confirm', array('style'=>'color:#c09853;')); ?>
		            <?php echo $form->passwordField($model,'password_confirm'); ?>
		            <?php echo $form->error($model,'password_confirm'); ?>
		        </div>
		    
		        <div class="row-fluid buttons">
		        	<div class="span3">
		        		<?php echo CHtml::link( MipHelper::t('Recover Password'), $this->createAbsoluteUrl("//site/forget"),array('class'=>'text-warning forget-link')); ?>
		        	</div>
		        	<div class="span6" >
		        	   <?php echo CHtml::submitButton(MipHelper::t('Change Password'),array('class'=>'btn btn btn-warning')); ?>
		        	</div>
		        	<div class="span3"></div>   
		        </div>   
		    <?php $this->endWidget(); ?>
		    </div><!-- form -->	         	
    	<?php  endif;?>
<?php $this->endWidget();?>
    </div>
</div>