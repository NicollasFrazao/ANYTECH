<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '');
	
	//dados da mensagem
	$mensagem_nome = $_POST['Nome'];
	$mensagem_email = $_POST['Email'];
	$mensagem_assunto = $_POST['Assunto'];
	$mensagem_mensagem = $_POST['Mensagem'];
	$mensagem_cod_usuario = $_POST['Codigo'];
	$mensagem_Interno_Externo = $_POST['InternoExterno'];
	$mensagem_destinatario = $_POST['Destinatario'];
	
	$enviaMensagem = $conexaoPrincipal->query("insert into tb_mensagem (nm_usuario,nm_email,nm_assunto,ds_mensagem,ic_interno_externo,cd_usuario,cd_destinatario) values
																								('$mensagem_nome','$mensagem_email','$mensagem_assunto','$mensagem_mensagem','$mensagem_Interno_Externo','$mensagem_cod_usuario','$mensagem_destinatario')")or die("Mensagem Não Enviada") ;
																						
echo "Mensagem Enviada com Sucesso.";
?>