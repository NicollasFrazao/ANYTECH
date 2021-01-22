function Ajax(metodo, url, parametros, retorno)
{
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  ajax = new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	  ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}
		
	ajax.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			if (retorno != "")
			{
				eval(retorno);
			}
		}
	}
	
	if (metodo == "GET")
	{
		ajax.open(metodo, url + ((parametros != "") ? "?" + parametros : ""))
		ajax.send();
	
	}
	else if (metodo == "POST")
	{
		ajax.open(metodo, url)
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.send(parametros);
	}
}

function AjaxForm(form, espera, retorno)
{
	if (espera != "")
	{
		eval(espera);
	}
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  ajax = new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	  ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	formData = new FormData(form);
	
	ajax.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			if (retorno != "")
			{
				eval(retorno);
			}
		}
	}
	
	ajax.open(form.method, form.action);
	ajax.send(formData);
}