<h1>{$lang.navigation}</h1>
<ul>
	<li><a href="index.php">{$lang.home}</a></li>
	{if $allowed >= 1 }
		<li><a href="index.php?p=bekijk_facturen">{$lang.viewinvoices}</a></li>
		<li><a href="index.php?p=persoonsgegevens">{$lang.personalinfo}</a></li>
	{/if}
	
	{if $loggedIn == true }
		<li><a href="index.php?p=logout">{$lang.logout}</a></li>
	{else}
		<li><a href="index.php?p=newClient">{$lang.becomeclient}</a></li>
		<li><a href="index.php?p=login">{$lang.login}</a></li>
		<li><a href="index.php?p=forgotmypass">{$lang.forgotpass}</a></li>
	{/if}
</ul>

{if $allowed >= 99 }
<h1>{$lang.adminnav}</h1>
<ul>
	<li><a href="index.php?p=beheer_categorieen">{$lang.managecats}</a></li>
	<li><a href="index.php?p=add_categorie">{$lang.insertcat}</a></li>
	<li><a href="index.php?p=beheer_artikelen">{$lang.managearticles}</a></li>
	<li><a href="index.php?p=add_artikel">{$lang.insertarticles}</a></li>
	<li><a href="index.php?p=klantenlijst">{$lang.clientlist}</a></li>
	<li><a href="index.php?p=facturen">{$lang.invoices}</a></li>
	<li><a href="index.php?p=incasso_overzicht">{$lang.incassolist}</a></li>
	<li><a href="index.php?p=paymentprocessor">{$lang.paymentprocessor}</a></li>
	<li><a href="index.php?p=paymentsgood">{$lang.goodpayments}</a></li>
	<li><a href="index.php?p=paymentswrong">{$lang.wrongpayments}</a></li>
	<li><a href="index.php?p=stornations">{$lang.stornations}</a></li>
	<li><a href="index.php?p=stornationswrong">{$lang.wrongstornations}</a></li>
	<li><a href="index.php?p=paymentaandacht">{$lang.attentionpayments}</a></li>
	<li><a href="index.php?p=paymentsearch">{$lang.findapayment}</a></li>
	<li><a href="index.php?p=factuur_vorig_kwartaal">{$lang.lasttrimester}</a></li>
	<li><a href="index.php?p=factuur_alles">{$lang.allinvoices}</a></li>
	<li><a href="index.php?p=binnenkort_verlopen">{$lang.expiresoon}</a></li>
	<li><a href="index.php?p=maak_factuur">{$lang.createinvoice}</a></li>
	<li><a href="index.php?p=printQueue">{$lang.printqueue}</a></li>
	<li><a href="index.php?p=version">{$lang.version}</a></li>
</ul>
{/if}