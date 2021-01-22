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
	
	$result = $conexaoPrincipal -> Query("select count(usuario_artigo_favorito.cd_artigo) as qt_favorito, (select 1 from usuario_artigo_favorito where usuario_artigo_favorito.cd_usuario = '$codigoUsuario' and usuario_artigo_favorito.cd_artigo = '$codigoArtigo') as ic_favoritou from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = '$codigoArtigo'");
	$linha = mysqli_fetch_assoc($result);
	
	$qnt = $linha['qt_favorito'];
	$aux = $linha['ic_favoritou'];
	
	echo $aux.';-;'.$qnt;
?>