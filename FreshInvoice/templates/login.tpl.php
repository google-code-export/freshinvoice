<form id="loginform" class="freshform" name="loginform" method="post" action="index.php?p=doLogin">
<fieldset>
<legend>{$lang.login}</legend>
<p>{$lang.logintext}</p>

<label><input type="text" name="emailadres" tabindex="1" />{$lang.emailaddress}:</label>
<label><input type="password" name="password" tabindex="2" />{$lang.password}:</label>
<label><select name="language"><option value="english">English</option><option value="dutch">Nederlands</option></select>{$lang.language}:</label>

<label for="submit">
    <input name="submit" type="submit" id="submit" tabindex="3" value="{$lang.login}" />
</label>
</fieldset>
</form>