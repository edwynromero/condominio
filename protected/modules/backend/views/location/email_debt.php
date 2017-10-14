<?php 		
	// /path/to/mail/views/emailTpl.php
	/** @var dpsEmailController $this */
	$this->setSubject( MipHelper::t('For') . ' ' . $sUsername );
	$this->setLayout( 'layouts/emailLayoutTpl' );
	$this->attach( $sFilePath ); 
?>

<?php echo MipHelper::t('Hello') ?> <? echo $sUsername ?>!
