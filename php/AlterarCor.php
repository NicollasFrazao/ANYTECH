<?php
	error_reporting(0);
	ini_set(“display_errors”, 0 );

	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '');
	
	
	//busca de informações da conta
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];

	$cor_Menu = $_POST['cor_Menu'];
	$cor_Background = $_POST['cor_Background'];
	$cor_Header = $_POST['cor_Header'];
	

	
	
	if($cor_Menu != "" )
	{
		$salvarcorMenu = $conexaoPrincipal->query(" update tb_usuario set ds_cor_menu = '$cor_Menu' where cd_usuario = '$cod_usuario' ") or die("Erro ao salvar!");			
	}
	
	if($cor_Background != "")
	{
		$salvarcorBackground = $conexaoPrincipal->query(" update tb_usuario set ds_cor_background = '$cor_Background' where cd_usuario = '$cod_usuario' ") or die("Erro ao salvar!");		
	}
	
	if($cor_Header != ""){
		$salvarcorBarra = $conexaoPrincipal->query(" update tb_usuario set ds_cor_barra = '$cor_Header' where cd_usuario = '$cod_usuario' ") or die("Erro ao salvar!");		
	}
	
	
	echo "Alterações salvas!";
	
	
	
?>