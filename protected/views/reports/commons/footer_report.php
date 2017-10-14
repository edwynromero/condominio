<?php
    /* @var $this SiteController */
      $baseUrl = Yii::app()->theme->baseUrl;
      $pdfPathImage = $baseUrl . "/img";
?>
<div class="footer">
    <table align="center">
        <tbody>
            <tr>
                <td class="text-footer" width="60%">
                    <span class="header-label">Dirección:&nbsp;</span> Carretera Panamericana, Km. 9, Mirador Panamericano. <br><span class="header-label">Zona Postal:&nbsp;</span>1204				
                </td>
                <td class="text-footer"  width="40%">
                    <span class="header-label">Teléfonos:</span>  0212-417.29.64.  <br><span class="header-label">Email:&nbsp;</span>cobranzas@tumirador.com.ve				
                </td>
            </tr>
            <tr >
                <td  class="text-footer" colspan="2" align="center"><strong> <?php echo isset($pdfReportTitle)? $pdfReportTitle:''; ?> - Página  {PAGENO} </strong></td>
            </tr>
        </tbody>
    </table>
</div>