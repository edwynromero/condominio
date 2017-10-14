<?php 

        $this->beginWidget(
            'bootstrap.widgets.TbModal', array(
                'id' => 'createPayNotCashInfoDialog',
                'autoOpen'=>true,
                'htmlOptions' => array("style"=>"width:70%;left:35%;")
            )
        ); ?>

          <?php echo $this->renderPartial('ajax/payNotCashInfo/_form', array('model'=>$model, 'person_id'=>$person_id)); ?>

	
<?php 	

	$this->endWidget();
?>


