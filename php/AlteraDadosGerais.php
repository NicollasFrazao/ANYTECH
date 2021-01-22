<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '');
	
	//busca de informações da conta
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];

	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$cpf = $_POST['cpf'];
	$datanas = $_POST['datanas'];
	$telefone = $_POST['telefone'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	
	$nascimento = explode("/",$datanas);
	$nascimento = $nascimento[2]."-".$nascimento[1]."-".$nascimento[0];
	
	$alteraDadosUsuario = $conexaoPrincipal->query("Update tb_usuario set nm_usuario_completo = '$nome', nm_email = '$email', cd_cpf = '$cpf', dt_nascimento = '$nascimento' where cd_usuario = '$cod_usuario' ");
	$alteraEndereco = $conexaoPrincipal->query("Update tb_endereco set cd_cidade = '$cidade' where cd_usuario = '$cod_usuario' ");
	echo "Alterações feitas com sucesso."
?>