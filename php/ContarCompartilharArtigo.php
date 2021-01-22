<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_GET['codigoArtigo']))
	{
		exit;
	}
	
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	
	$result = $conexaoPrincipal -> Query("select count(usuario_artigo_compartilhar.cd_artigo) as qt_compartilhar from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = '$codigoArtigo'");
	$linha = mysqli_fetch_assoc($result);
	
	echo $linha['qt_compartilhar'];
?>