<?php
	session_start();
	define('VOLTAR', '../');
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;
	}
	else
	{
		$logado = 1;
		
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
			
		$result_Usuario = $conexaoPrincipal -> Query("select nm_usuario_completo, im_perfil, cd_nivel_cadastro from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
		
		$nomeUsuario = $linha_Usuario['nm_usuario_completo'];
		$imagemUsuario = $linha_Usuario['im_perfil'];
		$nivelCadastro = $linha_Usuario['cd_nivel_cadastro'];
		
		if ($nivelCadastro < 4)
		{
			header('Location: '.VOLTAR.'signup/');
		}
	}
	
	include 'feed.php';
?>