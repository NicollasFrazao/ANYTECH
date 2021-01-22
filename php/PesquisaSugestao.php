<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '');
	
	//dados da mensagem
	$mensagem_mensagem = $_POST['Mensagem'];
	
	$result_Pesquisa = $conexaoPrincipal -> Query("select nm_titulo, dt_criacao from tb_artigo where nm_titulo like '%$mensagem_mensagem%' order by dt_criacao desc limit 5") or die("Mensagem Não Enviada") ;
			
	$linha_Pesquisa = mysqli_fetch_assoc($result_Pesquisa);
	$total_Pesquisa = mysqli_num_rows($result_Pesquisa);
	
	$cont = 0;
	
	if ($total_Pesquisa > 0)
	{
		do
		{	
			$value = str_replace($mensagem_mensagem,'<b>'.$mensagem_mensagem.'</b>',$linha_Pesquisa['nm_titulo']);
			echo '<label class="suggestion-item" id="suggestion_item" onclick="anytech_feed_input_search.value = this.textContent;">'.$value.'</label>';
			
		}
		while ($linha_Pesquisa = mysqli_fetch_assoc($result_Pesquisa));
		
	}
?>