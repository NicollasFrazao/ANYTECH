<?php
	include 'Conexao.php';
	session_start();
	define('VOLTAR', '');
	
	$host = 'localhost';
	$user = 'root';
	$pass = 'root';
	$banco = 'db_anytech';

	$conexaoPrincipal = new Conexao();
	$conexaoPrincipal -> AbrirConexao($host, $user, $pass, $banco);
	
	//busca de informações da conta
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];
	
	//Value do estado
	$estado = $_POST['Estado'];
	$buscaCidade = $conexaoPrincipal->query("select * from tb_cidade where cd_estado = '$estado' ");
	$buscaCidadeQtd = mysqli_num_rows($buscaCidade);
	$arrCidade = mysqli_fetch_array($buscaCidade);
		
	do{
		echo $arrCidade['cd_cidade']."/".$arrCidade['nm_cidade']."|";
	}
	while($arrCidade = mysqli_fetch_array($buscaCidade))
	
?>