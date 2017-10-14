<?php
/* @var $this AccountingMoveLineController */
/* @var $model AccountingMoveLine */
/* @var $form TbActiveForm */
?>
<div class="form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'accounting-move-line-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <?php echo MipHelper::getHtmlFieldRequiered(); ?>
    <div class="row-fluid">
        <div class="span3">
            <?php echo $form->labelEx($model,'accounting_period_id'); ?>
            <?php echo $form->dropDownList($model, 'accounting_period_id', GxHtml::listDataEx( AccountingHelper::getPeriodList( $accountingMove->date_at  ) ), array('style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'accounting_period_id'); ?>
        </div>
        <div class="span2">
            <?php echo $form->datepickerRow($model, 'date_at',
                    array(
                        'options'=>array(  'format' => 'dd/mm/yyyy', 'weekStart'=> 1, 'forceParse'=>true, 'autoclose' => true,'todayBtn'=>true, 'minViewMode', 'endDate' => 'js:setEndDate()', 'startDate' => 'js:setBeginDate()'),
                    )
                );
            ?>
        </div>
        <div class="span6" >
                <div class="row-fluid">
                    <div class="span11" >
                        <?php echo $form->labelEx($model,'accounting_account_id'); ?>
                        <?php echo $form->select2Row($model,'accounting_account_id', array(
                                'data' => GxHtml::listDataEx(AccountingAccount::findAllAccountNotViews(), "id", "codeWithLabel"),
                            'htmlOptions'=>array('style'=>'width:100%;')
                            ),array(''=>'', 'label'=>false)  ); ?>
                        <?php echo $form->error($model,'accounting_account_id'); ?> 
                    </div>
                    <div class="span1" >
                       <?php $this->widget('bootstrap.widgets.TbButton', array(
                                            'type'=>'default',
                                            'label'=> AccountingHelper::t("+"),
                                            'url' =>  $this->createAbsoluteUrl("//backend/accountingAccount/createAtMoveLineForm", array( "id" => $model->isNewRecord? $model->accounting_move_id : $model->id, "source" => $model->isNewRecord ? "move":"moveline" ) ),
                                            'htmlOptions'=>array('style'=>'margin-top:26px;margin-left:-9px;','class' => 'btn-small'), )
                                    ); ?>
                    </div>
                </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3" >
            <div class="row-fluid">
                <div class="span6" style="padding-top: 20px;"> 
                    <label class="radio inline">
                      <?php 
                        echo  $form->radioButton($model,'isCredit', array("value"=>"1", "uncheckValue" =>null,)); 
                        echo AccountingHelper::t("Credit"); 
                      ?>
                    </label> 
                </div>
                <div class="span6" style="padding-top: 20px;"> 
                    <label class="radio inline">
                      <?php 
                        echo  $form->radioButton($model,'isCredit', array("value"=>"0", "uncheckValue" => null)); 
                        echo AccountingHelper::t("Debit"); 
                      ?>
                    </label> 
                </div>
            </div>
            <div class="row-fluid"> 
                <div class="span12">
                    <?php echo $form->error($model,'debt'); ?>
                </div>
            </div>
        </div>
        <div class="span2" >
            <?php echo $form->labelEx($model,'amount'); ?>
            <?php echo $form->textField($model, 'amount', array('style'=>'')); ?>
            <?php echo $form->error($model,'amount'); ?>
        </div>
        <div class="span5" >
            <?php echo $form->labelEx($model,'label'); ?>
            <?php echo $form->textField($model, 'label', array('style'=>'width:100%;')); ?>
            <?php echo $form->error($model,'label'); ?>
        </div>
    </div> 
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? MipHelper::t( 'Create'): 'Save', array('class'=>'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php 
    $periodList = AccountingHelper::getPeriodList(  $accountingMove->date_at, array("id","`to`") );
    $list = array();
    foreach($periodList as $period ){
        $list[$period->id] = array("year" => MipHelper::parseYearDateFromDb($period->to), "month" => MipHelper::parseMonthDateFromDb($period->to) - 1, "day" => MipHelper::parseDayDateFromDb($period->to));
    }
    $jsPeriodList = json_encode( $list );
    
    $beginDate = array("year" => MipHelper::parseYearDateFromDb(  $accountingMove->date_at ), "month" => MipHelper::parseMonthDateFromDb(  $accountingMove->date_at ) - 1, "day" => MipHelper::parseDayDateFromDb(  $accountingMove->date_at ));
    $jsBeginDate = json_encode( $beginDate );
?>
<script type="text/javascript">
    
    /**
     * 
     * @returns {Date}
     */
    function setEndDate(){
        var periodList = <?php echo $jsPeriodList; ?>;
        var lapseDateJson = periodList[$('#AccountingMoveLine_accounting_period_id').val() ];
        var lapseDate =  new Date( lapseDateJson.year, lapseDateJson.month, lapseDateJson.day );
        return lapseDate >= new Date() ? new Date() : lapseDate;
    }
    
    
    /**
     * 
     * @returns {Date}
     */
    function setBeginDate(){
        var beginDate = <?php echo $jsBeginDate; ?>;
        var result =  new Date( beginDate.year, beginDate.month, beginDate.day );
        return result;
    }

</script>