<?php 

        $this->beginWidget(
            'bootstrap.widgets.TbModal', array(
                'id' => 'updatePayNotCashInfoDialog',

                //'title'=>MipHelper::t("Update Pay Not Cash Info"),
                'autoOpen'=>true,
                'htmlOptions' => array("style"=>"width:70%;left:35%;")
            )
        ); ?>

          <?php echo $this->renderPartial('ajax/payNotCashInfo/_form', array('model'=>$model, 'person_id'=>$person_id)); ?>

	
<?php 	

	$this->endWidget();
?>
