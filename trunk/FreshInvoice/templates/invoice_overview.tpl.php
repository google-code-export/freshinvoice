<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr>
		<td>Overzicht van facturen</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr bgcolor="#CCCCCC">
		<td class="big">Nog te versturen</td>

	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Er zijn momenteel geen facturen die nog moeten worden verstuurd</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr bgcolor="#CCCCCC">
		<td class="big">Nog te voldoen:
		{foreach from=$open_vat key=p item=i}
			{$p}%: {$i}
		{/foreach}
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
			<tr>
				<td><b>FactuurId</b></td>
				<td><b>Klant</b></td>
				<td><b>Betalings status</b></td>
				<td><b>Factuur datum</b></td>

				<td><b>Incl. btw</b></td>
				<td><b>Excl. btw</b></td>
				<td><b>BTW</b></td>
				<td width="15%">&nbsp;</td>
			</tr>
			{foreach from=$open_invoices key=k item=i}
			<tr>
				<td><a href="index.php?p=display_factuur&factuurId={$i.factuurId}">{$i.factuurId}</a></td>
				<td>{$i.name}</td>
				<td>{$i.status}</td>
				<td>{$i.disp_date}</td>
				<td>{$i.bedrag}</td>
				<td>{$i.excl}</td>
				<td>{$i.vat}</td>

				<td class="right"><a href="index.php?p=factuur_betaal&factuurId={$i.factuurId}"><img src="images/money.png" title="invoice payed" /></a> 
					<a href="index.php?p=factuur_sendnow&factuurId={$i.factuurId}"><img src="images/resendmail.png" title="resend invoice" /></a>
					<a href="index.php?p=factuur_reprint&factuurId={$i.factuurId}"><img src="images/print.png" title="reprint invoice" /></a> 
					<a href="index.php?p=beheer_factuur&factuurId={$i.factuurId}"><img src="images/edit.png" title="edit" /></a></td>
			</tr>
			{/foreach}
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr bgcolor="#CCCCCC">
		<td class="big">Voldaan dit kwartaal: 
		{foreach from=$done_vat key=p item=i}
			{$p}%: {$i}
		{/foreach}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>

	</tr>
	<tr>
		<td>Er zijn momenteel geen voldane facturen</td>
	</tr>
</table>
