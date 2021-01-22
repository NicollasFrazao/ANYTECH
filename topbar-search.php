<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/searchmenu.css">
<style>
	.suggestion-item-news
	{
		display: inline-block;
		width: 90%;
		height: auto;
		padding: 2%;
		padding-left: 5%;
		padding-right: 5%;
		text-align: left;
		background-color: transparent;
		color: #fff;
		font-size: 0.8em;
		cursor: pointer;
		text-overflow: ellipsis;
		letter-spacing: 0.5px;
	}

	.suggestion-item-news:hover
	{
		background-color: #000;
		color: #fff;
	}
</style>

<div class="anytech-bar">
	<img src="<?php echo VOLTAR; ?>images/logo.png" id="anytech_logo_image" style="cursor: pointer" alt="ANYTECH" onclick="window.location.href = '<?php echo VOLTAR; ?>index.php';">
	<input type="text" id="anytech_login_search" placeholder="Pesquise aqui...">
	<input type="button" id="anytech_login_search_btn" placeholder="Pesquise aqui...">
	<input type="button" id="anytech_login_button" value="ENTRAR" onclick="window.location.href = '<?php echo VOLTAR; ?>login?url=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>';">
</div>

<div class="search-itens" style="top: 0px;" id="atsearchbox">
	<div id="intosearchbox" style="overflow: auto;"></div>
</div>

<script src="<?php echo VOLTAR; ?>js/menuoff.js"></script>
<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>	
<script src="<?php echo VOLTAR; ?>js/topbar.js"></script>
<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
<script>
	window.onresize = function()
	{
		altPg = parseInt(window.innerHeight);
		altPg = altPg - 70;
		intosearchbox.style.height = altPg + "px";	
		
		altPg = parseInt(window.innerHeight);
		altPg = altPg - 150;
		//setSearch.style.height = altPg + "px";	
		
		if(window.innerWidth > 900)
		{
			$("#anytech_login_search").fadeIn('slow');
		}
		else
		{
			outMobMenu();
		}
	}
	
	anytech_login_search.onkeyup = function()
	{	
		mensagem = anytech_login_search.value;			
		$.ajax({
				url:'<?php echo VOLTAR; ?>php/PesquisaSugestaoNews.php',
				type:'POST',
				data:{
						Mensagem:mensagem,
						voltar: '<?php echo VOLTAR; ?>'},
				success:function(retorno){
					//itensSugestao = retorno.split(';');	
					intosearchbox.innerHTML = "";
					intosearchbox.innerHTML = retorno;
				}
			})
	}
</script>