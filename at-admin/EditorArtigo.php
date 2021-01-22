<?php
	session_start();
	define('VOLTAR', '../');
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;
		$cod_usuario = "null";
		$linha_Usuario['nm_usuario_completo'] = "";
		$linha_Usuario['nm_email'] = "";
		
		header('location: '.VOLTAR.'/login?url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	}
	else
	{
		$logado = 1;
		
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
		$nivelUsuario = $_SESSION['AnyTech']['nivelUsuario'];
		
		if (!($nivelUsuario > 1))
		{
			header('location: '.VOLTAR.'index.php');
		}
		
		$result_Usuario = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, im_perfil, cd_nivel_cadastro from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
		
		$nomeUsuario = $linha_Usuario['nm_usuario_completo'];
		$imagemUsuario = $linha_Usuario['im_perfil'];
		$nivelCadastro = $linha_Usuario['cd_nivel_cadastro'];
		
		if ($nivelCadastro < 4)
		{
			header('Location: '.VOLTAR.'signup/');
		}
	}
	
	$artigoEncontrado = 0;
	
	if (isset($_GET['codigoArtigo']))
	{
		$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
		
		$result_Artigo = $conexaoPrincipal -> Query("select tb_artigo.nm_titulo, 
															tb_artigo.ds_artigo, 
															tb_artigo.ds_texto,
															tb_artigo.im_artigo,
															tb_artigo.im_thumbnail,
															tb_artigo.nm_fonte,
															tb_artigo.ds_url_fonte,
															tb_artigo.ic_autor_oculto,
															tb_artigo.ic_artigo_pendente,
															tb_artigo.dt_criacao,
															(select group_concat(tb_tema.cd_tema) from tb_artigo as tb_artigo_tags inner join artigo_tema_tag on tb_artigo_tags.cd_artigo = artigo_tema_tag.cd_artigo inner join tb_tema on artigo_tema_tag.cd_tema = tb_tema.cd_tema where tb_artigo_tags.cd_artigo = tb_artigo.cd_artigo) as ds_tags
														from tb_artigo where cd_artigo = '$codigoArtigo'");
		$linha_Artigo = mysqli_fetch_assoc($result_Artigo);
		$total_Artigo = mysqli_num_rows($result_Artigo);
		
		if ($total_Artigo > 0)
		{
			$artigoEncontrado = 1;
			
			$tituloArtigo = $linha_Artigo['nm_titulo'];
			$descricaoArtigo = $linha_Artigo['ds_artigo'];
			$nomeArquivoConteudo = $linha_Artigo['ds_texto'];
			$bannerArtigo = $linha_Artigo['im_artigo'];
			$thumbnailArtigo = $linha_Artigo['im_thumbnail'];
			$autorOculto = $linha_Artigo['ic_autor_oculto'];
			$artigoPendente = $linha_Artigo['ic_artigo_pendente'];
			$nomeFonte = $linha_Artigo['nm_fonte'];
			$dataCriacao = $linha_Artigo['dt_criacao'];
			$urlFonte = $linha_Artigo['ds_url_fonte'];
			$tagsArtigo = $linha_Artigo['ds_tags'];
			$tagsArtigo = str_replace(',', ';', $tagsArtigo);
			
			$caminhoArquivoConteudo = VOLTAR.'artigo/'.$nomeArquivoConteudo;
			$ponteiro = fopen($caminhoArquivoConteudo, 'r');
			$conteudoArtigo = fread($ponteiro, filesize($caminhoArquivoConteudo));
			$conteudoArtigo = base64_decode($conteudoArtigo);
		}
		else
		{
			$artigoEncontrado = 0;
			echo 'Artigo não encontrado!';
			exit;
		}
	}
?>

<!Doctype HTML>

<html>
	<head>
		<?php
			include VOLTAR.'php/CoresGoogle.php';
		?>
		
		<meta charset="UTF-8">
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png" alt="ANYTECH"/>
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-index.css">
		<link rel="stylesheet" type="text/css" href="css/anytech-style-article.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed.css">
		
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shCore.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushCpp.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushCSharp.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushCss.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushSql.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushXml.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushPlain.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushJava.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushJScript.js"></script>
		<script type="text/javascript" src="<?php echo VOLTAR; ?>artigo/highlighter/scripts/shBrushPHP.js"></script>
		<link type="text/css" rel="stylesheet" href="<?php echo VOLTAR; ?>artigo/highlighter/styles/shCoreDefault.css"/>
		
		<title>ANYTECH - Editor de Artigos<?php if ($artigoEncontrado == 1) {echo ' - '.$tituloArtigo;} ?></title>
		
		<style>
			*
			{
				margin: 0px;
				padding: 0px;
				font-family: century gothic;
			}
			
			::-webkit-scrollbar
			{
				height: 5px;
				width: 4px;
				background: rgb(242,242,242);
			}

			::-webkit-scrollbar-thumb
			{
				background: #ccc;
			}

			::-webkit-scrollbar-corner
			{
				background: #333;
			}
			
			html, body
			{
				width: 100%;
				height: 100%;
				overflow: hidden;
			}
			
			
			.topbar
			{
				display: inline-block;
				width: 100%;
				height: 10%;
				position:absolute;
				z-index: 9999;
				background-color: rgb(0,112,192);
			}
			
			
			#txt_post
			{
				text-align: justify;
				display: inline-block;
				background-color: white;
				width: 50%;
				height: 75.5%;
				max-height: 75.5%;
				padding:5%;
				padding-left:7.5%;
				padding-right:7.5%;
				/*margin-top:6.25%;*/
				letter-spacing: 0.03em;
				line-height: 1.5em;
				outline: none;
				overflow: auto;
				position:absolute;
				right: 10px;
				border: 0px;
			}
			
			.button-box
			{
				display: block;
				width: 35%;
				height: auto;
				margin-top:7.5%;
				background-color: transparent;
				position:absolute;
				bottom: 0px;
			}
			
			.at-button
			{
				display: inline-block;
				width: 7.5%;
				margin:2.5%;
				margin-top:2.5%;
				padding:5px;
				background-color: #fff;
				box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
				outline: none;
			}
			
			.at-button:hover
			{
				background-color: rgb(0,112,192);
				-webkit-filter: brightness(2) grayscale(1);
			}
			
			.at-title
			{
				display: inline-block;
				width: 85%;
				padding: 5%;
				padding-top: 2.5%;
				padding-bottom: 2.5%;
				margin-left:2.5%;
				margin-bottom: 20px;
				background-color: transparent;
				border: 0px;
				outline: none;
				border-bottom: 1px solid #777;
			}
			
			.at-leg
			{
				margin-left:2.5%;
			}
			
			.titleapp
			{
				display: inline-block;
				background-color: transparent;
				color: white;
				padding-top: 2.5%;
				margin-left: 7%;
			}
			
			.menu-btn
			{
				display: inline-block;
				position: absolute;
				height: 70%;
				background-color: transparent;
				left: 0.5%;
				top: 15%;
			}
			
			.menu-info
			{
				display: inline-block;
				width: 100%;
				height: 90%;
				top:10%;
				background-color: rgba(233,233,233,0.7);
				position: fixed;
				/*z-index: 9999;*/
			}
			
			#editado pre
			{
				width: 100%;
				white-space: pre-wrap;
				white-space: moz-pre-wrap;
				white-space: -pre-wrap;
				white-space: -o-pre-wrap;
				word-wrap: break-word;
			}
			
			#preview .voltar
			{
				position: fixed;
				bottom: 20px;
				right: 20px;
			}
			
			#preview .voltar .at-button
			{
				width: 50px;
			}
			
			u
			{
				text-decoration: underline;
			}
			
			.selectTags
			{
				display: none;
				width: 80%;
				height: 500px;
				top: 50%;
				margin-top: -250px;
				margin-left: 10%;
				background-color:white;
				position: absolute;
				z-index: 9999;
			}
			
			.titletags
			{
				display: inline-block;
				width: 98%;
				height: 6%;
				background-color: rgb(4, 28, 92);
				color: white;
				padding-left: 2%;
				padding-top: 5px;
			}
			
			.bodytag
			{
				display: inline-block;
				width:96%;
				padding: 2%;
				height:80%;
				overflow: auto;
			}
			
			.buttonstag
			{
				display: inline-block;
				width: 100%;
				height: 10%;
				background-color: rgb(4, 28, 92);
				color: white;
			}
			
			.btntag
			{
				display: inline-block;
				width: 100px;
				height: 50px;
				align: right;
			}
			
			.tagopt
			{
				display: inline-block;
				width: 100%;
				padding:10px;
			}
			
			.tagopt:hover
			{
				background-color: #eee;
			}
			
			.tagopt label
			{
				padding-left: 20px;
				font-size: 1em;
			}
			
			.tagopt input
			{
				width: 25px
				height: 25px;
			}
			
			.cancel
			{
				color: white;
				background-color: transparent;
			}
			
			.cancel:hover
			{
				color: white;
				background-color: rgba(255,255,255,0.2);
			}
			
			.save
			{
				color: white;
				background-color: rgb(0,112,192);
			}
			
			.save:hover
			{
				color: white;
				background-color: rgb(0,112,192, 0.8);
			}
			
			.cover
			{
				display: none;
				position: fixed;
				width: 100%;
				height: 100%;
				background-color: rgba(0,0,0,0.8);
				top: 0;
				left: 0;
				z-index: 9998;
			}
			
			.anytech-favorite-button
			{
				display: inline-block;
				width: 48%;
				margin-bottom: 5px;
				padding: 1%;
				color: black;
				background-color: #eee;
				text-align: left;
				
			}

			.anytech-favorite-button:hover, .tag.ativo
			{
				background-color: rgb(0,112,192);
				color: white;
				font-weight: bold;
			}
			
			.txtftn
			{
				width: 96%;
				padding:2%;
				margin-bottom: 15px;
				background-color: #EEE;
			}
			
			.at-titulo
			{
				display: inline-block;
				width: 300px;
				margin: 15px;
				padding: 2%;
			}
			
			.at-desc
			{
				display: inline-block;
				width: 300px;
				height: 300px;
				margin: 15px;
				padding: 2%;
				resize: none;
			}
			
			.artImages
			{
				display: inline-block;
			}
			
			#btn_capa
			{			
				display: inline-block;
				margin-top:10px;
			}
			
			#btn_thumb
			{
				display: none;
				margin-top:10px;
			}
			
			.button-box
			{
				background-color: rgb(0,112,192);
				position: absolute;
				width: 100%;
				height: 35px;
				top: 0px;
				margin-top: 0px;
			}
			
			.at-button
			{
				width: 15px;
				height: 15px;
				margin-left: 5px;
				margin-right: 5px;
				margin-top: 4px;				
			}
			
			#editor
			{
				position: fixed;
				top: 70px;
			}
			
			#txt_post
			{
				position: absolute;
				top: 35px;
				width:60%;
				margin-top: 0px;
				left:12.5%;				
				height: 90%;
			}
			
			.frmart
			{
				background-color: rgba(0,0,0,0.7);
				width: 350px;
			    left: -350px;
				margin-top: 35px;
				height: 100%;
				z-index: 9999;
				transition: left 1s;
				position: absolute;
			}
			
			#btnspb, #btn-excluir
			{
				display: inline-block;
				width: auto;
				height: auto;
				margin-left: 15px;
				padding: 2%;
				background-color: rgb(0,112,192);
				color: white;
			}
			
			#btnspb:hover
			{
				background-color: #08c7ff;
			}
			
			#editor
			{
				height: 100%;
			}
			
			#txt_post
			{
				padding-bottom: 200px;
			}
		</style>
	</head>
	<body style="background-color:#eee">
		<?php
			if ($logado == 1)
			{
				include VOLTAR.'topbar-on.php';
				include VOLTAR.'menu.php';
			}
			else
			{
				include VOLTAR.'topbar-off.php';
			}
		?>
		<!--<div class="topbar" valign="center">
			<input type="image" src="images/menu.png" class="menu-btn">
			<label class="titleapp"  valign="center"><b>SCRIPTECH: </b>Criando bla bla bla não sei onde... <b>[Não publicado]</b></label>	-->
			
		</div>
		<div class="cover" id="coverid">
		
		</div>
		
		<div id="preview" style="display: none; width: 100%;">
			<div id="bannerPreview" class="anytech-art-image" style="background-image: <?php if (isset($imagemArtigo)) {echo 'url(\''.VOLTAR.$imagemArtigo.'\')';} else {echo 'url(\''.VOLTAR.'images/feed/12.jpg'.'\')';} ?>;">
				<div class="anytech-art-info">
					<label class="anytech-art-title" id="tituloPreview"><?php if (isset($titulo)) {echo $titulo;} else {echo 'Informação indisponível';} ?></label>
					<label class="anytech-art-author">por<b> <?php if (isset($nomeAutor)) {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?> </b>em <?php if (isset($dataArtigo)) {echo date("d/m/Y", strtotime($dataArtigo)).' às '.date("H:i", strtotime($dataArtigo));} else {echo 'Informação indisponível';} ?></label>
				</div>
			</div>
			
			<div class="anytech-art-content">		
				
				<div id="editado" class="artc"></div>
				
				<label class="post-font"><b>Fonte:</b> TechTudo</label>
				
				<label class="topic">CSS</label>
				<label class="topic">HTML</label>
				<label class="topic">Javascript</label>
				<br>
				
				
				<div class="anytech-post-buttons-art"  align="center" >
					<table class="table-anytech-buttons"valign="center">
						<tr>
							<td>
								<input type="image" class="anytech-post-rating" src="../images/star.png">
							</td>
							<td>
								<label class="button-value" id="lbl_value_avaliacao" style="color:blue">3</label>
							</td>
							<td>
								<input type="image" class="anytech-post-comment" src="../images/comment.png">
							</td>
							<td>
								<label class="button-value" id="lbl_value_comentario" style="color:gold">45</label>
							</td>
							<td>
								<input type="image" class="anytech-post-share" src="../images/share.png">
							</td>
							<td>
								<label class="button-value" id="lbl_value_compartilhar" style="color:green">53</label>
							</td>
							<td>
								<input type="image" class="anytech-post-favorite" src="../images/favorite.png">
							</td>
							<td>
								<label class="button-value" id="lbl_value_favotiro" style="color:red">666</label>
							</td>
						<tr>
					</table>
				</div>
				
				<div class="author-info">
					<Table>
						<tr>
							<td>
								<img src="../<?php if (!isset($imagemAutor) || $imagemAutor == '') {echo 'images/user.png';} else {echo $imagemAutor;} ?>" class="author-image">
							</td>
							<td>
								<label class="anytech-art-by">Artigo escrito por</label>
								<label class="anytech-author"><?php if (isset($nomeAutor)) {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?></label>
								<?php 
									if(isset($nomeAutor) && isset($codigoUsuario)) 
									{
								?>
										<input type="button" value="Seguir" class="button-follow-author" />
								<?php
									}
								?>
							</td>
						</tr>
					</table>
				</div>	
			</div>
			<div class="voltar">
				<input type="image" class="at-button" src="images/title.png" onclick="Edit();"/>
			</div>
		</div>
		<script>
			function Preview(valor, titulo, banner)
			{
				tituloPreview.textContent = titulo;
				bannerPreview.style.backgroundImage = ((banner != '') ? 'url("<?php echo VOLTAR;?>' + banner + '")' : 'url("../images/feed/12.jpg")');
				
				var cont, aux, mod, edit;
				
				aux = valor.split('##Highlighter##');
				
				edit = document.createElement('div');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					mod = (cont + 1)%2;
					
					if (mod == 0)
					{
						/*while (aux[cont].toString().indexOf('\n') != -1)
						{
							aux[cont] = aux[cont].replace('\n', '&#013');
						}*/
						
						var tag = document.createElement('at-highlighter');
							tag.textContent = aux[cont];
						
						edit.insertAdjacentElement('beforeend', tag);
					}
					else
					{
						var separa = aux[cont].split('\n');
						var i;
						
						for (i = 0; i <= separa.length - 1; i = i + 1)
						{
							if (separa[i] != '<at-highlighter>' && separa[i] != '</at-highlighter>')
							{
								var p = document.createElement('p');
								p.innerHTML = separa[i];
								$(p).addClass('post-text');
								
								edit.insertAdjacentElement('beforeend', p);
							}
						}
						
						/*while (aux[cont].toString().indexOf('\n') != -1)
						{
							aux[cont] = aux[cont].replace('\n', '</p><p class="post-text">');
						}
						
						edit = edit + aux[cont];*/
					}
				}
				
				while (editado.firstChild)
				{
					editado.removeChild(editado.firstChild);
				}
				
				while (edit.firstChild)
				{
					editado.insertAdjacentElement('beforeend', edit.firstChild);
				}
				
				/*
				valor = edit;
				editado.innerHTML = '<p class="post-text" id="fp">' + valor + '</p>';
				*/
				
				aux = editado.getElementsByTagName('at-highlighter');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					var conteudo = aux[cont].textContent;
					conteudo = conteudo.split("##");
					aux[cont].innerHTML = '';
					
					var linguagem = conteudo[0];
					var codigoBloco = conteudo[1];
						codigoBloco = codigoBloco.replace('<!--?php', '<\\?php');
						codigoBloco = codigoBloco.replace('?--\>', '\\?>');
					
					var pre = document.createElement('pre');
						$(pre).addClass('brush: ' + linguagem + ';');
						pre.textContent = codigoBloco;
					
					aux[cont].insertAdjacentElement('afterbegin', pre);
					
					/*var ax = aux[cont].getElementsByTagName('pre')[0];
						ax.innerText = ax.innerText.replace*/
					
					//aux[cont].innerHTML = aux[cont].innerHTML;
				}
				
				aux = editado.getElementsByTagName('at-hiperlink');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					var conteudo = aux[cont].textContent;
					conteudo = conteudo.split("##");
					aux[cont].innerHTML = '';
					
					var texto = conteudo[0];
					var link = conteudo[1];
					
					if (link == "")
					{
						link = "#";
					}
					
					//aux[cont].innerHTML = '<a href="' + link + '" target="_blank" class="post-link">' + texto + '</a>';
					
					var a = document.createElement('a');
						a.href = link;
						a.target = '_blank';
						$(a).addClass('post-link');
						a.textContent = texto;
					
					aux[cont].insertAdjacentElement('afterbegin', a);
				}
				
				aux = editado.getElementsByTagName('at-subtitulo');
				console.log(aux);
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					aux[cont].setAttribute("class", "post-topic");
				}
				
				aux = editado.getElementsByTagName('at-citacao');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					aux[cont].setAttribute("class", "post-quote");
				}
				
				aux = editado.getElementsByTagName('at-negrito');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					aux[cont].innerHTML = '<b>' + aux[cont].innerHTML + '</b>';
				}
				
				aux = editado.getElementsByTagName('at-sublinhado');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					aux[cont].innerHTML = '<u>' + aux[cont].innerHTML + '</u>';
				}
				
				aux = editado.getElementsByTagName('at-italico');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					aux[cont].innerHTML = '<i>' + aux[cont].innerHTML + '</i>';
				}
				
				aux = editado.getElementsByTagName('at-imagem');
				
				for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
				{
					aux[cont].innerHTML = '<img src="<?php echo VOLTAR; ?>artigo/' + aux[cont].textContent + '" class="post-image" onclick="ChamaModal(this.src);"/>';
				}
				
				editor.style.display = 'none'; preview.style.display = 'inline-block';
				
				SyntaxHighlighter.config.stripBrs = false; 
				SyntaxHighlighter.highlight();
			}
			
			function Edit()
			{
				editor.style.display = 'inline-block'; preview.style.display = 'none';
			}
		</script>
		
		
		<div id="editor" class="menu-info">
			<div class="button-box">
				<input type="button" value="Abrir menu principal" id="menubtn" style="position: absolute; width: 350px; height:35px; background-color: transparent; border: 0px; color: white; padding-left: 20px; text-align: left; margin-left: 0px; margin-top: 0px;"/>
				<table width="100%" height="100%" cellspacing="0">
					<tr  valign="center" align="center">
						<td  valign="center"  align="right">
							<input id="btn_subtitulo" type="image" class="at-button" title="Inserir Subtítulo" src="images/title.png"/>
							<input type="image" class="at-button" title="Inserir Capa e Thumbnail" src="images/capa.png" onclick="addPhotosArt(); btn_capa.style.backgroundImage = ((txt_banner.value != '') ? 'url(<?php echo VOLTAR;?>' + txt_banner.value + ')' : 'url(../images/feed/12.jpg)'); btn_thumb.style.backgroundImage = ((txt_thumbnail.value != '') ? 'url(<?php echo VOLTAR;?>' + txt_thumbnail.value + ')' : 'url(../images/feed/thumbnail.jpg)');"/>
							<input type="image" class="at-button" title="Inserir Tags" src="images/tag.png" onclick="openTagSelection()"/>				
							<input id="btn_highlighter" type="image" title="Inserir Bloco de Código" class="at-button" src="images/highlighter.png"/>						
							<input id="btn_citacao" type="image" title="Inserir Citação" class="at-button" src="images/citacao.png"/>
							<input id="btn_hiperlink" type="image" title="Inserir Link" class="at-button" src="images/link.png"/>
							<input id="btn_imagem" type="image" title="Inserir Imagem no Artigo" class="at-button" src="images/picture.png"/>			
							<input type="image" class="at-button" title="Pré-visualizar Artigo" src="images/preview.png" onclick="Preview(txt_post.value, txt_titulo.value, txt_banner.value);">	
							<input type="image" class="at-button" title="Inserir Fonte do Artigo" src="images/fonte.png" onclick="txt_nomeFonteAlterar.value = txt_nomeFonte.value; txt_urlFonteAlterar.value = txt_urlFonte.value; openFonte();"/>
							<input id="btn_negrito" type="image" title="Aplicar Negrito" class="at-button" src="images/bold.png">
							<input id="btn_italico" type="image" title="Aplicar Itálico" class="at-button" src="images/italic.png">
							<input id="btn_sublinhado" type="image" title="Aplicar Sublinhado" class="at-button" src="images/sublinhado.png">
						</td>
					</tr>
				</table>
			</div>
			<?php 
				if ($artigoEncontrado == 1) 
				{
			?>
					<form id="Frm_Excluir" method="POST" action="php/ExcluirArtigo.php" enctype="multipart/form-data">
						<input type="hidden" name="codigoArtigo" value="<?php echo $codigoArtigo; ?>"/>
						<input type="submit" id="btn_excluir" style="display: none;"/>
					</form>
			<?php
				}
			?>
			<form id="Frm_Artigo" method="POST" action="php/<?php if ($artigoEncontrado == 1) {echo 'AlterarArtigo';} else {echo 'PublicarArtigo';} ?>.php" enctype="multipart/form-data">
				<input type="hidden" name="tags" id="txt_tags" value="<?php if ($artigoEncontrado == 1) {echo $tagsArtigo;} ?>"/>
				
				<input type="hidden" name="banner" id="txt_banner" value="<?php if ($artigoEncontrado == 1) {echo $bannerArtigo;} ?>"/>
				<input type="hidden" name="thumbnail" id="txt_thumbnail" value="<?php if ($artigoEncontrado == 1) {echo $thumbnailArtigo;} ?>"/>
				
				<input type="hidden" name="nomeFonte" id="txt_nomeFonte" value="<?php if ($artigoEncontrado == 1) {echo $nomeFonte;} ?>"/>
				<input type="hidden" name="urlFonte" id="txt_urlFonte" value="<?php if ($artigoEncontrado == 1) {echo $urlFonte;} ?>"/>
				
				<?php 
					if ($artigoEncontrado == 1) 
					{
				?>
						<input type="hidden" name="codigoArtigo" value="<?php echo $codigoArtigo; ?>"/>
				<?php
					}
				?>
				<div class="frmart" id="frmartid">
					<table width="100%" style="display: inline-block;">
						<tr align="center" >
							<td align="center" >
								<input id="txt_titulo" name="titulo" type="text" class="at-titulo" placeholder="Título do artigo" value="<?php if ($artigoEncontrado == 1) {echo $tituloArtigo;} ?>" required/>
							</td>
						</tr>
						<tr>
							<td>
								<textarea id="txt_descricao" name="descricao" class="at-desc" placeholder="Descrição do artigo" required><?php if ($artigoEncontrado == 1) {echo $descricaoArtigo;} ?></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="at-titulo" placeholder="Exemplo: 21/04/2016 - 17:00" value="<?php echo ($dataCriacao != '') ? date('d/m/Y - H:i', strtotime($dataCriacao)) : date('d/m/Y - H:i'); ?>" id="txt_data" name="data" onblur="var aux = this.value; do {aux = aux.replace('/', ''); aux = aux.replace(' ', ''); aux = aux.replace(':', ''); aux = aux.replace('-', '');} while (aux.indexOf('/') != -1 || aux.indexOf(' ') != -1 || aux.indexOf('-') != -1 || aux.indexOf(':') != -1); if (this.value == '' || !(aux >= 0)) {var aux = new Date(); this.value = ((aux.getDate() < 10) ? '0' + aux.getDate() : aux.getDate()) + '/' + ((aux.getMonth() + 1 < 10) ? '0' + (aux.getMonth() + 1) : aux.getMonth() + 1) + '/' + aux.getFullYear() + ' - ' + ((aux.getHours() < 10) ? '0' + aux.getHours() : aux.getHours()) + ':' + ((aux.getMinutes() < 10) ? '0' + aux.getMinutes() : aux.getMinutes())}"/>
							</td>
						</tr>
						<tr>
							<td valign="center">
								<input style="margin-left: 15px" type="checkbox" id="chk_autor_oculto" name="oculto" value="1" <?php if ($artigoEncontrado == 1) {echo (($autorOculto == 1) ? 'checked' : '');} ?>/><label style="color: white; font-size: 1em; margin-left: 5px;" onclick="chk_autor_oculto.click();">Ocultar autoria</label>
							</td>
						</tr>
						<tr>
							<td valign="center">
								<input style="margin-left: 15px" type="checkbox" id="chk_artigo_pendente" name="pendente" value="1" <?php if ($artigoPendente == 1) {echo (($artigoPendente == 1) ? 'checked' : '');} ?>/><label style="color: white; font-size: 1em; margin-left: 5px;" onclick="chk_artigo_pendente.click();">Artigo pendente</label>
							</td>
						</tr>
					</table>
					<input type="button" class="at-button" id="btnspb" value="<?php if ($artigoEncontrado == 1) {echo 'Finalizar Alterações';} else {echo 'Publicar Artigo';} ?>" style="width: auto;" onclick="btn_publicar.click();"/>
					<?php
						if ($artigoEncontrado == 1)
						{
					?>
							<input type="button" class="at-button" id="btn-excluir" value="Excluir Artigo" style="width: auto;" onclick="if (confirm('Tem certeza que deseja excluir o artigo?')) {btn_excluir.click();}"/>
					<?php
						}
					?>
				</div>
				
				<textarea id="txt_post" name="texto" style="resize: none;" required><?php if ($artigoEncontrado == 1) {echo $conteudoArtigo;} ?></textarea>
				<input type="submit" id="btn_publicar" style="display: none;"/>
			</form>			
		</div>
		
		<div class="selectTags" id="selectTagsid">
			<label class="titletags">Selecione as tags desete artigo</label>
			<div class="bodytag">
				<?php
					$result_Tags = $conexaoPrincipal -> Query("select tb_tema.cd_tema, tb_tema.nm_tema, (select 1 from artigo_tema_tag where artigo_tema_tag.cd_artigo = '$codigoArtigo' and artigo_tema_tag.cd_tema = tb_tema.cd_tema) as ic_ativo from tb_tema order by nm_tema");
					$linha_Tags = mysqli_fetch_assoc($result_Tags);
					$total_Tags = mysqli_num_rows($result_Tags);
					
					if ($total_Tags > 0)
					{
						do
						{
				?>
							<input type="button" value="<?php echo $linha_Tags['nm_tema']; ?>" class="anytech-favorite-button tag<?php echo (($linha_Tags['ic_ativo'] == 1) ? ' ativo' : ''); ?>" codigo="<?php echo $linha_Tags['cd_tema']; ?>" onclick="if (this.classList.contains('ativo') == false) {$(this).addClass('ativo');} else {$(this).removeClass('ativo');}"/>
				<?php
						}
						while ($linha_Tags = mysqli_fetch_assoc($result_Tags));
					}
				?>
			</div>				
			<div class="buttonstag" align="right">
				<input type="button" value="Cancelar" class="btntag cancel" onclick="$('.tag.ativo').removeClass('ativo'); var aux = txt_tags.value.split(';'); var cont = 0; for (cont = 0; cont <= aux.length - 1; cont = cont + 1) {$('.tag[codigo=' + aux[cont] + ']').addClass('ativo');} closeTagSelection()">
				<input type="button" value="Salvar" class="btntag save" onclick="var aux = $('.tag.ativo'); var cont = 0; txt_tags.value = ''; for (cont = 0; cont <= aux.length - 1; cont = cont + 1) {if (cont == 0) {txt_tags.value = aux[cont].getAttribute('codigo');} else {txt_tags.value = txt_tags.value + ';' + aux[cont].getAttribute('codigo');}} closeTagSelection();"/>
			</div>
		</div>
		
		<div class="selectTags" id="fonteSelect">
			<label class="titletags">Insira a fonte do artigo</label>
			<div class="bodytag">
				<input id="txt_nomeFonteAlterar" type="text" class="txtftn" placeholder="Nome do site">
				<input id="txt_urlFonteAlterar" type="text" class="txtftn" placeholder="URL do site">
			</div>				
			<div class="buttonstag" align="right">
				<input type="button" value="Cancelar" class="btntag cancel" onclick="closeFonte()"/>
				<input type="button" value="Salvar" class="btntag save" onclick="txt_nomeFonte.value = txt_nomeFonteAlterar.value; txt_urlFonte.value = txt_urlFonteAlterar.value; closeFonte();"/>
			</div>
		</div>
		
		<div class="selectTags" id="artImages">
			<label class="titletags">Selecione a capa deste artigo</label>
			<div class="bodytag" align="center">
				<input type="button" onclick="capafile.click();" style="width:715px; height: 385px; background-image: url(''); background-size: 100% 100%;" class="capa-img" value="Adicionar Capa" id="btn_capa"/>
				<input type="button" style="width:385px; height: 385px; background-image: url(''); background-size: 100% 100%;" class="thumbnail-img" value="Adicionar Thumbnail" id="btn_thumb" onclick="thumbfile.click();"/>
			</div>				
			<div class="buttonstag" align="right">
				<input type="button" value="Capa" class="btntag save" onclick="btnCapa()">
				<input type="button" value="Thumbnail" class="btntag save" onclick="btnThumbnail()">
				<input type="button" value="Cancelar" class="btntag cancel" onclick="addPhotosArtClose()">
				<input type="button" value="Salvar" class="btntag cancel" onclick="txt_banner.value = ((bannerAdicionar != '') ? 'artigo/' + bannerAdicionar : txt_banner.value); txt_thumbnail.value = ((thumbAdicionar != '') ? 'artigo/' + thumbAdicionar : txt_thumbnail.value); addPhotosArtClose();">
			</div>
		</div>
		<form id="Frm_Imagem" method="POST" action="php/AdicionarImagem.php">
			<input type="file" id="im_post" name="foto" style="display: none;"/>
		</form>
		
		<form id="Frm_Thumb" method="POST" action="php/AdicionarImagem.php">
			<input type="file" id="thumbfile" name="foto" onchange="if (this.value != '') {upTempThumb();}" style="display: none;"/>
		</form>
		
		<form id="Frm_Banner" method="POST" action="php/AdicionarImagem.php">
			<input type="file" id="capafile" name="foto" onchange="if (this.value != '') {upTempPhoto();}" style="display: none;"/>
		</form>
		<input type="text" id="txt_qtChar" value="0 CHARS" style="position: absolute; text-align: right; color: red; margin-right: 10px; font-weight: bold; background-color: transparent; border: 0px; bottom: 0px; right: 0px;" DISABLED>
	</body>
	
	<script src="js/ajax.js"></script>
	<script>
		window.onload = function()
		{
			menuart = 0;
			countChars();
		}
		
		imagem = '';
		bannerAdicionar = '';
		thumbAdicionar = '';
		
		btn_highlighter.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			var linguagem = "";
			
			linguagem = prompt("Digite a linguagem do bloco: ");
			
			if (linguagem != "" && linguagem != null)
			{
				txt_post.setRangeText('<at-highlighter>##Highlighter##' + linguagem + "##" + valor + '##Highlighter##</at-highlighter>');
			}
		}
		
		btn_citacao.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			if (valor != "")
			{
				txt_post.setRangeText('<at-citacao>' + valor + '</at-citacao>');
			}
		}
		
		btn_hiperlink.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			if (valor != "")
			{
				var link = prompt("Digite a url do link (http://exemplo.com.br): ");
				
				link = link.replace('www.', '');
				link = link.replace('http://', '');
				link = link.replace('https://', '');
				
				link = 'http://www.' + link;
				
				if (link != "" && link != null)
				{
					txt_post.setRangeText('<at-hiperlink>' + valor + "##" + link + '</at-hiperlink>');
				}
			}
		}
		
		btn_imagem.onclick = function()
		{
			im_post.click();
		}
		
		btn_subtitulo.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			if (valor != "")
			{
				txt_post.setRangeText('<at-subtitulo>' + valor + '</at-subtitulo>');
			}
		}
		
		btn_negrito.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			if (valor != "")
			{
				txt_post.setRangeText('<at-negrito>' + valor + '</at-negrito>');
			}
		}
		
		btn_italico.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			if (valor != "")
			{
				txt_post.setRangeText('<at-italico>' + valor + '</at-italico>');
			}
		}
		
		btn_sublinhado.onclick = function()
		{
			var valor = txt_post.value.substring(txt_post.selectionStart, txt_post.selectionEnd);
			
			if (valor != "")
			{
				txt_post.setRangeText('<at-sublinhado>' + valor + '</at-sublinhado>');
			}
		}
		
		im_post.onchange = function()
		{
			aux = this.value;
			aux = aux.split('.');
			aux = aux[aux.length - 1];
			
			if (aux == "png" || aux == "jpg")
			{
				tamanho = this.files[0].size;
				tamanho = tamanho/1000000;
				
				if (tamanho <= 2)
				{
					btn_imagem.disabled = true;
					txt_post.readOnly = true;
					
					AjaxForm(Frm_Imagem, "", "var retorno = this.responseXML; var mensagem = retorno.getElementById('lbl_aviso').textContent.trim(); adicionou = retorno.getElementById('ic_adicionou').textContent.trim(); nome = retorno.getElementById('nm_arquivo').textContent.trim(); if (adicionou == 1) {imagem = nome; InserirImagem(imagem);}");
					
					erro = 0;
					this.value = "";
				}
				else
				{
					alert("Foto não pode passar de 2MB (" + tamanho + ")!");
					erro = 1;
				}
			}
			else
			{
				if (this.value == "")
				{
					erro = 1;
				}
				else
				{
					alert("Arquivo não é uma imagem!");
					erro = 1;
				}
			}
			
			if (erro != 0)
			{
				this.value = "";
			}
		}
		
		function InserirImagem(img)
		{
			btn_imagem.disabled = false;
			txt_post.readOnly = false;
			txt_post.setRangeText('<at-imagem>' + img + '</at-imagem>');
			imagem = '';
		}
		
		function openTagSelection()
		{
			coverid.style.display = "inline-block";
			selectTagsid.style.display = "inline-block";
		}
		
		function closeTagSelection()
		{
			coverid.style.display = "none";
			selectTagsid.style.display = "none";
		}
		
		
		function openFonte()
		{
			coverid.style.display = "inline-block";
			fonteSelect.style.display = "inline-block";
		}
		
		function closeFonte()
		{
			coverid.style.display = "none";
			fonteSelect.style.display = "none";
		}
		
		function addPhotosArt()
		{
			coverid.style.display = "inline-block";
			artImages.style.display = "inline-block";
		}
		
		function addPhotosArtClose()
		{
			coverid.style.display = "none";
			artImages.style.display = "none";
		}
		
		function btnCapa()
		{
			btn_thumb.style.display = "none";
			btn_capa.style.display = "inline-block";
		}
		
		function btnThumbnail()
		{
			btn_capa.style.display = "none";
			btn_thumb.style.display = "inline-block";
		}
		
		function upTempPhoto()
		{
			var aux = validaExtensao('capafile');
			
			if (aux == 1)
			{
				var _URL = window.URL || window.webkitURL;
				var file, img;
				
				if ((file = capafile.files[0])) 
				{
					img = new Image();
					
					img.onload = function () 
					{
						if (this.width + 'x' + this.height == '1300x700')
						{
							AjaxForm(Frm_Banner, "btn_capa.disabled = true;", "btn_capa.disabled = false; var retorno = this.responseXML; var mensagem = retorno.getElementById('lbl_aviso').textContent.trim(); adicionou = retorno.getElementById('ic_adicionou').textContent.trim(); nome = retorno.getElementById('nm_arquivo').textContent.trim(); if (adicionou == 1) {bannerAdicionar = nome; LerImagem(capafile, btn_capa);} else {alert(mensagem); bannerAdicionar = '';}");
						}
						else
						{
							alert('Por favor, inserir uma imagem com as dimensões de 1300x700 pixels. As dimensões dessa imagem são de ' + this.width + 'x' + this.height + ' pixels.');
							capafile.value = '';
						}
					};
					
					img.src = _URL.createObjectURL(file);
				}
			}
			else
			{
				alert(aux);
			}
		}
		
		function upTempThumb()
		{
			var aux = validaExtensao('thumbfile');
			
			if (aux == 1)
			{
				var _URL = window.URL || window.webkitURL;
				var file, img;
				
				if ((file = thumbfile.files[0])) 
				{
					img = new Image();
					
					img.onload = function () 
					{
						if (this.width + 'x' + this.height == '500x500')
						{
							AjaxForm(Frm_Thumb, "btn_thumb.disabled = true;", "btn_thumb.disabled = false; var retorno = this.responseXML; var mensagem = retorno.getElementById('lbl_aviso').textContent.trim(); adicionou = retorno.getElementById('ic_adicionou').textContent.trim(); nome = retorno.getElementById('nm_arquivo').textContent.trim(); if (adicionou == 1) {thumbAdicionar = nome; LerImagem(thumbfile, btn_thumb);} else {alert(mensagem); thumbAdicionar = '';}");
						}
						else
						{
							alert('Por favor, inserir uma imagem com as dimensões de 500x500 pixels. As dimensões dessa imagem são de ' + this.width + 'x' + this.height + ' pixels.');
							thumbfile.value = '';
						}
					};
					
					img.src = _URL.createObjectURL(file);
				}
			}
			else
			{
				alert(aux);
			}
		}
		
		function validaExtensao(id)
		{
			// Monto um array com as extensões permitidas
			var extensoes = new Array('bmp','jpg','png');
			
			// Pego a extensão do arquivo colocado no input tipo file
			var ext = $('#'+id).val().split(".")[1].toLowerCase();
			// Faço um loop para verificar se  extensao é permitida
			if($.inArray(ext, extensoes) == -1)
			{
				$('#'+id).val("").empty();
				return "Arquivo não permitido: " + ext;
			}
			else
			{
				return 1;
			}
        }
		
		function LerImagem(input, id) 
		{
			if (input.files && input.files[0]) 
			{
				var reader = new FileReader();

				reader.onload = function (e) 
				{
					id.style.backgroundImage =  "url(" + e.target.result + ")";
				}

				reader.readAsDataURL(input.files[0]);
			}
		}
		
		menubtn.onclick = function()
		{
			if(menuart == 1)
			{
				frmartid.style.left = "-350px";
				menuart = 0;
				menubtn.value = "Abrir menu principal";
			}
			else
			{
				frmartid.style.left = "0px";
				menuart = 1;
				menubtn.value = "Fechar menu principal"
			}
		}
		
		
		txt_post.onkeyup = function()
		{
			countChars();
		}
		
		function countChars()
		{
			qtChar = txt_post.value.length;
			txt_qtChar.value = qtChar + " CHARS";
			if(qtChar < 300)
			{
				txt_qtChar.style.color = "red";
			}
			else
			{
				txt_qtChar.style.color = "#0360ff";
			}
		}
	</script>
</html>
