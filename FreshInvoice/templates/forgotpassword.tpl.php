<form class="freshform" name="forgotpass" method="post" action="index.php?p=doForgotPassword">
<fieldset>
<legend>{$lang.forgotpass}</legend>
<p>{$lang.forgotpasstext}</p>

<label><input type="text" name="emailadres" tabindex="1" />{$lang.emailaddress}:</label>

<label for="submit">
    <input name="submit" type="submit" id="submit" tabindex="2" value="{$lang.request}" />
</label>
</fieldset>
</form>