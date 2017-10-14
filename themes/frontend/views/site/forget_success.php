<?php
/* @var $this SiteController */
/* @var $model RecoveryPassword */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Recover Password';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="row-fluid">
	
    <div id="login_form_section" class="span4 offset7 img-rounded">
	<?php
	
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>MipHelper::t("Recovery your access password"),
			'htmlOptions'=>array( 'style'=>'borders: 0px;')
		));
		
	?>
	<div class="row-fluid" style="margin-top:50px; margin-bottom: 50px;">
	  	<div class="span1"></div>
		<div class="span10">
                    <div id="">
		  	<div class="alert alert-block alert-success">
		  		<strong>¡<?php echo MipHelper::t("Recovery succefull")?>! </strong><?php echo MipHelper::t("review your mail, where find a <b>Link</b> to change the")?> <strong><?php echo MipHelper::t("Password")?></strong> <?php echo MipHelper::t("of access")?>.
                                <p> El sistema lo redireccionará automáticamente en aproximadamente <h4> <span id="seconds">10 </span> seg</h4></p> .</p>
				<p> Si no desea esperar, puede hacer click en el siguiente Link:  </p>
                                <p><h4><?php echo  CHtml::link(MipHelper::t('Go to Login'), $this->createAbsoluteUrl('//site/login'))?></h4></p>
                        <div id="reloj"></div>
                               <?php $returnUri = $this->createAbsoluteUrl('//site/login');
                                 Yii::app()->clientScript->registerMetaTag("10;url={$returnUri}", null, 'refresh'); ?>
                        </div>
                    </div>  
	  	</div>
		<div class="span1"></div>
	</div>
<?php $this->endWidget();?>
    </div>
</div>

<script type="text/javascript">

var seg = 9;
var s;
function seconds(){ 
    document.getElementById("seconds").innerHTML=seg;
   
    seg--;
}
 
var s = setInterval('seconds()', 1000);
 
//]]>
</script>