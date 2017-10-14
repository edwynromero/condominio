<?php 
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'createPersonDialog',
		'options'=>array(
			'title'=>MipHelper::t("Create Person"),
			'autoOpen'=>true,
			'modal'=>'true',
			'width'=>'auto',
			'height'=>'auto',
			'closeOnEscape'=>true, 
			'close'=>"js: function(e,ui){
				jQuery('body').undelegate('#closeCreatePersonDialog', 'click');
				jQuery('#createPersonDialog').remove();
			}",
		),
	));
	
	echo $this->renderPartial('ajax/_form', array('model'=>$model));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

