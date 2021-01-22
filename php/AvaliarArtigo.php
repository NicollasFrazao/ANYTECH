<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_GET['codigoArtigo']))
	{
		exit;
	}
	
	$usercode = $_SESSION['AnyTech']['codigoUsuario'];	
	$valorAvaliacao = mysql_escape_string($_GET['avaliacao']);
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	
	
	$resultstar = $conexaoPrincipal -> Query("select qt_estrelas from usuario_artigo_avaliar where cd_usuario = '$usercode' and cd_artigo = '$codigoArtigo'");
	$linhaST = mysqli_fetch_assoc($resultstar);
	
	if($linhaST == 0)
	{
		$result = $conexaoPrincipal -> Query("insert into usuario_artigo_avaliar(cd_usuario, cd_artigo, qt_estrelas) values ('$usercode', '$codigoArtigo', '$valorAvaliacao')");
	}
	else
	{
		$result = $conexaoPrincipal -> Query("update usuario_artigo_avaliar set qt_estrelas = '$valorAvaliacao' where cd_usuario = '$usercode' and cd_artigo = '$codigoArtigo'");
	}
		
?>