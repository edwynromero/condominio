<!-- CSS STYLE -->
<style>
	.header_report
	{
		font-size: 8px;
	}
	
	.text-footer
	{
	font-size: 8px;
	}
	
		
	.header-label
	{
		font-weight: bold;
		font-size: 8px;
	}
	
	.footer
	{
		border-top-color: #444;
		border-top-width: 0.5px;
		border-top-style: inset;
		text-align: center;
	}
	
	.note
	{
		color:#222;	
		font-size: 8px;
		text-align: center;
	}
	
	.note-label
	{
		font-weight: bold;
	}
	
</style>
<div class="note">
	<span class="note-label"></span><br>
</div>
<div class="footer">
	<table align="center">
		<tbody>
			<tr>
				<td class="text-footer">
					<span class="header-label">Dirección:</span> Carretera Panamericana, Km. 9, Mirador Panamericano. <span class="header-label">Zona Postal:</span>1204				
				</td>
			</tr>
			<tr>
				<td height="20px"  class="text-footer">
					<span class="header-label">Teléfonos:</span>  0212-417.29.64.  <span class="header-label">Email:</span>  cobranzas@tumirador.com.ve				
				</td>
			</tr>
			<tr >
				<td  class="text-footer"> <?php echo isset($title)? $title:''; ?> - Página ##pag## </td>
			</tr>
		</tbody>
	</table>
</div>	 