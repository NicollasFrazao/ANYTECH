<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_GET['codigoArtigo']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	$sobreCompartilhar = mysql_escape_string($_GET['sobreCompartilhar']);
	
	$result = $conexaoPrincipal -> Query("insert into usuario_artigo_compartilhar(cd_usuario, cd_artigo, ds_sobre, dt_compartilhar) values('$codigoUsuario', '$codigoArtigo', '$sobreCompartilhar', now())");
		
	if ($result)
	{
		echo 1;
	}
	else
	{
		echo mysqli_error($conexaoPrincipal -> getConexao());
	}
?>