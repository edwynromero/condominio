<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $form TbActiveForm */
/* @var $this FixPayController */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
)); 

$search_button_label = "Select Location";
$search_button_value = "select-location";

?>
<?php
$this->breadcrumbs=array(
	'Fix Pays'=>array('index'),
	'Process Owner Location',
);

?>

<h1><?php echo MipHelper::t("Fix Bind Fee to Pay for Owner");?></h1>
<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div id="select-location"  class="span3">
                <?php if( is_null($model->location_id) ): ?>
                    <?php         
                        echo $form->select2Row($model,'location_id', array( 'data' => CHtml::listData($locations, "id", "code"), ),array(''=>'','style'=>'margin-bottom:200xmen;')); 
                    ?>   
                <?php else: ?>
                    <?php         
                        echo $form->hiddenField($model,'location_id'); 
                        echo $form->label($model, 'location_id');
                        echo CHtml::textField("location_name", $location->code, array("disabled"=>"disabled"));
                    ?>
                <?php endif; ?>
            </div>
        <?php if( count($persons) > 0 ): ?>
            <div id="select-person" class="span3">
                <?php         
                    echo $form->select2Row($model,'person_id', array( 'data' => CHtml::listData($persons, "id", "fullNameListDNI")), array( 'htmlOptions'=>array('id' => 'xxx') ) ); 
                    if( is_null($model->person_id) )
                    {
                        $search_button_label = "Select Owner";
                    }
                    else{
                        $search_button_label = "Change Owner";
                    }
                    
                    $search_button_value = "select-person";
               ?>  
            </div>
        <?php endif; ?>
            <div class="span4">
                <br>
                <?php
                    $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'type'=>'button',
                            'label'=>MipHelper::t($search_button_label),
                            'htmlOptions'=>array('value'=>'select-person', 'name'=>'operation'), )
                    );
                    $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'type'=>'button',
                            'label'=>MipHelper::t("Clear All"),
                            'htmlOptions'=>array('value'=>'clear-all', 'name'=>'operation'), )
                    );
                ?>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span9">
                <br>
                <?php if( !is_null($person) ): ?>
                <table class="table table-striped">
                    <tr>
                        <td>Parcela</td>
                        <td>Propietario</td>
                        <td>Cuotas Enlazadas</td>
                        <td>Cuotas no Enlazadas</td>
                        <td>Cuotas Enlazadas x Otros</td>
                    </tr>
                    <tr>
                        <td><?php echo $location->code ?></td>
                        <td><?php echo $person->fullNameListDNI ?></td>
                        <td><?php echo $feeds_bind_count ?></td>
                        <td><?php echo $feeds_not_bind_count ?></td>
                        <td><?php echo $feeds_bind_others ?></td>
                    </tr>
                </table>
                 <?php endif; ?>
            </div>
        </div>
<?php if($show_process_result): ?>
        <div class="row-fluid">
            <div class="span9">
                <?php if($process_result == FixPayController::PROCESS_SUCESS ): ?>
                    <div class="alert alert-block alert-success fade in">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4 class="alert-heading"><?php echo MipHelper::t("Process Sucessfull") ?>!</h4>
                        <p><?php echo MipHelper::t("You can check de State Account in this Button") ?>.</p>
                        <p style="text-align: right">
                          <a class="btn btn-success" href="<?php echo $this->createUrl("//site/downloadAccountState", array("location_id"=>$model->location_id)) ?>" target="blank"><?php echo MipHelper::t("Account State") ?></a>
                        </p>
                    </div>
                <?php elseif( $process_result == FixPayController::PROCESS_CANT_EXECUTE ): ?>

                    <div class="alert alert-block alert-warning fade in">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4 class="alert-heading"><?php echo MipHelper::t("Process can't Executed") ?>!</h4>
                        <p><?php echo MipHelper::t("The Location is disabled for this process.  Possible cause: You have no payments or owners assigned. Contact to System Administrator") ?>.</p>
                    </div>
                <?php else: ?>

                    <div class="alert alert-block alert-error fade in">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4 class="alert-heading"><?php echo MipHelper::t("Process Fail") ?>!</h4>
                        <p><?php echo MipHelper::t("Please take a ScreenShot and contact to System Administrator") ?>.</p>
                    </div>
                
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="row-fluid">
            <?php if( is_null($model->person_id) ): ?>
                <div class="span9">
                    <div id="process_location_form_resume" class="well well-large">
                        <span class="info"><?php  echo MipHelper::t("You must select a Location, and then an Owner, to begin the process of automatically linking the Condominium Fee Payments") ?>.</span>
                    </div>
                </div>
            <?php else: ?>
                
            
                <div class="span9">
                    <div id="process_location_form_resume" class="well well-large">
                        <?php echo $form->hiddenField($model, "last_pay_id") ?>
                        <?php
                            $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType'=>'submit',
                                    'type'=>'primary',
                                    'label'=>MipHelper::t("Process Bind Fee to Pay"),
                                    'htmlOptions'=>array('class'=>'align-right','value'=>'process-bind-fee-to-pay', 'name'=>'operation'), )
                            );
                        ?>                    
                    </div>
                </div>        
            <?php endif; ?>
        </div>
        
<?php
$this->endWidget(); 
