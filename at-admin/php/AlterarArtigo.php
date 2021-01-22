<?php
	session_start();
	define('VOLTAR', '../../');
	include '../../php/Conexao.php';
	include '../../php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_POST['titulo']) || !isset($_POST['texto']) || !isset($_POST['descricao']) || !isset($_POST['codigoArtigo']))
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
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$titulo = mysql_escape_string($_POST['titulo']);
	$texto = $_POST['texto'];
	$descricao = mysql_escape_string($_POST['descricao']);
	$banner = mysql_escape_string($_POST['banner']);
	$thumbnail = mysql_escape_string($_POST['thumbnail']);
	$autorOculto = (isset($_POST['oculto'])) ? mysql_escape_string($_POST['oculto']) : 0;
	$artigoPendente = (isset($_POST['pendente'])) ? mysql_escape_string($_POST['pendente']) : 0;
	$nomeFonte = mysql_escape_string($_POST['nomeFonte']);
	$urlFonte = mysql_escape_string($_POST['urlFonte']);
	$tagsArtigo = mysql_escape_string($_POST['tags']);
	$tagsArtigo = explode(';', $tagsArtigo);
	$dataArtigo = mysql_escape_string($_POST['data']);
	
	$dataArtigo = explode('-', $dataArtigo);
	$aux = explode('/', trim($dataArtigo[0]));
	$dataArtigo = $aux[2].'-'.$aux[1].'-'.$aux[0].' '.$dataArtigo[1];
	
	$descricao = substr($descricao, 0, 247);
	
	$texto = base64_encode($texto);
	
	function sanitizeString($str) 
	{
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		// $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
		$str = preg_replace('/[^a-z0-9]/i', '_', $str);
		$str = preg_replace('/_+/', '-', $str); // ideia do Bacco :)
		return $str;
	}
	
	$caminho = $titulo;
	$caminho = sanitizeString($caminho);
	$caminho = str_replace(' - ', ' ', $caminho);
	$caminho = str_replace('- ', ' ', $caminho);
	$caminho = str_replace(' -', ' ', $caminho);
	$caminho = str_replace(' ', '-', $caminho);
	$caminho = str_replace('/', '-', $caminho);
	$caminho = str_replace('\\', '-', $caminho);
	$caminho = str_replace(':', '', $caminho);
	$caminho = str_replace('*', '', $caminho);
	$caminho = str_replace('?', '', $caminho);
	$caminho = str_replace('|', '', $caminho);
	$caminho = str_replace('<', '', $caminho);
	$caminho = str_replace('>', '', $caminho);
	$caminho = str_replace('\'', '', $caminho);
	$caminho = str_replace('"', '', $caminho);
	$caminho = str_replace('#', '', $caminho);
	$caminho = strtolower($caminho);
	
	if ($thumbnail != '')
	{
		$aux = $thumbnail;
		$aux = explode('/', $aux);
		$caminhoArquivo = $aux;
		$nomeArquivo = $aux[count($aux) - 1];
		$nomeArquivo = explode('.', $nomeArquivo);
		$extensao = $nomeArquivo[count($nomeArquivo) - 1];
		
		$caminhoArquivo = '';
		for ($cont = 0; $cont < count($aux) - 1; $cont = $cont + 1)
		{
			if ($cont == 0)
			{
				$caminhoArquivo = $aux[$cont];
			}
			else
			{
				$caminhoArquivo = $caminhoArquivo.'/'.$aux[$cont];
			}
		}
		
		$aux = $nomeArquivo;
		$nomeArquivo = '';
		for ($cont = 0; $cont < count($aux) - 1; $cont = $cont + 1)
		{
			if ($cont == 0)
			{
				$nomeArquivo = $aux[$cont];
			}
			else
			{
				$nomeArquivo = $nomeArquivo.'.'.$aux[$cont];
			}
		}
		
		$nomeArquivo = 'anytech';
		
		foreach ($tagsArtigo as $tag)
		{
			$result = $conexaoPrincipal -> Query("select nm_tema from tb_tema where cd_tema = '$tag'");
			$linha = mysqli_fetch_assoc($result);
			
			$aux = $linha['nm_tema'];
			$aux = strtolower(sanitizeString($aux));
			
			$nomeArquivo = $nomeArquivo.'-'.$aux;
		}
		
		$nomeArquivo = $nomeArquivo.'-'.$caminho.'-'.'thumbnail';
		
		if (rename(VOLTAR.$thumbnail, VOLTAR.$caminhoArquivo.'/'.$nomeArquivo.'.'.$extensao))
		{
			$thumbnail = $caminhoArquivo.'/'.$nomeArquivo.'.'.$extensao;
		}
	}
	
	if ($banner != '')
	{
		$aux = $banner;
		$aux = explode('/', $aux);
		$caminhoArquivo = $aux;
		$nomeArquivo = $aux[count($aux) - 1];
		$nomeArquivo = explode('.', $nomeArquivo);
		$extensao = $nomeArquivo[count($nomeArquivo) - 1];
		
		$caminhoArquivo = '';
		for ($cont = 0; $cont < count($aux) - 1; $cont = $cont + 1)
		{
			if ($cont == 0)
			{
				$caminhoArquivo = $aux[$cont];
			}
			else
			{
				$caminhoArquivo = $caminhoArquivo.'/'.$aux[$cont];
			}
		}
		
		$aux = $nomeArquivo;
		$nomeArquivo = '';
		for ($cont = 0; $cont < count($aux) - 1; $cont = $cont + 1)
		{
			if ($cont == 0)
			{
				$nomeArquivo = $aux[$cont];
			}
			else
			{
				$nomeArquivo = $nomeArquivo.'.'.$aux[$cont];
			}
		}
		
		$nomeArquivo = 'anytech';
		
		foreach ($tagsArtigo as $tag)
		{
			$result = $conexaoPrincipal -> Query("select nm_tema from tb_tema where cd_tema = '$tag'");
			$linha = mysqli_fetch_assoc($result);
			
			$aux = $linha['nm_tema'];
			$aux = strtolower(sanitizeString($aux));
			
			$nomeArquivo = $nomeArquivo.'-'.$aux;
		}
		
		$nomeArquivo = $nomeArquivo.'-'.$caminho.'-'.'banner';
		
		//echo VOLTAR.$caminhoArquivo.'/'.$nomeArquivo.'.'.$extensao;
		
		if (rename(VOLTAR.$banner, VOLTAR.$caminhoArquivo.'/'.$nomeArquivo.'.'.$extensao))
		{
			$banner = $caminhoArquivo.'/'.$nomeArquivo.'.'.$extensao;
		}
	}
	
	//$caminho = $caminho.'-'.date("dmYHis");
	
	$caminho = $caminho.'-'.$codigoArtigo;
	
	while (strpos($caminho, '--') !== false)
	{
		$caminho = str_replace('--', '-', $caminho);
	}
	
	$caminhoPasta = '../../artigo/';
	$caminhoPastaBanco = 'artigo/';
	
	$conteudo = '<?php include \'php-article.php\'; ?> <?php include \'article.php\'; ?> <?php $conexaoPrincipal -> FecharConexao(); ?>';
	
	$caminhoPastaTXT = $caminhoPasta.$caminho.'.txt';
	$caminhoPastaPHP = $caminhoPasta.$caminho.'.php';
	$caminhoPastaBancoTXT = $caminho.'.txt';
	$caminhoPastaBancoPHP = $caminho.'.php';
	
	/*$caminhoPastaTXT = $caminhoPasta.$linha_Artigo['ds_texto'];
	$caminhoPastaPHP = $caminhoPasta.$linha_Artigo['ds_url'];
	$caminhoPastaBancoTXT = $linha_Artigo['ds_texto'];
	$caminhoPastaBancoPHP = $linha_Artigo['ds_url'];*/
	
	$result = $conexaoPrincipal -> Query("update tb_artigo set nm_titulo = '$titulo', ds_texto = '$caminhoPastaBancoTXT', ds_url = '$caminhoPastaBancoPHP', ds_artigo = '$descricao', im_artigo = ".(($banner != '') ? "'$banner'" : "null").", im_thumbnail = ".(($thumbnail != '') ? "'$thumbnail'" : "null").", ic_autor_oculto = ".(($autorOculto == 1) ? '1' : '0').", ic_artigo_pendente = ".(($artigoPendente == 1) ? '1' : '0').", nm_fonte = ".(($nomeFonte != '') ? "'$nomeFonte'" : "null").", ds_url_fonte = ".(($urlFonte != '') ? "'$urlFonte'" : "null").", dt_criacao = ".(($dataArtigo != '') ? "'$dataArtigo'" : "null")." where cd_artigo = '$codigoArtigo'");
	
	if ($result)
	{
		$ponteiro = fopen($caminhoPastaPHP, 'w');
		fwrite($ponteiro, $conteudo);
		fclose($ponteiro);
		
		$ponteiro = fopen($caminhoPastaTXT, 'w');
		fwrite($ponteiro, $texto);
		fclose($ponteiro);
		
		$result = $conexaoPrincipal -> Query("delete from artigo_tema_tag where cd_artigo = '$codigoArtigo'");
		
		if ($result)
		{
			$query = "insert into artigo_tema_tag(cd_artigo, cd_tema) values";
			$cont = 0;
			
			if (count($tagsArtigo) > 0 && $tagsArtigo[0] != '')
			{
				foreach ($tagsArtigo as $tag)
				{
					if ($cont == 0)
					{
						$query = $query."('$codigoArtigo', '$tag')";
					}
					else
					{
						$query = $query.", ('$codigoArtigo', '$tag')";
					}
					
					$cont = $cont + 1;
				}
				
				$result = $conexaoPrincipal -> Query($query);
				
				if ($result)
				{
					//header('Location: ../../artigo/'.urlencode($caminhoPastaBancoPHP));
				}
				else
				{
					echo mysqli_error($conexaoPrincipal -> getConexao());
				}
			}
			else
			{
				//header('Location: ../../artigo/'.urlencode($caminhoPastaBancoPHP));
			}			
		}
		
	}
	else
	{
		echo mysqli_error($conexaoPrincipal -> getConexao());
		exit;
	}
	
?>

<html>
	<head>
		<title>ANYTECH - Processando dados do artigo</title>
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png" alt="ANYTECH"/>
	</head>
	<body>
		Aguarde...
	</body>
	<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
	<script>	
		window.onload = function()
		{
			if ('<?php echo $_SERVER['HTTP_HOST'] ?>' == 'localhost' || '<?php echo $_SERVER['HTTP_HOST'] ?>' == '127.0.0.1')				
			{
				window.location.href = '<?php echo VOLTAR.'artigo/'.urlencode($caminhoPastaBancoPHP); ?>';	
			}
			else
			{
				try
				{
					Ajax("GET", "https://graph.facebook.com/", "id=" + "https://<?php echo /*str_replace('www.', '', $_SERVER['HTTP_HOST'])*/$_SERVER['HTTP_HOST'].'/artigo/'.$caminhoPastaBancoPHP; ?>" + "&scrape=true&method=post", "/*var retorno = this.responseText; alert(retorno);*/ window.location.href = '<?php echo VOLTAR.'artigo/'.urlencode($caminhoPastaBancoPHP); ?>';");
					// Pegar quantidade de comentários e likes e tals Ajax("GET", "https://graph.facebook.com/", "id=" + window.location.href + "&scrape=true&method=get", "");
					
					//setTimeout("Facebook();", 5000);
				}
				catch (exe)
				{
					window.location.href = '<?php echo VOLTAR.'artigo/'.urlencode($caminhoPastaBancoPHP); ?>';
				}
			}
		}
	</script>
</html>