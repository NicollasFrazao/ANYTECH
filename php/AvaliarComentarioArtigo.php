<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_POST['codigoComentario']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigoComentario = mysql_escape_string($_POST['codigoComentario']);
	
	$result_Avaliacao = $conexaoPrincipal -> Query("select cd_usuario, cd_comentario from tb_avaliacao_comentario where cd_usuario = '$codigoUsuario' and cd_comentario = '$codigoComentario'");
	$total_Avaliacao = mysqli_num_rows($result_Avaliacao);
	
	if ($total_Avaliacao > 0)
	{
		$result = $conexaoPrincipal -> Query("delete from tb_avaliacao_comentario where cd_usuario = '$codigoUsuario' and cd_comentario = '$codigoComentario'");
	}
	else
	{
		$result = $conexaoPrincipal -> Query("insert into tb_avaliacao_comentario(cd_usuario, cd_comentario) values ('$codigoUsuario', '$codigoComentario')");
	}
	
	if ($result)
	{
		$result_Avaliacao = $conexaoPrincipal -> Query("select cd_usuario, cd_comentario from tb_avaliacao_comentario where cd_comentario = '$codigoComentario'");
		$total_Avaliacao = mysqli_num_rows($result_Avaliacao);
		
		echo '1;-;'.$total_Avaliacao;
	}
	else
	{
		echo '0;-;0';
	}
?>