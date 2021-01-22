<?php

	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$code = mysql_escape_string($_GET['codigo']);
	$seta = mysql_escape_string($_GET['seta']);
	
	$resultstar = $conexaoPrincipal -> Query("select cd_usuario from usuario_artigo where cd_artigo = '$code'");
	$linhaST = mysqli_fetch_assoc($resultstar);
	
	if($linhaST == 0)
	{
		$result = $conexaoPrincipal -> Query("insert into usuario_artigo values ('$seta','$code')");
	}
	else
	{
		$resultUp = $conexaoPrincipal -> Query("update usuario_artigo set cd_usuario = '$seta' where cd_artigo = '$code'");
	}
	echo $linhaST['cd_usuario'];
	
?>