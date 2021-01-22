anytech_login_search.onclick = function()
{			
	$('#atsearchbox').fadeIn('slow');				
	cM = 0;	
	altPg = parseInt(window.innerHeight);
	altPg = altPg - 70;
	intosearchbox.style.height = altPg + "px";	
}		

anytech_login_search_btn.onclick = function()
{
	vlDPL = anytech_login_search.style.display;
	//alert(vlDPL);
	if(vlDPL != "inline-block" && vlDPL != "block")
	{
		inMobMenu();
	}
	else
	{
		outMobMenu();
	}
}

function inMobMenu()
{
	anytech_login_search_btn.style.backgroundImage= "url('../images/closesearcha.png')";
	$("#anytech_login_search").fadeIn('slow');
	$('#atsearchbox').fadeIn('slow');	
}

function outMobMenu()
{
	anytech_login_search_btn.style.backgroundImage= "url('../images/searcha.png')";
	$("#anytech_login_search").fadeOut('slow');
	$('#atsearchbox').fadeOut('slow');	
}

atsearchbox.onmousedown = function()
{
	cM = 1;
}

atsearchbox.onmouseup = function()
{
	cM = 0;
}

atsearchbox.onclick = function()
{
	cM = 0;
	anytech_login_search.focus();
}

atsearchbox.onblur = function()
{
	vlDPLBTN = anytech_login_search_btn.style.display;
	if(vlDPLBTN != "inline-block" && vlDPLBTN != "block" && vlDPLBTN != "")
	{
		if( cM == 1)
		{
		
		}
		else
		{
			outMobMenu();
			cM = 0;
		}
	}
	else
	{
		if( cM == 1)
		{
		
		}
		else
		{
			$('#atsearchbox').fadeOut('slow');
			cM = 0;
		}	
	}
	
}

anytech_login_search.onblur = function()
{	
	vlDPLBTN = anytech_login_search_btn.style.display;
	if(vlDPLBTN != "inline-block" && vlDPLBTN != "block" && vlDPLBTN != "")
	{
		if( cM == 1)
		{
		
		}
		else
		{
			outMobMenu();
			cM = 0;
		}
	}
	else
	{
		if( cM == 1)
		{
		
		}
		else
		{
			$('#atsearchbox').fadeOut('slow');
			cM = 0;
		}	
	}
}