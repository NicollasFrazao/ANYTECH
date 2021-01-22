<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_GET['codigoArtigo']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	
	$result = $conexaoPrincipal -> Query("select * from usuario_artigo_leitura where cd_usuario = '$codigoUsuario' and cd_artigo = '$codigoArtigo'");
	$total = mysqli_num_rows($result);
	
	if ($total == 0)
	{
		$result = $conexaoPrincipal -> Query("insert into usuario_artigo_leitura(cd_usuario, cd_artigo, dt_leitura) values('$codigoUsuario', '$codigoArtigo', now())");
		
		if ($result)
		{
			echo 1;
		}
	}
	else
	{
		$result = $conexaoPrincipal -> Query("delete from usuario_artigo_leitura where cd_usuario = '$codigoUsuario' and cd_artigo = '$codigoArtigo'");
		
		if ($result)
		{
			echo 0;
		}
	}
?>