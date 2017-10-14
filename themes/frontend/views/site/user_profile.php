<?php
    /* @var $this SiteController */
    /* @var $user User */
    /* @var $person Person */
    /* @var $person_email PersonEmail */
    /* @var $person_phone PersonPhone */
?>
<h3><?php echo MipHelperFront::t("User Profile");  ?></h3>
<hr>
<div id="user_profile_view" class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("User"); ?>:</label>
            </div>
            <div class="span4">
                <span><strong><?php echo $user->name ?></strong></span>
            </div>
        </div>
        <?php if( $person->isNotCompany ): ?>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("First Name"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $person->first_name ?></span>
            </div>
        </div>   
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Last Name"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $person->last_name ?></span>
            </div>
        </div>  
        <?php else: ?>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Organization"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $person->full_name ?></span>
            </div>
        </div>   
        <?php endif; ?>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Identity"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo $person->identity_type ?> - <?php echo $person->identity_code ?></span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Email"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo empty($person_email) ? MipHelperFront::t("Undefined"):$person_email->email; ?></span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label><?php echo MipHelperFront::t("Phone"); ?>:</label>
            </div>
            <div class="span4">
                <span><?php echo empty($person_phone) ? MipHelperFront::t("Undefined"): "(" . $person_phone->prefix . ") " . $person_phone->number . "&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<i>" . MipHelper::getPhoneTypeName($person_phone->type) . "</i>" ; ?></span>
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span6">  
                <?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>                    
                    <div class="alert alert-success text-center"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo  $message ?> 
                    </div>                     
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="well">
    <div class="row-fluid">
        <div class="span12 text-center">
            <a href="<?php echo $this->createUrl("//site/editProfile") ?>" class="btn btn-success"><?php echo MipHelperFront::t("Edit Profile") ?></a>
        </div>
    </div>
</div>