<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Factuur</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	font-family: tahoma;
	font-size: 11px;
}
.bold {
	font-family: tahoma;
	font-size: 11px;
	font-weight: bold;
}
</style>
</head>

<body>
{#LOGO#}<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="27%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50%">Factuurnummer:</td>
          <td>{#INVOICEPREPEND#}{#FACTUURID#}</td>
        </tr>
        <tr>
          <td>Datum:</td>
          <td>{#FACTUURDATUM#}</td>
        </tr>
        <tr>
          <td>Uiterste betaaldatum:</td>
          <td>{#INVOICEEXPIREDATE#}</td>
        </tr>
        <tr>
          <td>Klantnummer:</td>
          <td>{#KLANTID#}</td>
        </tr>
    </table><br />
    ABN Amro te Amsterdam<br />
    <strong>11.11.11.111</strong><br />
    BIC ABNANL2A<br />
    IBAN NL74ABNA05111111111</td>
    <td width="45%" valign="top">&nbsp;</td>
    <td width="28%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr align="right">
          <td valign="top">Sample business<br />
            Random address 21<br />
            1111 AB Amsterdam<br /><br />
            KvK nummer: 1111111 te Amsterdam<br />
            BTW nummer: NL0000.00.000.B01<br />
			tel. 0031 (0)6 11 11 11 11<br />
			fax  0031 (0)84 11 11 111<br />
      		e-mail. info@example.com</td>
        </tr>
        </table></td>
  </tr>
</table>
<br /><br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bold">
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="25%">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
          <td>{#KLANTBEDRIJFSNAAM#}{#KLANTNAAM#}<br />
		  {#KLANTADRES#}</td>
        </tr>
      </table></td>
    <td width="60%">&nbsp;</td>
  </tr>
</table>
<br /><br />
<table width="100%"  border="0" cellspacing="0" cellpadding="2" class="bold">
  <tr>
    <td width="50%">Product omschrijving</td>
    <td width="10%">Datum</td>
    <td width="10%">Periode</td>
    <td width="10%">Aantal</td>
    <td width="10%" align="right">Prijs</td>
    <td width="10%" align="right">Totaal</td>
  </tr>
</table>
<hr noshade="noshade" size="1">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
{#FACTUURINHOUD#}
</table>
<hr noshade="noshade" size="1">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
  <td width="90%" class="bold">Subtotaal excl. {#BTWTARRIEF#}% BTW</td>
  <td width="10%" align="right">{#SUBTOTAAL#}</td>
</tr>
<tr>
  <td>BTW ({#BTWTARRIEF#}%)</td>
  <td align="right">{#BTWBEDRAG#}</td>
</tr>
</table>
<hr noshade="noshade" size="1">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
  <td width="90%" class="bold">Totaal</td>
  <td width="10%" align="right">{#FACTUURTOTAAL#}</td>
</tr>
</table>
</body>
</html>
