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
	$senha_atual = $_POST['senhaAtual'];
	$senha_nova =  base64_encode($_POST['senhaNova']);
	$senha_nova_confirmacao=  base64_encode($_POST['senhaNovaConfirmacao']);

	
	if( $senha_atual == $pass_usuario)
	{
		if($senha_nova == $senha_nova_confirmacao)
		{
			$alterando_usuario = $conexaoPrincipal -> Query("Update tb_usuario set  cd_senha = '$senha_nova' where cd_usuario = '$cod_usuario' ");
			echo "Senha alterada com sucesso!";
		}
		else
		{
			echo "As senhas não conferem!";	
		}
	}
	else
	{
		echo "Senha atual digitada incorretamente!";
	}
?>