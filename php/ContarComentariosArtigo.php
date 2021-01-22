<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_GET['codigoArtigo']))
	{
		exit;
	}
	
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	
	$result = $conexaoPrincipal -> Query("select count(tb_comentario_artigo.cd_comentario_artigo) as qt_comentario from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = '$codigoArtigo'");
	$linha = mysqli_fetch_assoc($result);
	
	echo $linha['qt_comentario'];
?>