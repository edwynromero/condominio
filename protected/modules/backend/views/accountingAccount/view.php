<?php

/* @var $model AccountingAccount */
/* @var $form TbActiveForm */
/* @var $this AccountingAccountController */


$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>  MipHelper::t('Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>  MipHelper::t('Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=> MipHelper::t('Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=> MipHelper::t('Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>


<h1><?php echo  GxHtml::encode($model->label()) . ': ' . $model->label; ?></h1>
<div class="row-fluid">
    <div class="span6">
            <?php $this->widget('bootstrap.widgets.TbDetailView', array(
                'data' => $model,
                'attributes' => array(
                                        'id',
                                        array(
                                            'label' => AccountingHelper::t( 'Parent Account' ),
                                            'name' => 'parent_account_id',
                                            'type' => 'raw',
                                            'value' => empty($model->parentAccount) ? MipHelper::getYesNoOptions()[ 0 ] : CHtml::link( $model->parentAccount, $this->createAbsoluteUrl("//backend/accountingAccount/view", array("id"=>$model->parentAccount->id))),
                                            ),
                                        array(
                                            'name' => 'type0',
                                            'type' => 'raw',
                                            'value' => $model->type0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->type0)), array('accountingAccountType/view', 'id' => GxActiveRecord::extractPkValue($model->type0, true))) : null,
                                            ),
                                        'code',
                                        'label',
                ),
            )); ?>   
    </div>
    <div class="span6">
            <?php $this->widget('bootstrap.widgets.TbDetailView', array(
                'data' => $model,
                'attributes' => array(
                                        array(
                                            'name' => 'created_at',
                                            'type' => 'raw',
                                            'value' => MipHelper::parseDateFromDb($model->created_at)
                                            ), 
                                        array(
                                            'name' => 'updated_at',
                                            'type' => 'raw',
                                            'value' => MipHelper::parseDateFromDb($model->updated_at)
                                            ),                                        
                                        array(
                                            'name' => 'deprecated',
                                            'type' => 'raw',
                                            'value' => MipHelper::getYesNoOptions()[ $model->deprecated ] 
                                            ),
                                        'note',

                ),
            )); ?> 
    </div>
</div>


<?php if($model->kind == AccountingAccountKind::defaultView()->key ):  ?>
    <?php $relatedModels = $model->getChilds()  ?>
    <?php if( count($relatedModels ) ):  ?>
        <div class="row-fluid">
            <div class="span6">
            <h2><?php echo AccountingHelper::t( 'Childs Accounts' ); ?></h2> 
            <?php
                echo GxHtml::openTag('ul');
                foreach( $relatedModels as $relatedModel) {
                    echo GxHtml::openTag('li');
                    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel, "codeWithLabel")), array('accountingAccount/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
                    echo GxHtml::closeTag('li');
                }
                echo GxHtml::closeTag('ul');
            ?>
            </div>
        </div>
    <?php endif; ?>
    <?php $relatedModels = $model->getBrothers()  ?>
    <?php if( count($relatedModels ) ):  ?>
        <div class="row-fluid">
            <div class="span6">
            <h2><?php echo AccountingHelper::t( 'Brothers Accounts' ); ?></h2> 
            <?php
                echo GxHtml::openTag('ul');
                foreach( $relatedModels as $relatedModel ) {
                    echo GxHtml::openTag('li');
                    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel, "codeWithLabel")), array('accountingAccount/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
                    echo GxHtml::closeTag('li');
                }
                echo GxHtml::closeTag('ul');
            ?>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="row-fluid">
        <div class="span11">
            <?php 
                /* @var $data AccountingMoveLine */
            
                $this->widget('bootstrap.widgets.TbGridView', array(
                    'id'=>'accounting-move-line-grid',
                    'type' => ' striped',
                    'dataProvider'=>AccountingMoveLine::model()->searchSeatsFromAccount($model->id, array(  'pageSize'=>5, )),
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
                              "header"=> AccountingHelper::t("Period"),
                                "name"=> "accounting_account_id",
                                "value"=> function($data){
                                    return AccountingPeriod::model()->find('id=:id', array(':id'=>$data->accounting_period_id));
                                },
                                "htmlOptions" => array(
                                    "style" => "white-space: nowrap; width: 9%;",
                                ),

                            ),
                            array(
                                "header"=> AccountingHelper::t('Conciliated'),
                                "name"=>"reconciled",
                                "value"=>function($data){

                                    return MipHelper::getYesNoOptions()[$data->reconciled] ;
                                },
                                "htmlOptions" => array(
                                    "style" => "white-space: nowrap; width: 1%;",
                                ),

                            ),
                            array(
                              "header"=> AccountingHelper::t("Move"),
                                "name"=> "accounting_account_id",
                                'type' => 'raw',
                                "value"=> function($data){
                                        $move = $data->accountingMove;
                                        return GxHtml::link($move->label, array('accountingMove/view', 'id' => $move->id), array("target"=>"blank")) ;
                                    },
                                "htmlOptions" => array(
                                    "style" => "white-space: nowrap; ",
                                ),

                            ),     
                            array(
                                "header"=> MipHelper::t('Reference'),
                                "name"=>"id",
                                "type"=>"raw",
                                "value"=>function($data){
                                    $references_fragment = "";
                                    $references = AccountingMoveReference::model()->findAll('move_id = :move_id', array(':move_id'=>$data->accounting_move_id));
                                    foreach($references as $reference){
                                        $references_fragment .= CHtml::tag("span",array("style"=>"margin-left:10px;"), CHtml::tag("b",array(),$reference->label).": ".$reference->value );
                                    }
                                    return $references_fragment;
                                },
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
                                'template'=>'{view}{update}{delete-not-ajax}',
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
    
<?php endif; ?>
