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

var timeoutID = null;

/* Must pass in the "anchors" ID so that Lytebox can call the correct "onclick" handler... */
function loadLytebox(href, title) {
    if (typeof myLytebox != 'undefined') {
        // if the myLytebox object exists, start it up!
        var a = document.createElement("a");
        a.href = href;
        a.rel = "lyteframe";
        a.title = title;
        a.rev = "width: 600px; height: 400px; scrolling: no;";
        myLytebox.start( a, false, true);
    } else {
        // wait 1/10th of a second and attempt loading again...
        if (timeoutID) { clearTimeout(timeoutID); }
        timeoutID = setTimeout('loadLytebox("'+href+'", "'+title+'")', 100);
    }
    
}