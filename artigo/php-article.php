<?php
	define('VOLTAR', '../');
	session_start();
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	function ConfereQuebra()
	{
		switch (strtoupper(substr(PHP_OS, 0, 3))) 
		{
			// Windows
			case 'WIN':
			{
				$quebra = '\r\n';
			}
			break;

			// Mac
			case 'DAR':
			{
				$quebra = '\r';
			}
			break;
			
			// Linux
			case 'LIN':
			{
				$quebra = '\r\n';
			}
			break;

			// Unix
			default:
			{
				$quebra = '\n';
			}
		}
		
		return $quebra;
	}
	
	//echo strtoupper(substr(PHP_OS, 0, 3));
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;		
	}
	else
	{
		$logado = 1;
	}

	$link = $_SERVER['SCRIPT_NAME'];
	$link = explode('/', $link);
	$link = $link[count($link) - 1];

	$result_Artigo = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
													   tb_artigo.nm_titulo,
													   tb_artigo.ds_artigo,
													   tb_artigo.dt_criacao,
													   tb_artigo.ds_texto,
													   tb_artigo.ds_url,
													   tb_artigo.im_artigo,
													   tb_artigo.im_thumbnail,
													   tb_artigo.ic_autor_oculto,
													   tb_artigo.nm_fonte,
													   tb_artigo.ds_url_fonte,
													   tb_artigo.cd_usuario,
													   tb_artigo.ic_artigo_pendente,
													   (select sum(usuario_artigo_avaliar.qt_estrelas) / count(usuario_artigo_avaliar.cd_artigo) from usuario_artigo_avaliar where usuario_artigo_avaliar.cd_artigo = tb_artigo.cd_artigo) as qt_estrelas,
													   (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario, (select tb_usuario.nm_nickname from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_nickname,
													   (select tb_usuario.im_perfil from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as im_usuario,
														(select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
														(select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
														(select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
														(select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
														(select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar
												  from tb_artigo where ds_url = '$link'");
	$linha_Artigo = mysqli_fetch_assoc($result_Artigo);

	$codigoArtigo = $linha_Artigo['cd_artigo'];
	$titulo = $linha_Artigo['nm_titulo'];
	$descricaoArtigo = $linha_Artigo['ds_artigo'];
	$caminhoConteudo = $linha_Artigo['ds_texto'];
	$codigoAutor = $linha_Artigo['cd_usuario'];
	$imagemArtigo = $linha_Artigo['im_artigo'];
	$thumbnailArtigo = $linha_Artigo['im_thumbnail'];
	$dataArtigo = $linha_Artigo['dt_criacao'];
	$nomeAutor = $linha_Artigo['nm_usuario'];
	$nicknameAutor = $linha_Artigo['nm_nickname'];
	$imagemAutor = $linha_Artigo['im_usuario'];
	$autorOculto = $linha_Artigo['ic_autor_oculto'];
	$nomeFonte = $linha_Artigo['nm_fonte'];
	$urlFonte = $linha_Artigo['ds_url_fonte'];
	$artigoPendente = $linha_Artigo['ic_artigo_pendente'];
	
	if ($artigoPendente)
	{
		header('Location: '.VOLTAR);
	}

	$ponteiro = fopen($caminhoConteudo, 'r');

	$conteudo = fread($ponteiro, filesize($caminhoConteudo));
	$conteudo = base64_decode($conteudo);

	fclose($ponteiro);
	
	if (!isset($conteudo))
	{
		header('Location: ../');
		
		/*session_start();
		
		if (!isset($_SESSION['teste']))
		{
			$_SESSION['teste'] = 1;
		}
		else
		{
			$_SESSION['teste'] = $_SESSION['teste'] + 1;
		}
		
		echo $_SESSION['teste'];*/
	}
	else
	{
		if (isset($_SESSION['AnyTech']['codigoUsuario']))
		{
			$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
			
			$result_Usuario = $conexaoPrincipal -> Query("select nm_usuario_completo, im_perfil from tb_usuario where cd_usuario = '$codigoUsuario'");
			$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
			
			$nomeUsuario = $linha_Usuario['nm_usuario_completo'];
			$imagemUsuario = $linha_Usuario['im_perfil'];
		}
		
		$original = $conteudo;
		
		$aux = $original;
		$aux = explode('##Highlighter##', $aux);
		$editado = '<p class="post-text" id="fp">';
		
		for ($cont = 0; $cont <= count($aux) - 1; $cont = $cont + 1)
		{
			$mod = ($cont + 1)%2;
			
			if ($mod == 0)
			{
				$aux[$cont] = trim(htmlentities($aux[$cont], ENT_QUOTES, 'UTF-8'));
				$aux[$cont] = str_replace(ConfereQuebra(), '&#013', $aux[$cont]);
				$editado = $editado.$aux[$cont];//highlighter
			}
			else
			{
				$aux[$cont] = mysql_escape_string($aux[$cont]);
				$aux[$cont] = str_replace('\\"', '"', $aux[$cont]);
				$aux[$cont] = str_replace('\\\'', '\'', $aux[$cont]);
				$aux[$cont] = str_replace('\\\\', '\\', $aux[$cont]);
				
				$editado = $editado.str_replace(ConfereQuebra(), '</p><p class="post-text">', $aux[$cont]);
				//$editado = $editado.str_replace(ConfereQuebra(), '</p><p class="post-text">', $aux[$cont]);
			}
		}
		
		$editado = $editado.'</p>';
		
		//$editado = str_replace(ConfereQuebra(), '<br/>', $original);
		$texto = $editado;
		
		$result_Comentarios = $conexaoPrincipal -> Query("select tb_comentario_artigo.cd_comentario_artigo,
															   tb_comentario_artigo.dt_comentario_artigo,
															   tb_comentario_artigo.ds_conteudo,
															   tb_comentario_artigo.cd_usuario,
															   tb_comentario_artigo.cd_artigo,
															   tb_comentario_artigo.cd_replica,
															   tb_usuario.cd_usuario,
															   tb_usuario.nm_usuario_completo,
															   tb_usuario.im_perfil,
															   (select count(tb_avaliacao_comentario.cd_avaliacao_comentario) from tb_avaliacao_comentario where tb_avaliacao_comentario.cd_comentario = tb_comentario_artigo.cd_comentario_artigo) as 'qt_avaliacao'
														  from tb_comentario_artigo inner join tb_usuario
															on tb_comentario_artigo.cd_usuario = tb_usuario.cd_usuario
															  where tb_comentario_artigo.cd_artigo = '$codigoArtigo'
																order by tb_comentario_artigo.cd_comentario_artigo desc");
		$linha_Comentarios = mysqli_fetch_assoc($result_Comentarios);
		$total_Comentarios = mysqli_num_rows($result_Comentarios);
		
	}
?>