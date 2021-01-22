<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_POST['codigoCidade']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigoCidade = mysql_escape_string($_POST['codigoCidade']);
	
	$result = $conexaoPrincipal -> Query("insert into tb_endereco(cd_usuario, cd_cidade) values ('$codigoUsuario', '$codigoCidade')");
	
	if ($result)
	{
		echo '1;-;Localização adicionada com sucesso!';
	}
	else
	{
		echo '0;-;Não foi possível adicionar essa localização!';
	}
?>