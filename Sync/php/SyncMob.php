<?php

	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$code = mysql_escape_string($_GET['codigo']);
	
	$resultstar = $conexaoPrincipal -> Query("select cd_usuario from usuario_artigo where cd_artigo = '$code'");
	$linhaST = mysqli_fetch_assoc($resultstar);
	
	if($linhaST < 1)
	{
		$resultstar = $conexaoPrincipal -> Query("insert into usuario_artigo values (1,'$code')");
	}
	
	echo $linhaST['cd_usuario'];
	
?>