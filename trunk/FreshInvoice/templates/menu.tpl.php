<h1>Menu</h1>
<ul>
	<li><a href="index.php?p=home">home</a></li>
	{if $allowed >= 1 }
		<li><a href="index.php?p=bekijk_facturen">view invoices</a></li>
		<li><a href="index.php?p=persoonsgegevens">persoonsgegevens</a></li>
	{/if}
	
	{if $loggedIn == true }
		<li><a href="index.php?p=logout">logout</a></li>
	{else}
		<li><a href="index.php?p=nieuwe_klant">become a client</a></li>
		<li><a href="index.php?p=login">login</a></li>
	{/if}
</ul>

{if $allowed >= 99 }
<h1>Admin functies</h1>
<ul>
	<li><a href="index.php?p=beheer_categorieen">categorieen beheren</a></li>
	<li><a href="index.php?p=add_categorie">categorie invoegen</a></li>
	<li><a href="index.php?p=beheer_artikelen">artikelen beheren</a></li>
	<li><a href="index.php?p=add_artikel">artikel invoegen</a></li>
	<li><a href="index.php?p=klantenlijst">klantenlijst</a></li>
	<li><a href="index.php?p=facturen">facturen</a></li>
	<li><a href="index.php?p=incasso_overzicht">incasso overzicht</a></li>
	<li><a href="index.php?p=paymentprocessor">payment processor</a></li>
	<li><a href="index.php?p=paymentsgood">goede betalingen</a></li>
	<li><a href="index.php?p=paymentswrong">foute betalingen</a></li>
	<li><a href="index.php?p=stornations">stornaties</a></li>
	<li><a href="index.php?p=stornationswrong">foute stornaties</a></li>
	<li><a href="index.php?p=paymentaandacht">aandacht betalingen</a></li>
	<li><a href="index.php?p=paymentsearch">betalingen zoeken</a></li>
	<li><a href="index.php?p=factuur_vorig_kwartaal">vorig kwartaal</a></li>
	<li><a href="index.php?p=factuur_alles">alle facturen</a></li>
	<li><a href="index.php?p=binnenkort_verlopen">binnenkort verlopen</a></li>
	<li><a href="index.php?p=maak_factuur">factuur maken</a></li>
	<li><a href="index.php?p=printQueue">print queue</a></li>
	<li><a href="index.php?p=version">versie</a></li>
</ul>
{/if}