<?php 		
	// /path/to/mail/views/emailTpl.php
	/** @var dpsEmailController $this */
	$this->setSubject( MipHelper::t('For') . ' ' . $sUsername );
	$this->setLayout( 'layouts/emailLayoutTpl' );
	$this->attach( $sFilePath ); 
?>
<?php echo MipHelper::t('Hello') ?> <?= $sUsername ?>
<br>
<br>
El presente correo tiene como finalidad presentarle el 
estado de cuenta de la parcela <b>#<?php echo $sLocationCode?></b>
para su consideración.
<br>
<br>
De poseer deuda, le recomendamos ponerse al día lo más pronto posible.
<br>
<br>
<b>Nota:</b>&nbsp;Este mensaje fue generado automáticamente por el Sistema de Gestión de Mirador Panamericano
<br>
<br>
Atentamente.
<br>
