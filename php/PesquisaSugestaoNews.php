<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	
	define('VOLTAR', $_POST['voltar']);
	
	//dados da mensagem
	$mensagem_mensagem = $_POST['Mensagem'];
	
	$verifyChar = strripos($mensagem_mensagem, '@');
	$mensagem_mensagem = str_replace('@','',$mensagem_mensagem);
	if($verifyChar === false){
		
	$result_Pesquisa = $conexaoPrincipal -> Query("(select nm_titulo as 'titulo', ds_url as 'link' from tb_artigo where nm_titulo like '%$mensagem_mensagem%' order by nm_titulo limit 50) union (select concat('@',nm_nickname) as 'titulo', concat('../../@',nm_nickname) as 'link' from tb_usuario where nm_nickname like '%$mensagem_mensagem%' or nm_usuario_completo like '%$mensagem_mensagem%' order by nm_nickname limit 50)") or die("Mensagem Não Enviada");
	
	}
	else
	{
		$result_Pesquisa = $conexaoPrincipal -> Query("(select concat('@',nm_nickname) as 'titulo', concat('../../@',nm_nickname) as 'link' from tb_usuario where nm_nickname like '%$mensagem_mensagem%' or nm_usuario_completo like '%$mensagem_mensagem%')") or die("Mensagem Não Enviada");
	}
	
	//$result_Pesquisa = $conexaoPrincipal -> Query("(select concat('@',nm_nickname) as 'titulo', concat('../../@',nm_nickname) as 'link' from tb_usuario where nm_nickname like '%$mensagem_mensagem%' or nm_usuario_completo like '%$mensagem_mensagem%') union (select nm_titulo as 'titulo', ds_url as 'link' from tb_artigo where nm_titulo like '%$mensagem_mensagem%' order by nm_titulo limit 50)") or die("Mensagem Não Enviada");
			
	//select nm_titulo, ds_url from tb_artigo where nm_titulo like '%$mensagem_mensagem%' order by nm_titulo limit 50"//
	$linha_Pesquisa = mysqli_fetch_assoc($result_Pesquisa);
	$total_Pesquisa = mysqli_num_rows($result_Pesquisa);
	
	$cont = 0;
	
	if ($total_Pesquisa > 0)
	{
		do
		{	
			$value = str_replace($mensagem_mensagem,'<b>'.$mensagem_mensagem.'</b>',$linha_Pesquisa['titulo']);
			$url = VOLTAR."../artigo/".$linha_Pesquisa['link'];
			echo '<a href="'.$url.'" style="width: 94%; color: #eee; cursor:pointer; padding-left: 3%; padding-eight: 3%; margin: 10px; margin-left: 0px; margin-right: 0px;"><label class="suggestion-item-news" style="cursor:pointer;" id="suggestion_item_news" onclick="anytech_login_search.value = this.textContent;">'.$value.'</label></a>';
			
		}
		while ($linha_Pesquisa = mysqli_fetch_assoc($result_Pesquisa));
		
	}
?>