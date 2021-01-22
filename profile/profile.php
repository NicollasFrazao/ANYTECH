<?php
	session_start();
	define('VOLTAR', '../');
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	$url = getcwd();
	$pasta = explode('@', $url);
	
	if (isset($pasta[1]))
	{
		$pasta = $pasta[1];
		$nickname = $pasta;
	}
	else if (isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$nickname = $_SESSION['AnyTech']['nicknameUsuario'];
	}
	else
	{
		header('Location: '.VOLTAR.'login?url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	}
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;
		$cod_usuario = "null";
		$linha_Usuario['nm_usuario_completo'] = "";
		$linha_Usuario['nm_email'] = "";
	}
	else
	{
		$logado = 1;		
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
			
		$result_Usuario = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, im_perfil, cd_nivel_cadastro from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
		
		$nomeUsuario = $linha_Usuario['nm_usuario_completo'];
		$imagemUsuario = $linha_Usuario['im_perfil'];
		$nivelCadastro = $linha_Usuario['cd_nivel_cadastro'];
		$emailUsuario = $linha_Usuario['nm_email'];
		
		if ($nivelCadastro < 4)
		{
			header('Location: '.VOLTAR.'signup/');
		}
	}
?>

<?php
	$result_profile = $conexaoPrincipal -> Query("select cd_usuario, nm_usuario_completo, nm_email, im_perfil, cd_nivel_cadastro from tb_usuario where nm_nickname = '$nickname'");
	$linha_profile = mysqli_fetch_assoc($result_profile);
	
	$codigoProfile = $linha_profile['cd_usuario'];
	$nomeProfile = $linha_profile['nm_usuario_completo'];
	$imagemProfile = $linha_profile['im_perfil'];	
	
	
	$searchColor = $conexaoPrincipal->query("select ds_cor_background, ds_cor_menu, ds_cor_barra from tb_usuario where cd_usuario = '$codigoProfile'");
	$searchColor = mysqli_fetch_assoc($searchColor);
	$colorMenu = $searchColor['ds_cor_menu'];
	$colorBarra = $searchColor['ds_cor_barra'];
	$colorBackground = $searchColor['ds_cor_background'];
?>

<!DOCTYPE HMTL>
	
<html>
	<head>
		<?php
			include VOLTAR.'php/CoresGoogle.php';
		?>
		
		<meta charset="utf-8">
		<title>ANYTECH - <?php echo $nomeProfile; ?></title>
		<meta name="viewport" content="width=device-width, user-scalable=no">	
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-profile.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-menu.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-menu-media-query-sizeone.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-menu-media-query-sizetwo.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-article-media-query.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-index.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed-profile.css">
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png"/>	
	</head>
	<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>	
	<script src="<?php echo VOLTAR; ?>js/commentarea.js"></script>
	<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
	<script src="<?php echo VOLTAR; ?>js/feedhover.js"></script>
	<body>
	<?php 
		if($logado == 1)
		{
			include(VOLTAR.'topbar-on.php');
			include(VOLTAR.'menu.php');
		}
		else
		{
			include(VOLTAR.'topbar-index.php');
			//include(VOLTAR.'topbar-search.php');
		}
		
		$searchColor = $conexaoPrincipal->query("select ds_cor_background, ds_cor_menu, ds_cor_barra from tb_usuario where cd_usuario = '$codigoProfile'");
		$searchColor = mysqli_fetch_assoc($searchColor);
		$colorMenu = $searchColor['ds_cor_menu'];
		$colorBarra = $searchColor['ds_cor_barra'];
		$colorBackground = $searchColor['ds_cor_background'];
	?>	
		
		<div class="anytech-art-image">		
			<div class="anytech-col-mini">
				<div class="anytech-data">
					<div class="anytech-data-into" align="center">
						<label class="anytech-profile-name"><?php echo $nomeProfile; ?></label>
						<img src="<?php echo VOLTAR; ?><?php if ($imagemProfile == '') {echo 'images/user.png';} else {echo $imagemProfile;} ?>" class="anytech-profile-image" id="profile_image">
						<?php
							if($cod_usuario == $codigoProfile )
							{
								echo '<input type="image" src="../images/foto.png" class="image-profile-cover" id="profile_image_cover">';
							}
							else
							{
								echo"<script>$('#anytech_style_button').css('display','none');</script>";
							}
						?>
						<table align="center">
							<tr>
								<td align="center" width="50%">
									<label class="anytech-info-label-count" id="anytech_seguidores">
										<?php
											$followers = $conexaoPrincipal -> Query("select count(*) as 'followersCount' from tb_seguidor where cd_usuario = '$codigoProfile'");
											$followers = mysqli_fetch_assoc($followers);
											echo $followers['followersCount'];
										?>
									</label>
									<label class="anytech-info-label-follow">seguidores</label>		
								</td>
								<td align="center" width="50%" style="border-left: 1px solid #ddd;">
									<label class="anytech-info-label-count" id="anytech_seguindo">
										<?php
											$following = $conexaoPrincipal -> Query("select count(*) as 'followingCount' from tb_seguidor where cd_seguidor = '$codigoProfile'");
											$following = mysqli_fetch_assoc($following);
											echo $following['followingCount'];
										?>
									</label>
									<label class="anytech-info-label-follow">seguindo</label>		
									
								</td>
							<tr>
						</table>
						<?php
						if($logado == 1)
						{
							if($cod_usuario != $codigoProfile)
							{
							
								$result = $conexaoPrincipal -> Query("select * from tb_seguidor
													where cd_usuario = '$codigoProfile' and cd_seguidor = '$cod_usuario'");
			
								$total = mysqli_num_rows($result);
								
								if ($total == 0)	
								{			
									echo '<input type="button" value="Seguir +" id="followbtn" class="anytech-follow-button" onclick="follow()">';
								}
								else
								{
									echo '<input type="button" value="Seguindo ✔" id="followbtn" class="anytech-follow-button" onclick="follow()">';
								}
							}
							else
							{
								echo"<br>";
							}
						}
						else
						{
							echo"<br>";
						}
						?>
						
					</div>
				</div>
				<div class="anytech-favorites">
					
					<?php
						$result_temas_profile = $conexaoPrincipal -> Query("select nm_tema from usuario_tema_favorito inner join tb_tema
												  on tb_tema.cd_tema = usuario_tema_favorito.cd_tema
												  where cd_usuario = '$codigoProfile';");
						
						$linha_temas = mysqli_fetch_assoc($result_temas_profile);
						$total_temas = mysqli_num_rows($result_temas_profile);
						
						if ($total_temas > 0)
						{
						echo "<label class=\"anytech-box-title\">Favoritos</label>";
							do
							{
					?>
								<input type="button" class="anytech-favorite-option" value="<?php echo $linha_temas['nm_tema']; ?>">
					
					<?php
							}
							while ($linha_temas = mysqli_fetch_assoc($result_temas_profile));
						}
					?>
				</div>
				<div class="anytech-products" align="center">
					<label class="anytech-box-title"  style="margin-bottom:4%; text-align:left;">Produtos</label>
					<input type="image" src="<?php echo VOLTAR; ?>images/products/eletrontech.png" class="anytech-profile-products">
					<input type="image" src="<?php echo VOLTAR; ?>images/products/mappie.png" class="anytech-profile-products">
					<input type="image" src="<?php echo VOLTAR; ?>images/products/biotech.png" class="anytech-profile-products">
				</div>
			</div>
			
			<div class="anytech-col-large">		
				<?php
					if($cod_usuario != $codigoProfile )
					{
						if($logado == 1)
						{
				?>			
				<div class="anytech-art-comment-now">
					<textarea id="txt_comentario" class="comment-area" data-autoresize rows="1" placeholder="Deixe uma mensagem para <?php echo $nomeProfile; ?>" required></textarea>					
					<input type="button" id="btn_enviar" value="Enviar" class="button-comment-submit" onclick="send()">
				</div>
				<?php
						}
						else
						{
				?>
							<div class="anytech-art-comment-now">
								<textarea id="txt_comentario" class="comment-area" data-autoresize rows="1" placeholder="Acesse sua conta e deixe sua mensagem para <?php echo $nomeProfile; ?>" required disabled></textarea>					
							</div>
				<?php
						}
					}
				?>
				<label class="anytech-box-title" id="content-label">Conteúdos</label>
				
				<div class="anytech-profile-feed-left" id="coll1">
				
				</div>
								
				<div class="anytech-profile-feed-right" id="coll2">
				
				</div>
				<div id="arms" style="display:none;">
				<!--ITENS DA PRIMEIRA COLUNA-->
					<?php
						$result_Artigos = $conexaoPrincipal -> Query("(select distinct tb_artigo.cd_artigo,
                tb_artigo.nm_titulo,
                tb_artigo.ds_artigo,
                tb_artigo.dt_criacao,
                tb_artigo.ds_texto,
                tb_artigo.ds_url,
                tb_artigo.im_artigo,
                usuario_artigo_compartilhar.dt_compartilhar as dt_acao,
                usuario_artigo_compartilhar.ds_sobre,
                (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario,
                (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
                (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
                (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
                (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
                (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar
  from tb_artigo inner join usuario_artigo_compartilhar
    on tb_artigo.cd_artigo = usuario_artigo_compartilhar.cd_artigo
      inner join tb_usuario
        on tb_usuario.cd_usuario = usuario_artigo_compartilhar.cd_usuario
          where tb_usuario.cd_usuario = '$codigoProfile')
union
(select distinct tb_artigo.cd_artigo,
                 tb_artigo.nm_titulo,
                 tb_artigo.ds_artigo,
                 tb_artigo.dt_criacao,
                 tb_artigo.ds_texto,
                 tb_artigo.ds_url,
                 tb_artigo.im_artigo,
                 tb_artigo.dt_criacao as dt_acao,
                 null,
                 (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario,
                 (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
                 (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
                 (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
                 (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
                 (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar
  from tb_artigo
    where tb_artigo.cd_usuario = '$codigoProfile')
  order by dt_acao desc");
						$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
						$total_Artigos = mysqli_num_rows($result_Artigos);
						
						$cont = 0;
						
						if ($total_Artigos > 0)
						{
							do
							{
								$cont = $cont + 1;
					?>	
								<div class="anytech-post-box">
									<div class="img-outer">
										<img src="<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_artigo'] == '') {echo 'images/feed/12.jpg';} else {echo $linha_Artigos['im_artigo'];} ?>" class="anytech-post-image">
									</div>
									<a href="<?php echo VOLTAR; ?>artigo/<?php echo $linha_Artigos['ds_url']; ?>" target="_blank" class="anytech-post-title"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></a>
									<a class="anytech-post-author">por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></a>
									<a class="anytech-post-desc"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></a>
									<a class="anytech-post-tags"><b>Tags:</b> Javascript, CSS, HTML</a>	
									
									<div class="anytech-post-buttons"  align="center">
										<table class="data-buttons-table" align="center" cellspacing="3">
											<tr>
												<td>
													<input type="text" class="anytech-post-rating value-btn-rating value-btn" id="col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="10" disabled>
												</td>
												<td>
													<input type="text" class="anytech-post-comment value-btn-comment value-btn" id="col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_comentario']; ?>" disabled>
												</td>
												<td>
													<input type="text" class="anytech-post-share value-btn-share value-btn" id="col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_compartilhar']; ?>" disabled>
												</td>
												<td>
													<input type="text" class="anytech-post-favorite value-btn-favorite value-btn" id="col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_favorito']; ?>" disabled>
												</td>
												<td>
													<input type="text" class="anytech-post-time value-btn-time value-btn" id="col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_leitura']; ?>" disabled>
												</td>
											</tr>
										</table>
										<input type="image" id="col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox()">
										<input type="image" id="col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png">
										<input type="image" id="col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
										<input type="image" id="col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png">
										<input type="image" id="col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png">
										
										<script>
											col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onclick = function()
											{
												var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
												
												Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox();}");
											}
											
											col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onclick = function()
											{
												var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
												
												Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox();}");
											}
											
											col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
											{
												EsconderValores();
												
												col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
											}
											
											col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
											{
												col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
											}
											
											col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
											{
												EsconderValores();
												
												var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
												
												//Tirei isso aqui de dentro da função abaixo
												col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
												
												Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno; ");
											}
											
											col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
											{
												col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
											}
											
											col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
											{
												var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
												
												EsconderValores();
												
												col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
												
												Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno;");
											}
											
											col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
											{
												col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
											}
											
											col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
											{
												EsconderValores();
												
												var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;

												col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
												
												Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno;");
											}
											
											col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
											{
												col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
											}
											
											col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
											{
												EsconderValores();
												
												var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
												
												col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
												
												Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno;");
											}
											
											col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
											{
												col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
											}
										</script>
									</div>
									<?php 
										if ($linha_Artigos['ds_sobre'] != '')
										{
									?>
											<label class="post-profile-status" style="background-color:#2dc100"><?php echo $linha_Artigos['ds_sobre']; ?></br></br><b>Compartilhado em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_acao'])); ?> ás <?php echo date('H:i', strtotime($linha_Artigos['dt_acao'])); ?></b></label>
									<?php
										}
									?>
								</div>
								<span></span>
					<?php
							}
							while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
						}
					?>
				</div>
			</div>
		</div>
	</body>
	<Script>
		window.onload = function()
		{
			indexover = 0;
			
			getArticleList = arms.innerHTML;
			arms.innerHTML = '';
			getArticles = getArticleList.split('<span></span>');
			
			for(k = 0; k < getArticles.length; k++)
			{ 
				if((k%2) == 0)
				{
					coll1.innerHTML += getArticles[k];
				}
				else
				{
					coll2.innerHTML += getArticles[k];
				}
			}
			
			aux = coll1.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			aux = coll2.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			getFollow();
		}
		
		
		
		function refreshColor(){
			var colorMenu = "<?php echo $colorMenu;?>";
			var colorBarra = "<?php echo $colorBarra; ?>";
			var colorBackground = "<?php echo $colorBackground; ?>";
			$(".anytech-follow-button").css('background-color',colorBarra);
			$(".button-comment-submit").css('background-color',colorBarra);
			$(".anytech-profile-name").css('color',colorBarra);
			$(".anytech-info-label-count").css('color',colorBarra);
			$(".anytech-box-title").css('background-color',colorBarra);
			$(".anytech-info-label-follow").css('color',colorBarra);
			$(".anytech-bar").css('background-color',colorBarra);
			$(".anytech-menu-body").css("background-color",colorMenu);
			$("body").css("background-color",colorBackground);
			
		}
		
		refreshColor();
		
		<?php
		
			if($cod_usuario == $codigoProfile)
			{
		?>
				profile_image.onmouseover = function()
				{
					profile_image_cover.style.display = "inline-block";
					indexover = 1;
				}
				
				profile_image.onmouseout = function()
				{
					profile_image_cover.style.display = "none";
					indexover = 0;
				}
				
				profile_image_cover.onmouseover = function()
				{
					profile_image_cover.style.display = "inline-block";
					indexover = 1;
				}
				
				profile_image_cover.onmouseout = function()
				{
					if(indexover == 1)
					{
						profile_image_cover.style.display = "none";
						indexover = 0;
					}
					
				}
		<?php
			}
		?>
		
		function send()
		{
			mensagem = txt_comentario.value;			
			$.ajax({
					url:'../php/EnviaMensagemUsuarios.php',
					type:'POST',
					data:{Nome:'<?php if($logado == 1){echo "$nomeUsuario";} ?>',
							Email:'<?php if($logado == 1){echo "$emailUsuario";} ?>',
							Assunto:'Mensagem na página de perfil',
							Mensagem:mensagem,
							Codigo:'<?php if($logado == 1){echo "$cod_usuario";} ?>',
							InternoExterno: '1',
							Destinatario: '<?php if($logado == 1){echo "$codigoProfile";} ?>'},
					success:function(retorno){
						notify_req_ajx.innerHTML = retorno;
						showReturnAjax();			
						txt_comentario.value = "";							
					}
				})
		}
	
		function follow()
		{			
			$.ajax({
					url:'../php/Seguir.php',
					type:'POST',
					data:{
							Seguidor:'<?php echo "$cod_usuario"; ?>',
							Usuario: '<?php if($logado == 1){echo "$codigoProfile";} ?>'},
					success:function(retorno){
						
						if(retorno == 1)
						{
							followbtn.value = "Seguindo ✔";
						}
						else
						{
							followbtn.value = "Seguir +";
						}	
						followCount();						
					}
				})
		}
		
		function getFollow()
		{
			setTimeout('followCount()',7000);
		}
		
		function followCount()
		{			
			$.ajax({
					url:'../php/Seguidores.php',
					type:'POST',
					data:{
							Usuario: '<?php echo "$codigoProfile"; ?>'},
					success:function(retorno){
						numbers = retorno.split(';');
						anytech_seguidores.innerHTML = numbers[0];
						anytech_seguindo.innerHTML = numbers[1];
						getFollow();				
					}
				})
		}
	</script>
</html>