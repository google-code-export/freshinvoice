<h1>Menu</h1>
<ul>
	<li><a href="index.php?p=home" target="mainFrame">home</a></li>
	{if $allowed >= 1 }
		<li><a href="index.php?p=bekijk_facturen" target="mainFrame">facturen bekijken</a></li>
		<li><a href="index.php?p=persoonsgegevens" target="mainFrame">persoonsgegevens</a></li>
	{/if}
	<li><a href="index.php?p=logout" target="mainFrame">logout</a></li>
</ul>

{if $allowed >= 99 }
<h1>Admin functies</h1>
<ul>
	<li><a href="index.php?p=beheer_categorieen" target="mainFrame">categorieen beheren</a></li>
	<li><a href="index.php?p=add_categorie" target="mainFrame">categorie invoegen</a></li>
	<li><a href="index.php?p=beheer_artikelen" target="mainFrame">artikelen beheren</a></li>
	<li><a href="index.php?p=add_artikel" target="mainFrame">artikel invoegen</a></li>
	<li><a href="index.php?p=klantenlijst" target="mainFrame">klantenlijst</a></li>
	<li><a href="index.php?p=facturen" target="mainFrame">facturen</a></li>
	<li><a href="index.php?p=incasso_overzicht" target="mainFrame">incasso overzicht</a></li>
	<li><a href="index.php?p=paymentprocessor" target="mainFrame">payment processor</a></li>
	<li><a href="index.php?p=paymentsgood" target="mainFrame">goede betalingen</a></li>
	<li><a href="index.php?p=paymentswrong" target="mainFrame">foute betalingen</a></li>
	<li><a href="index.php?p=stornations" target="mainFrame">stornaties</a></li>
	<li><a href="index.php?p=stornationswrong" target="mainFrame">foute stornaties</a></li>
	<li><a href="index.php?p=paymentaandacht" target="mainFrame">aandacht betalingen</a></li>
	<li><a href="index.php?p=paymentsearch" target="mainFrame">betalingen zoeken</a></li>
	<li><a href="index.php?p=factuur_vorig_kwartaal" target="mainFrame">vorig kwartaal</a></li>
	<li><a href="index.php?p=factuur_alles" target="mainFrame">alle facturen</a></li>
	<li><a href="index.php?p=binnenkort_verlopen" target="mainFrame">binnenkort verlopen</a></li>
	<li><a href="index.php?p=maak_factuur" target="mainFrame">factuur maken</a></li>
	<li><a href="index.php?p=printQueue" target="mainFrame">print queue</a></li>
	<li><a href="index.php?p=version" target="mainFrame">versie</a></li>
</ul>
{/if}