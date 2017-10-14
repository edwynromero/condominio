<?php

// Include the main TCPDF library (search for installation path).
Yii::import('application.extensions.tcpdf.*');


// Extend the TCPDF class to create custom Header and Footer
class KPdf extends TCPDF 
{
	private $htmlHeader;
	private $htmlFooter;
	
	/**
	 * 
	 * @param string $orientation
	 * @param string $unit
	 * @param string $format
	 * @param string $unicode
	 * @param string $encoding
	 * @param string $diskcache
	 */
	public function __construct($orientation = "P", $unit = "mm", $format="Letter", $unicode = true, $encoding = 'UTF-8', $diskcache = false)
	{
		parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache); 		
	
	}
	
	
	
	/**
	 *
	 * @param mixed $value
	 */
	public function setHtmlHeader($value = array()) 
	{
		if( is_array($value) )
		{
			$controller = Yii::app()->getController();
			$this->htmlHeader  = $controller->renderPartial('application.extensions.report.kpdf.views._header', $value, true,false);			
		}
		else		
			$this->htmlHeader = $value;
	}
	

	/**
	 * 
	 * @param mixed $value
	 */
	public function setHtmlFooter($value= array()) 
	{
		if( is_array($value) )
		{
			$controller = Yii::app()->getController();
			$this->htmlFooter  = $controller->renderPartial('application.extensions.report.kpdf.views._footer', $value, true,false);
		}
		else
			$this->htmlFooter = $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TCPDF::Header()
	 */
	public function Header() {		
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 20, PDF_MARGIN_RIGHT);		
		$this->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+20);
		$this->writeHTML($this->htmlHeader);
	}	
	
	
	
	/**
	 * 
	 */
	public function writeBodyHTML($html)
	{	
		$this->writeHTML($html);
	}
	
	
	
	

    /**
     * (non-PHPdoc)
     * @see TCPDF::Footer()
     */
    public function Footer() 
    {    
    	
    	$this->SetFont('helvetica', 'I', 10);
    	// Contenido del footer.
    	$this->SetXY(20, -32);
      	
    	$this->writeHTML(str_replace("##pag##", $this->getAliasNumPage(), $this->htmlFooter));

    }
    
	

	
}

?>