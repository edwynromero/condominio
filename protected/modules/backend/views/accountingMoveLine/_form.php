<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'accounting-move-line-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
    
   
        <?php echo MipHelper::getHtmlFieldRequiered(); ?>
        
   

	<?php if(!isset($accountingMoveLine)){
		$accountingMoveLine = $model->accounting_move_id;
		} ?>

        
	<div class="row-fluid row-fluid well well-small" style='width:45%;'>
		<?php echo $form->labelEx($model,'accounting_move_id'); ?>
            
		<?php echo $form->hiddenField($model, 'accounting_move_id', array('value'=>$accountingMoveLine)); ?>
                 
            
           
            <div class="span2" style='width:100%;'>
                
                <?php $accountingMove=  AccountingMove::model()->find('id=:id',array(':id'=>$accountingMoveLine)) ?>
                
                <?php echo $form->label($model,$accountingMove->label); ?>
            </div>
		<?php echo $form->error($model,'accounting_move_id'); ?>
            
	</div>

        
        
        <div class="row">
                        <?php echo $form->datepickerRow($model, 'date_at',
		            array(
		                    'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode'),
							'htmlOptions'=>array( 'readonly'=>'readonly'),

		            )
		        );
			?>
        </div> 
    
    
    
    
        
    <div class="row">
		<?php echo $form->labelEx($model,'accounting_period_id'); ?>
        <?php echo $form->dropDownList($model, 'accounting_period_id', GxHtml::listDataEx(AccountingPeriod::model()->findAllAttributes(array('id','label'), false)), array('style'=>'width:30%;')); ?>
		<?php echo $form->error($model,'accounting_period_id'); ?>
	</div>
    
    
       
    

	
   
                
            
	<div class="row-fluid">
       

	<div class="span1">
            
            
            <?php echo $form->labelEx($model,'debt'); ?>  
            
		<?php echo $form->checkBox($model,'debt',array('value'=>1)); ?>
            
           
            
		
                 
		<?php echo $form->error($model,'debt'); ?>
           
	</div>
            
            
        <div class="span2">
                
            <?php echo $form->labelEx($model,'credt', array('style'=>'position:relative; left:-20%;')); ?>
            
            <?php echo $form->checkBox($model,'credt',array('value'=>1,'style'=>'position:relative; left:-20%;')); ?>
		
            
		
		
            
	</div>
            
          
           
            
        <div class="span2">
		<?php echo $form->labelEx($model,'balance', array('style'=>'position:relative; left:-66%;')); ?>
		<?php echo $form->textField($model,'balance',array('size'=>10,'maxlength'=>10,"readonly"=>"readonly", 'style'=>'position:relative; left:-66%;')); ?>
		<?php echo $form->error($model,'balance'); ?>
	</div>   
        </div>
    
    
        
    
         <div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
                <?php echo $form->textField($model, 'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>
    
    

        <div class="row">
		<?php echo $form->labelEx($model,'accounting_account_id'); ?>
                <?php echo $form->dropDownList($model, 'accounting_account_id', GxHtml::listDataEx(AccountingAccount::findAllWithoutChildrens()),array('style'=>'width:33%')); ?>
		<?php echo $form->error($model,'accounting_account_id'); ?>
	</div>

	

	
	<div class="row">
		<?php echo $form->labelEx($model,'reconciled'); ?>
		<?php echo $form->checkBox($model,'reconciled'); ?>
		<?php echo $form->error($model,'reconciled'); ?>
	</div> 
    
    
    <br>
    
    
        
        <br>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? MipHelper::t( 'Create'): 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

        
        <script>
                
        $("#AccountingMoveLine_debt").click(function(){
              if($("#AccountingMoveLine_debt").is(':checked')){
                $("#AccountingMoveLine_credt").prop('checked',false)
        }  
                
        })        
        
        $("#AccountingMoveLine_credt").click(function(){
                if($("#AccountingMoveLine_credt").is(':checked')){
                $("#AccountingMoveLine_debt").prop('checked',false)
        }
        })
        
        </script>
        
        
<?php $this->endWidget(); ?>

</div><!-- form -->