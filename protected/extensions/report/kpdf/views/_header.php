<!-- CSS STYLE -->
<style>
	.header_report
	{
		font-size: 10px;
	}
	
	.header-title
	{
		background-color: #FFF; 
		text-align: left;
	}
	
		
	.header-label
	{
		font-weight: bold;
	}
	
	.header-title-2
	{
		font-weight: bold;
	}
	
	.report_title
	{
		background-color: #EEE;
		font-weight: bold;
		text-align: center;
		line-height: 2px;
		
	}
	
	.header-logo
	{
		width: 70px;
	}
	
	.header-date
	{
		font-size: 10px; 
		text-align: center;
	}
	
		
</style>
<br>
<div class="header_report">
	<table>
		<tbody>
			<tr>
				<td width="90px">
					<img src="<?php echo Yii::app()->theme->baseUrl.'/img/logo_mirador.jpg'; ?>" class="header-logo">
				</td>
				<td width="360px">
					<span class="header-title-2">ASOCUMIPA</span><br>
					<span class="header-title">Asociación Civil Urbanización Mirador Panamericano</span><br>	
					<span class="header-label">RIF:</span> J-31643781-7				
				</td>
				<td width="90px">
					<div class="header-date">
						<br>
						<strong>Fecha y Hora</strong>
						<br><?php echo Yii::app()->dateFormatter->formatDateTime(time(), 'medium', false); ?><br>
						<?php echo Yii::app()->dateFormatter->formatDateTime( time(), false, 'medium' ); ?>
						<br>
					</div>						
				</td>
			</tr>
			<tr>
				<td colspan="3" class="report_title">
					<?php echo strtoupper($title); ?>					
				</td>
			</tr>
		</tbody>
	</table>
</div>