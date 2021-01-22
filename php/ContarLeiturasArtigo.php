<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_GET['codigoArtigo']) || !isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	
	$result = $conexaoPrincipal -> Query("select count(usuario_artigo_leitura.cd_artigo) as qt_leitura, (select 1 from usuario_artigo_leitura where usuario_artigo_leitura.cd_usuario = '$codigoUsuario' and usuario_artigo_leitura.cd_artigo = '$codigoArtigo') as ic_leitura from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = '$codigoArtigo'");
	$linha = mysqli_fetch_assoc($result);
	
	$qnt = $linha['qt_leitura'];
	$aux = $linha['ic_leitura'];
	
	echo $aux.';-;'.$qnt;
?>