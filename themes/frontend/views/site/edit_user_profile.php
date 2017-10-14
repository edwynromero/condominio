<?php
    /* @var $this SiteController */
    /* @var $profileModel UserProfileForm */
    /* @var $form TbActiveForm */

    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'profile-user-form',
            'enableAjaxValidation'=>false,
    ));
?>
<h3><?php echo MipHelperFront::t("User Profile - Editing");  ?></h3>
<hr>
<div id="user_profile_view" class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("User"); ?>:</label>
            </div>
            <div class="span4">
                <span><strong><?php echo $profileModel->user_name ?></strong></span>
            </div>
        </div>
        <?php if( $profileModel->is_not_company ): ?>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("First Name"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $profileModel->first_name ?></span>
            </div>
        </div>   
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Last Name"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $profileModel->last_name ?></span>
            </div>
        </div>  
        <?php else: ?>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Organization"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $profileModel->full_name ?></span>
            </div>
        </div>   
        <?php endif; ?>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Identity"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $profileModel->identity ?></span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                 <label><?php echo MipHelperFront::t("Phone Type"); ?>:</label>
            </div>
            <div class="span4">
               <?php echo $form->dropDownList($profileModel, "phone_type",  MipHelper::getPhoneTypeList(), array("style"=>"width:95%;",'empty' => '- '.MipHelperFront::t('Select a option').' -')) ?>
            </div>
            <div class="span6">
               <?php echo $form->error($profileModel, "phone_type") ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Phone"); ?>:</label>
            </div>
            <div class="span1">
                <span><?php echo $form->textField($profileModel, "phone_prefix", array("style"=>"width:86%;") ) ?></span>
            </div>
            <div class="span3">
                <span><?php echo $form->textField($profileModel, "phone_number", array("style"=>"width:86%;") ) ?></span>
            </div>
            <div class="span6">
               <?php 
                if( $profileModel->hasErrors("phone_prefix") ) 
                {
                    echo $form->error($profileModel, "phone_prefix");
                }
                elseif( $profileModel->hasErrors("phone_number")  ) 
                {
                    echo $form->error($profileModel, "phone_number");
                }
               ?>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span2">
                <label for="email"><?php echo MipHelperFront::t("Email"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $form->textField($profileModel, "email", array("style"=>"width:90%;") ); ?></span>
            </div>
            <div class="span6">
               <?php echo $form->error($profileModel, "email") ?>
               <?php if( !$profileModel->hasErrors("email")) :?>
                <i class="text-warning"> Manteniendo el actual correo no necesita confirmar el mismo.</i>
               <?php endif;?> 
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label for="email_confirm"><?php echo MipHelperFront::t("Email Confirm"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $form->textField($profileModel, "email_confirm", array("style"=>"width:90%;") ); ?></span>
            </div>
            <div class="span6">
               <?php echo $form->error($profileModel, "email_confirm") ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label for="password_new"><?php echo MipHelperFront::t("Password New"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $form->passwordField($profileModel, "password_new", array("style"=>"width:90%;") ); ?></span>
            </div>
            <div class="span6">
               <?php echo $form->error($profileModel, "password_new") ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label for="password_confirm"><?php echo MipHelperFront::t("Password Confirm"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $form->passwordField($profileModel, "password_confirm", array("style"=>"width:90%;") );  ?></span>
            </div>
            <div class="span6">
               <?php echo $form->error($profileModel, "password_confirm") ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
            </div>
            <div class="span4">
                <span class="text-info">La nueva contraseña debe poseer entre 6 y 16 caracteres, tener al menos (1) un caracter en minúsculas, un (1) caracter mayúscula y al menos un (1) dígito. Ejemplo:  MiPass123.</span>
            </div>
        </div>
    </div>
</div>
<hr>
<div  id="user_profile_view"  class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span2">
                <label for="password"><?php echo MipHelperFront::t("Current Password"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $form->passwordField($profileModel, "password", array("style"=>"width:90%;") ); ?></span>
            </div>
            <div class="span6">
               <?php echo $form->error($profileModel, "password") ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">

            </div>
            <div class="span4">
                <span class="text-info"><trong>Para ejecutar los cambios debe utilizar la clave actual.</trong></span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">  
                <?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>                    
                    <div class="alert alert-danger text-center"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo  $message ?> 
                    </div>                     
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
<div class="well">
    <div class="row-fluid">
        <div class="span12  text-center">
            <a href="<?php echo $this->createUrl("//site/profile"); ?>" class="btn" style="color: #444;">Cancelar</a>
            <?php echo CHtml::submitButton(MipHelperFront::t("Send"), array('class'=>'btn btn-success', 'style'=>'width:90px;')); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>