<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	if (!isset($_GET['codigoArtigo']))
	{
		exit;
	}
	
	$usercode = $_SESSION['AnyTech']['codigoUsuario'];
	
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	
	$result = $conexaoPrincipal -> Query("select sum(usuario_artigo_avaliar.qt_estrelas) / count(usuario_artigo_avaliar.cd_artigo) as qt_aval from usuario_artigo_avaliar where usuario_artigo_avaliar.cd_artigo = '$codigoArtigo'");
	$linha = mysqli_fetch_assoc($result);
	
	
	
	if($linha['qt_aval'] != null)
	{
		echo $linha['qt_aval'];
	}
	else
	{
		echo "5.0";
	}
	
	$resultstar = $conexaoPrincipal -> Query("select qt_estrelas from usuario_artigo_avaliar where cd_usuario = '$usercode' and cd_artigo = '$codigoArtigo'");
	$linhaST = mysqli_fetch_assoc($resultstar);
	
	if($linhaST['qt_estrelas'] != null)
	{
		echo '&'.$linhaST['qt_estrelas'];
	}
	else
	{
		echo "&0";
	}
	
	$resultLeitura = $conexaoPrincipal -> Query("SELECT cd_visita FROM tb_visita where cd_usuario = '$usercode' and cd_artigo = '$codigoArtigo' limit 1;");
	$linhaLeitura = mysqli_fetch_assoc($resultLeitura);
	if($linhaLeitura['cd_visita'] != null)
	{
		echo "&1";
	}
	else
	{
		echo "&".$linhaLeitura['cd_visita'];
	}
	
?>