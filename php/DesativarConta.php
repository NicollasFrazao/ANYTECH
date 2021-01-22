<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '');
	
	//busca de informações da conta
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];
	$pass_usuario = $conexaoPrincipal ->query("Select cd_senha from tb_usuario where cd_usuario = '$cod_usuario'");
	$pass_usuario = mysqli_fetch_assoc($pass_usuario);
	$pass_usuario = base64_decode($pass_usuario['cd_senha']);
	
	//info digitada pelo usuario
	$senha = $_POST['passwordConfirm'];
	$motivo = $_POST['motivoConfirm'];
	
	if($senha == $pass_usuario){
		$desativaConta = $conexaoPrincipal->query("update tb_usuario set ic_conta_ativa = 1 where cd_usuario = '$cod_usuario' ");		
		echo "Sua conta foi desativada. Você pode reativar sua conta acessando com o mesmo login dentro dos próximos 60 dias.";
	}
	else
	{
		echo "Senha incorreta!";		
	}
	
?>