<?php
/* @var $this AccountingMoveController */
/* @var $model AccountingMove */

$seatsGridButtonsTemplate = '{view}';
if( $model->status == $isMoveOpen ){
    $seatsGridButtonsTemplate = '{view}{update}{delete-not-ajax}';
}


$balance_total_css = "info";
$balance_total_label = "";
$balance_total_column = "";
    
if($balance_total > 0){
    $balance_total_css = "sucess";
    $balance_total_label = " + ";
    $balance_total_column = "(" . AccountingHelper::t("Credt") . ")";
}
else if($balance_total < 0){
    $balance_total_css = "warning";
    $balance_total_label = " - ";
    $balance_total_column = "(" . AccountingHelper::t("Debt") . ")";
}

$references = isset($references)?$references:array();
        
?>
<div class="row-fluid">
    <div class="span12">
        <?php

        $this->breadcrumbs=array(
            'Accounting Moves'=>array('index'),
            $model->id,
        );
        $this->menu=array(
            array('label'=> AccountingHelper::t('Create'), 'url'=>array('create')),
            array('label'=> AccountingHelper::t('Update'), 'url'=>array('update', 'id'=>$model->id)),
            array('label'=>  AccountingHelper::t('Delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
            array('label'=> AccountingHelper::t('List'), 'url'=>array('admin')),
        );
        ?>
        <div class="row-fluid">
            <div class="span6">
                <h1 ><?php echo AccountingHelper::t("Move") . "&nbsp;#" .$model->id; ?></h1>
            </div>
            <div class="span6" style="text-align: right;">
                <h1><?php echo AccountingJournal::model()->findByPk( $model->journal_id )->title ?></h1>
            </div>
        </div>
        <?php
            $this->renderPartial('detail',array(
            'model'=>$model,
            'balance_total' =>  $balance_total,
        )); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">
        <div class="row-fluid">
            <div class="span6">
                <?php  echo "<h3>". AccountingHelper::t('References')."</h3>";  ?>
            </div>
            <div class="span6">
                <?php 
                    if( $isMoveOpen ){
                        $this->widget('bootstrap.widgets.TbButton', array(
                                'type'=>'success',
                                'label'=> AccountingHelper::t("+"),
                                'url' => $this->createAbsoluteUrl("//backend/accountingMove/referenceAdd", array("id" => $model->id ) ),
                                'htmlOptions'=>array('style'=>'margin-top:15px;','class' => 'btn-small'), )
                        );
                    }
                ?>                 
            </div>
        </div>
    </div>  
</div>
<div class="row-fluid">
    <div class="span12">
       
        <div class="btn-toolbar" style="margin: 0;">
             <?php foreach( $references as $reference ): ?>
            <div class="btn-group">
                <button class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?= $reference->label ?>: #<?= $reference->value ?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?= $this->createAbsoluteUrl("//backend/accountingMove/referenceEdit", array("id" => $reference->id )); ?>">Edit</a></li>
                    <li><a href="<?= $this->createAbsoluteUrl("//backend/accountingMove/referenceDelete", array("id" => $reference->id )); ?>">Delete</a></li>
                </ul>
            </div>
            <?php  endforeach; ?>
        </div>
        
    </div>
</div>
<div class="row-fluid">
    <div class="span12">   
        <?php foreach(Yii::app()->user->getFlashes() as $key => $message) : ?>
        <div class="alert alert-block alert-<?php echo $key; ?> fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="alert-heading"><?php echo AccountingHelper::getTitleProcessMessage($key); ?></h4>
            <p><?php echo $message ?></p>
        </div>
        <?php endforeach;?>
    </div>
</div>
<div class="row-fluid">
    <div class="span1">
        <?php  echo "<h3>". AccountingHelper::t('Seats')."</h3>";  ?>
    </div>
    <div class="span6 text-left">
        <?php 
            if( $isMoveOpen ){
                $this->widget('bootstrap.widgets.TbButton', array(
                        'type'=>'success',
                        'label'=> AccountingHelper::t("+"),
                        'url' => $this->createAbsoluteUrl("//backend/accountingMove/seatAdd", array("id" => $model->id ) ),
                        'htmlOptions'=>array('style'=>'margin-top:15px;','class' => 'btn-small') ,
                        )
                );
            }
        ?> 
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
                'id'=>'accounting-move-line-grid',
                'type' => ' striped',
                'dataProvider'=>AccountingMoveLine::model()->searchAccountingMoveLineDetail($model->id),
                'htmlOptions'=>array("style"=>"padding:0px;;"),
                'columns'=>array(
                        'id',
                        array(
                          "header"=>  MipHelper::t("Date"),
                            "name"=> "date_at",
                            "value"=> function($data){
                                return MipHelper::parseDateFromDb($data->date_at) ;
                            },
                            "htmlOptions" => array(
                                "style" => "white-space: nowrap; width: 1%;",
                            ),

                        ),
                        array(
                          "header"=>  MipHelper::t("AccountingPeriod"),
                            "name"=> "accounting_account_id",
                            "value"=> function($data){
                                return AccountingPeriod::model()->find('id=:id', array(':id'=>$data->accounting_period_id));
                            },
                            "htmlOptions" => array(
                                "style" => "white-space: nowrap; width: 9%;",
                            ),

                        ),
                        array(
                            "header"=> MipHelper::t('AccountingAccount'),
                            "name"=>"accounting_account_id",
                            "value"=>function($data){

                                return AccountingAccount::model()->find('id=:id', array(':id'=>$data->accounting_account_id))->codeWithLabel;
                            },
                        ),  
                        array(
                            "header"=> AccountingHelper::t('Move Line Label'),
                            "name"=>"label",
                            "value"=>function($data){

                                return $data->label;
                            },
                        ),   
                        array(
                            "header"=> AccountingHelper::t('Conciliated'),
                            "name"=>"reconciled",
                            "value"=>function($data){

                                return MipHelper::getYesNoOptions()[$data->reconciled];
                            },
                            "htmlOptions" => array(
                                "style" => "white-space: nowrap; width: 1%;",
                            ),

                        ),           
                        array(
                            "header"=>  MipHelper::t("Debt"),
                            "name"=>"debt",
                            "value"=>function($data){
                                if ((float)$data->debt == 0.00){
                                        return "";
                                }else{
                                        return MipHelper::formatCurrency($data->debt, "");
                                }
                            },
                            "htmlOptions" => array(
                                "style" => "white-space: nowrap; width: 7%;",
                            ),
                            'footer' => null,
                        ),
                        array(
                            "header"=>  MipHelper::t("Credt"),
                            "name"=>"credt",
                            "value"=>function($data){
                                if ((float)$data->credt == 0.00){
                                        return "";
                                }else{
                                      return MipHelper::formatCurrency($data->credt, ""); 
                                }
                            },
                            "htmlOptions" => array(
                                "style" => "white-space: nowrap; width: 7%;",
                            ),
                        ),      
                    array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                            'template'=>$seatsGridButtonsTemplate,
                            'buttons'=>array(
                                'update'=>array(
                                        'url'=> 'Yii::app()->createUrl("//backend/accountingMove/seatUpdate", array("id" => $data->id) )',
                                ),
                                'view'=>array(
                                    'url'=> 'Yii::app()->createUrl("backend/accountingMove/seatView", array("id" => $data->id) )',
                                ),
                                'delete-not-ajax'=>array(
                                    'url'=> 'Yii::app()->createUrl("backend/accountingMove/seatDelete", array("id" => $data->id) )',
                                    'icon'=>'icon-trash',
                                ),
                            ),
                    ),

                ),
            ));  ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span4 offset8 text-right" >
        <div class="well">
            
            <div class="row-fluid">
                <div class="span6 text-right" >
                    <h4 class="text-success">Balance:</h4>
                </div>
                <div class="span6 text-right <?php echo $balance_total_css; ?>  " >
                    <h4><?php echo $balance_total_label . MipHelper::formatCurrency( abs($balance_total), "");  ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>