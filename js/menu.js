var corMenu;
var corBackground;
var corHeader;

window.onload = function()
{
	subMenuIndex = 0;
}


function search()
{
	if(subMenuIndex == 1)
	{
		mainMenu();
	}
}



function profileMenu()
{
	enterSubMenu();
	search_text.value="@Perfil";
	$("#anytech_profile_menu").toggle('slide');
}

function notifyMenu()
{
	enterSubMenu();
	search_text.value="@Notificações";
	$("#anytech_notify_menu").toggle('slide');
}

function productsMenu()
{
	enterSubMenu();
	search_text.value="@Produtos";
	$("#anytech_products_menu").toggle('slide');
}

function favoriteMenu()
{
	enterSubMenu();
	search_text.value="@Favoritos";
	$("#anytech_favorite_menu").toggle('slide');
}

function readMenu()
{
	enterSubMenu();
	search_text.value="@LerDepois";
	$("#anytech_read_menu").toggle('slide');
}

function interestsMenu()
{
	enterSubMenu();
	search_text.value="@Interesses";
	$("#anytech_interests_menu").toggle('slide');
}

function historyMenu()
{
	enterSubMenu();
	search_text.value="@Histórico";
	$("#anytech_history_menu").toggle('slide');
}

function infoMenu()
{
	enterSubMenu();
	search_text.value="@Informações";
	$("#anytech_info_menu").toggle('slide');
}

function configMenu()
{
	enterSubMenu();
	search_text.value="@Configurações";
	$("#anytech_config_menu").toggle('slide');
}

function accountMenu()
{
	enterSubMenu();
	search_text.value="@Conta";
	$("#anytech_account_menu").toggle('slide');
}

function productsLogin()
{
	search_text.value="@Eletrontech";
	$("#anytech_products_menu").toggle('slide');
	$("#anytech_products_login_menu").toggle('slide');
}

function productsLoginOut()
{
	search_text.value="@Produtos";
	$("#anytech_products_menu").toggle('slide');
	$("#anytech_products_login_menu").toggle('slide');
}

function passwordMenu()
{
	search_text.value="@AlterarSenha";
	$("#anytech_account_menu").toggle('slide');
	$("#anytech_account_menu_password").toggle('slide');
}

function dataMenu()
{
	search_text.value="@DadosGerais";
	$("#anytech_account_menu").toggle('slide');
	$("#anytech_account_data").toggle('slide');
}

function leaveMenu()
{
	search_text.value="@DesativarConta";
	$("#anytech_account_menu").toggle('slide');
	$("#anytech_account_leave").toggle('slide');
}

function configColor()
{
	search_text.value="@Estilo";
	$("#anytech_config_menu").toggle('slide');
	$("#anytech_config_color").toggle('slide');
}

function primaryColor(color)
{
	$(".anytech-bar").css("background-color",color);
	$(".anytech-follow-button").css('background-color',color);
	$(".button-comment-submit").css('background-color',color);
	$(".anytech-profile-name").css('color',color);
	$(".anytech-info-label-count").css('color',color);
	$(".anytech-box-title").css('background-color',color);
	$(".anytech-info-label-follow").css('color',color);
	corHeader = color;
}

function secundaryColor(color)
{
	$(".anytech-menu-body").css("background-color",color);
	corMenu = color;
}

function tertiaryColor(color)
{
	$("body").css("background-color",color);
	corBackground = color;
}


