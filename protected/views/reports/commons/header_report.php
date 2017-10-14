<?php
    /* @var $this SiteController */
      $baseUrl = Yii::app()->theme->baseUrl;
      $pdfPathImage = $baseUrl . "/img";
?>
<div class="header_report">
    <table>
        <tr>
            <td width="90px">
                    <img src="<?php echo $pdfPathImage .'/logo_mirador_128.png'; ?>" class="header-logo">
            </td>
            <td width="600px">
                <span class="header-title-2">ASOCUMIPA</span><br>
                <span class="header-title">Asociación Civil Urbanización Mirador Panamericano</span><br>	
                <span class="header-label">RIF:</span> J-31643781-7				
            </td>
            <td width="90px">
                <div class="header-date">
                    <br>
                    <strong>Fecha</strong>
                    <br><?php echo Yii::app()->dateFormatter->formatDateTime(time(), 'medium', false); ?><br>
                    <br>
                </div>						
            </td>
        </tr>
        <tr>
            <td colspan="3" class="report_title">
                <br>
                <?php echo strtoupper($pdfReportTitle);  ?>					
            </td>
        </tr>
    </table>
</div>    

