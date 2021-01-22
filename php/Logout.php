<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	
	$result = $conexaoPrincipal -> Query("update tb_usuario set ic_logado = 0 where cd_usuario = '$codigoUsuario'");
	
	session_destroy();
	
	if (!defined('VOLTAR'))
	{
		define('VOLTAR', '');
	}
	
	unset($_SESSION['AnyTech']);
	
	header('location: '.VOLTAR.'../index.php');
?>