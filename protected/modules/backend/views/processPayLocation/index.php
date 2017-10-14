<?php
$this->breadcrumbs=array(
        MipHelper::t('Process Payment to Location')=>array('index'),
);

$this->menu = array(
                    array('label'=> MipHelper::t('Process Payment to Location') ,'url'=>array('index')),
                );
?>

<h1><?php echo MipHelper::t('Process Payment to Location')?></h1>

<?php 
/* @var $form TbActiveForm */
/* @var $this Controller */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'process-pay-location-form',
        'enableAjaxValidation'=>false,
)); ?>

<?php echo MipHelper::getHtmlFieldRequiered() ?>

<?php echo $form->errorSummary($person); ?>
        <div class="row-fluid">
            <div class="span12" style="margin-bottom:10px;">
                <?php 
                $criteria = new CDbCriteria();
                $criteria->order = "first_name ASC, last_name ASC, full_name ASC";
                echo $form->select2Row($person,'person_id', array('data' => CHtml::listData(Person::model()->findAll($criteria), "id", "FullNameList"), "options"=>array( 'placeholder' => MipHelper::t('Select a Person'),'label'=>'Payer'))); 
                ?>			
                <?php echo $form->error($person, 'person_id'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <label for="Location_id" class="required">Parcela <span class="required">*</span></label>
                <select class="span3" name="Location[id]" id="Location_id">
                        <option value=""><?php echo MipHelper::t('Select a Location'); ?></option>
                </select>   
            </div>
        </div>
<div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'primary',
                        'label'=>'Procesar Pagos x Cuotas',
                )); ?>
</div>

<?php $this->endWidget(); ?>
