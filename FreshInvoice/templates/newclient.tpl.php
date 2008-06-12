<form class="freshform" name="newclient" method="post" action="index.php?p=doNewClient">
<fieldset>
<legend>{$lang.newclient}</legend>
<p>{$lang.newclienttext}</p>

<label><input type="text" name="emailadres" />{$lang.emailaddress}*:</label>
<label><input type="password" name="password1" />{$lang.password}*:</label>
<label><input type="password" name="password2" />{$lang.passwordcheck}*:</label>
<label><input type="text" name="voornaam">{$lang.firstname}*:</label>
<label><input type="text" name="tussenvoegsel">{$lang.middlename}:</label>
<label><input type="text" name="achternaam">{$lang.lastname}*:</label>
<label><select name="geslacht"><option value="M">{$lang.male}</option><option value="V">{$lang.female}</option></select>{$lang.sex}*:</label>
<label><input type="text" name="bedrijfsnaam">{$lang.companyname} ({$lang.companyonly}):</label>
<label><input type="text" name="straat">{$lang.street}*:</label>
<label><input type="text" name="huisnummer" size="9">{$lang.housenumber}*:</label>
<label><input type="text" name="postcode" size="9">{$lang.postalcode}*:</label>
<label><input type="text" name="plaats">{$lang.city}*:</label>
<label><select name="land">{foreach from=$countries item=country}<option>{$country}</option>{/foreach}</select>{$lang.country}*:</label>
<label><input type="text" name="telefoon">{$lang.phonenumber}*:</label>
<label><input type="text" name="fax">{$lang.faxnumber}:</label>
<label><input type="text" name="BTWnummer" />{$lang.vatnumber} ({$lang.companyonly}):</label>
<label><input type="text" name="KVKnummer" />{$lang.commerce} ({$lang.companyonly}):</label>
<label><input type="text" name="KVKplaats" />{$lang.commerceoffice} ({$lang.companyonly}):</label>
<label><input type="text" name="bedrijfsvorm" />{$lang.companytype} ({$lang.companyonly}):</label>
{$reCAPTCHA}
<div class="clear"></div>

<label for="submit">
    <input name="submit" type="submit" id="submit" tabindex="3" value="{$lang.newclient}" />
</label>

