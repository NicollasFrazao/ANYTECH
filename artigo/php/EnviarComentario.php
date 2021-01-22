<?php
	define('VOLTAR', '../../');
	session_start();
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigoArtigo = mysql_escape_string($_POST['codigoArtigo']);
	$comentarioArtigo = mysql_escape_string($_POST['comentarioArtigo']);
	
	$result = $conexaoPrincipal -> Query("insert into tb_comentario_artigo(cd_usuario, cd_artigo, ds_conteudo, dt_comentario_artigo) values('$codigoUsuario', '$codigoArtigo', '$comentarioArtigo', now())");
	
	if ($result)
	{
		echo '1;-;Comentário enviado com sucesso!';
	}
	else
	{
		echo '0;-;Erro ao enviar o comentário!'/*.mysqli_error($conexaoPrincipal -> getConexao()).$codigoUsuario*/;
	}
?>