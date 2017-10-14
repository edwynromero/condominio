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
	'method'=>'get',
        'htmlOptions' => array("class"=>"form-inline"),
)); 


?>
<?php
$this->breadcrumbs=array(
        MipHelper::t( 'Reports')=>array('index'),
	MipHelper::t( 'Defaults Report'),
);
?>
<div class="row-fluid">
    <div  class="span12">
        <h1><?php echo MipHelper::t("Defaults Report");?></h1>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <span class="row-fluid">
                <span class="span12">
                Puede seleccionar la Cantidad Mínima y Máxima de Cuotas en Deuda para filtrar el Reporte.  También puede definir el número de Filas por Página:  
                </span>
            </span>
            <span class="row-fluid">
                <span class="span2">
                    <?php echo CHtml::label(MipHelper::t("Due Fees Minimal"), "min", array("class"=>"control-label"))?>
                    <?php echo CHtml::dropDownList("min", $min_fee_dues, array("1"=>"1", "2" => "2", "3"=>"3","5"=>"5","10"=>"10","15"=>"15","20"=>"20"), array("class"=>"input-mini"))?>
                </span>
                <span class="span2">
                    <?php echo CHtml::label(MipHelper::t("Due Fees Maximal"), "max", array("class"=>"control-label"))?>
                    <?php echo CHtml::dropDownList("max", $max_fee_dues, array("1"=>"1", "3"=>"3","5"=>"5","10"=>"10","15"=>"15","20"=>"20","10000"=>"Todas"), array("class"=>"input-small")) ?>
                </span>
                 <span class="span2">
                    <?php echo CHtml::label(MipHelper::t("Page Size"), "size", array("class"=>"control-label"))?>
                    <?php echo CHtml::dropDownList("size", $page_size, array("5"=>"5","10"=>"10","15"=>"15","20"=>"20"), array("class"=>"input-mini")) ?>   
                </span>
                <span class="span6">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType'=>'submit',
                                        'type'=>'primary',
                                        'label'=>MipHelper::t("Configure at Report"),
                                        'htmlOptions'=>array('class'=>'align-center'), )
                                ); 
                    ?>   
                </span>
            </span>
            <span class="row-fluid">
                <span class="span12 text-right">
                    <a class="btn btn-info"  href="<?php echo $this->createUrl("//backend/report/downloadDefaulters", array("min"=>$min_fee_dues, "max"=>$max_fee_dues)) ?>" target="blank"><?php echo MipHelper::t("Download Excel") ?></a>
                </span>
            </span>  
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'defaults-grid',
                'type' => ' striped',
                'dataProvider'=>$dataProvider,
                'filter'=>null,
                'columns'=>array(
                                'id',
                                array(
                                        'header'=>'Parcela',
                                        'name'=>'code',
                                        'type'=>'raw',
                                        'value'=> array($this, 'showGridLocation'),
                                ),
                                array(
                                        'header'=>'Propietarios',
                                        'name'=>'fee_debt_count',
                                        'type'=>'raw',
                                        'value'=> array($this, 'showGridOwnersByLocation'),
                                ),
                                array(
                                        'header'=>'Deuda',
                                        'name'=>'fee_debt_count',
                                        'type'=>'raw',  
                                        'value'=> array($this, 'showGridFeeDueSum'),
                                ),
                                array(
                                        'header'=>'Cuotas',
                                        'name'=>'fee_debt_count',
                                        'type'=>'raw',
                                        'value'=> array($this, 'showGridFeeCount'),
                                ),	
                                array(
                                        'class'=>'bootstrap.widgets.TbButtonColumn',
                                        'template'=>'{view}',
                                        'buttons'=>array(
                                            'view' => array(
                                                'url' => function($data) {
                                                return $link = Yii::app()->controller->createUrl('//site/downloadAccountState', array("location_id"=>$data["id"]));
                                                },
                                                'options'=>array("target"=>"blank"),
                                            ),
                                        ),
                                ),
                ),
        )); ?>
    </div>
</div>

<?php
$this->endWidget(); 
