<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_GET['email']))
	{
		exit;
	}
	
	$email = mysql_escape_string($_GET['email']);
	
	$result = $conexaoPrincipal -> Query("select cd_usuario, nm_usuario_completo, nm_nickname, nm_email, nm_sexo, dt_cadastro from tb_usuario where nm_email = '$email'");
	$linha = mysqli_fetch_assoc($result);
	$total = mysqli_num_rows($result);
	
	do
	{
		echo $linha['cd_usuario'].';'.$linha['nm_usuario_completo'].';'.$linha['nm_nickname'].';'.$linha['nm_email'].';'.$linha['nm_sexo'].';'.date('d/m/Y', strtotime($linha['dt_cadastro']));
	}
	while ($linha = mysqli_fetch_assoc($result));
?>