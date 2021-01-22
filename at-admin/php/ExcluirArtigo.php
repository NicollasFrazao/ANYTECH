<?php
	session_start();
	define('VOLTAR', '../../');
	include '../../php/Conexao.php';
	include '../../php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_POST['codigoArtigo']))
	{
		exit;
	}
	
	$codigoArtigo = mysql_escape_string($_POST['codigoArtigo']);
	
	$result_Artigo = $conexaoPrincipal -> Query("select ds_texto, ds_url from tb_artigo where cd_artigo = '$codigoArtigo'");
	$linha_Artigo = mysqli_fetch_assoc($result_Artigo);
	$total_Artigo = mysqli_num_rows($result_Artigo);
	
	if ($total_Artigo > 0)
	{
		$caminhoConteudo = $linha_Artigo['ds_texto'];
		
		if ($caminhoConteudo != '')
		{
			$caminhoConteudo = '../../artigo/'.$caminhoConteudo;
			
			if (file_exists($caminhoConteudo))
			{
				unlink($caminhoConteudo);
			}
		}
		
		$caminhoLink = $linha_Artigo['ds_url'];
		
		if ($caminhoLink != '')
		{
			$caminhoLink = '../../artigo/'.$caminhoLink;
			
			if (file_exists($caminhoLink))
			{
				unlink($caminhoLink);
			}
		}
	}
	
	$result = $conexaoPrincipal -> Query("delete from tb_artigo where cd_artigo = '$codigoArtigo'");
	
	if ($result)
	{
		header('Location: '.VOLTAR.'news');
	}
	else
	{
		echo mysqli_error($conexaoPrincipal -> getConexao());
		exit;
	}
	
?>

<html>
	<head>
		<title>ANYTECH - Excluindo artigo...</title>
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png" alt="ANYTECH"/>
	</head>
	<body>
		Artigo excluído com sucesso!
	</body>
</html>