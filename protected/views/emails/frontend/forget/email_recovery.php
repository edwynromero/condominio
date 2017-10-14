<?php 		
	
	// /path/to/mail/views/emailTpl.php
	/** @var dpsEmailController $this */
	$this->setSubject( MipHelper::t('For') . ' ' . $sUsername );
	$this->setLayout( 'layouts/emailLayoutTpl' ); 
	$link = Yii::app()->controller->createAbsoluteUrl('//site/recover',array('email'=>$sEmail, "token"=>$sToken));
?>
<?php echo MipHelper::t('Hello') ?> <?= $sUsername ?>
<br>
<br>
Usted ha recibido el presente correo, porque ha ejecutado el formulario para recuperar la contraseña del sistema (si usted no ha realizado tal acción, haga caso omiso del mismo).
<br>
<br>
Haga click en el siguiente enlace <b><?php echo CHtml::link("Link para recuperar contraseña",$link) ?></b> para recuperar su contraseña.
<br>
<br>
También puede hacerlo copiando el texto que sigue en el navegador de internet:
<br>
<br>
<?php echo $link; ?>
<br>
<br>
Atentamente.
<br>
