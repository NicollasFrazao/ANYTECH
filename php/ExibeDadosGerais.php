<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '');
	
	//busca de informações da conta
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];
	
	$buscaDados = $conexaoPrincipal -> Query("select tb_usuario.nm_email, tb_usuario.nm_usuario_completo, tb_usuario.cd_cpf, tb_usuario.dt_nascimento, tb_cidade.cd_cidade, tb_estado.cd_estado from tb_usuario
																						inner join tb_endereco on tb_usuario.cd_usuario = tb_endereco.cd_usuario
																							inner join tb_cidade on tb_endereco.cd_cidade = tb_cidade.cd_cidade
																								inner join tb_estado on tb_cidade.cd_estado = tb_estado.cd_estado
																									where tb_usuario.cd_usuario = '$cod_usuario' ");
	$buscaDados = mysqli_fetch_assoc($buscaDados);
	
	$nascimento = explode("-",$buscaDados['dt_nascimento']);
	$nascimento = $nascimento[2]."/".$nascimento[1]."/".$nascimento[0];
	
	echo $buscaDados['nm_usuario_completo'] . "//" . $buscaDados['nm_email'] . "//" .$nascimento . "//" .$buscaDados['cd_cidade'] . "//" .$buscaDados['cd_estado']."//".$buscaDados['cd_cpf'] ;

?>