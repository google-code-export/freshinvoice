function shure(url)
{
	if(window.confirm("Weet je het zeker?")){
		window.location.href=url+"&shure=yes";
	}
}

function catChange(catId)
{
	new Ajax.Request("index.php?p=json_artikelen_per_cat&catId="+catId, 
	{
		method:"get",
		asynchronous:true,
		onSuccess:doCatChange,
		onFailure:resultError
	});
}

function doCatChange (request)
{
	if (request.readyState==4) {
		var jsonData = eval('('+request.responseText+')');
		var dropdown = document.getElementById('artikelId');
		
		// LEEG DE DROPDOWN
		dropdown.options.length=0;
		
		for(a=0; a<jsonData.length; a++)
		{
			dropdown.options[dropdown.options.length]=new Option(jsonData[a].naam, jsonData[a].artikelId, false, false);
		}
	}
}

function resultError (request)
{
	alert('Error ' + request.status + ' -- ' + request.statusText + ' -- ' + request.responseText);
}