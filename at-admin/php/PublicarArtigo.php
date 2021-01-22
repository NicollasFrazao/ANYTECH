<?php
	session_start();
	define('VOLTAR', '../../');
	include '../../php/Conexao.php';
	include '../../php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_POST['titulo']) || !isset($_POST['texto']) || !isset($_POST['descricao']))
	{
		exit;
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
	
	$result = $conexaoPrincipal -> Query("select cd_artigo from tb_artigo order by cd_artigo desc limit 1");
	
	if (mysqli_num_rows($result) == 0)
	{
		$codigo = 0;
	}
	else
	{
		$linha = mysqli_fetch_assoc($result);
		$codigo = $linha['cd_artigo'] + 1;
	}
	
	$caminho = $caminho.'-'.$codigo;
	
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
	
	$result = $conexaoPrincipal -> Query("insert into tb_artigo(nm_titulo, ds_texto, ds_url, ds_artigo, im_artigo, im_thumbnail, cd_usuario, ic_autor_oculto, ic_artigo_pendente, nm_fonte, ds_url_fonte, dt_criacao) values('$titulo', '$caminhoPastaBancoTXT', '$caminhoPastaBancoPHP', '$descricao', ".(($banner != '') ? "'$banner'" : "null").", ".(($thumbnail != '') ? "'$thumbnail'" : "null").", '$codigoUsuario', ".(($autorOculto == 1) ? '1' : '0').", ".(($artigoPendente == 1) ? '1' : '0').", ".(($nomeFonte != '') ? "'$nomeFonte'" : "null").", ".(($urlFonte != '') ? "'$urlFonte'" : "null").", ".(($dataArtigo != '') ? "'$dataArtigo'" : "null").")");
	
	if ($result)
	{
		$ponteiro = fopen($caminhoPastaPHP, 'w');
		fwrite($ponteiro, $conteudo);
		fclose($ponteiro);
		
		$ponteiro = fopen($caminhoPastaTXT, 'w');
		fwrite($ponteiro, $texto);
		fclose($ponteiro);
		
		$result = $conexaoPrincipal -> Query("select cd_artigo from tb_artigo where ds_texto = '$caminhoPastaBancoTXT'");
		$linha = mysqli_fetch_assoc($result);
		
		$codigoArtigo = $linha['cd_artigo'];
		
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
		
		$posting = '<script>window.open("https://www.google.com/webmasters/tools/submit-url?", "_blank");window.open("https://trello.com/b/Odilp3BI/anytech", "_blank");</script>';

		echo $posting;
	}
	else
	{
		echo mysqli_error($conexaoPrincipal -> getConexao());
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