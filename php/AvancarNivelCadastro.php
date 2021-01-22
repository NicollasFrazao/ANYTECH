<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	
	$result = $conexaoPrincipal -> Query("update tb_usuario set cd_nivel_cadastro = cd_nivel_cadastro + 1 where cd_usuario = '$codigoUsuario'");
?>