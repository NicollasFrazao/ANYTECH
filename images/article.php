<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta property="og:image" content="http://anytech.com.br/images/bill.jpg">
		<meta property="og:image:type" content="image/jpeg">
		<link rel="shortcut icon" type="image/png" href="../images/logoico.png"/>		
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed-media-query-sizeone.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed-media-query-sizetwo.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed-media-query-sizethree.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-banners.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-article.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-footer.css">
		
		<title>ANYTECH - <?php echo $titulo; ?></title>
		
		<!-- Highlighter -->
		<script type="text/javascript" src="highlighter/scripts/shCore.js"></script>
		<script type="text/javascript" src="highlighter/scripts/shBrushJScript.js"></script>
		<script type="text/javascript" src="highlighter/scripts/shBrushPHP.js"></script>
		<link type="text/css" rel="stylesheet" href="highlighter/styles/shCoreDefault.css"/>
		<script type="text/javascript">
			SyntaxHighlighter.config.stripBrs = false;
			SyntaxHighlighter.all();
		</script>
		<script src="../js/ajax.js"></script>
	</head>
	<body>
		
		<?php			
			if ($logado == 1)
			{
				include VOLTAR.'topbar-on.php';		
				include VOLTAR.'menu.php';				
			}
			else
			{
				include VOLTAR.'topbar-search.php';
			}
		?>
		<div class="anytech-art-image" style="background-image: <?php if (isset($imagemArtigo)) {echo 'url(\''.VOLTAR.$imagemArtigo.'\')';} else {echo 'url(\''.VOLTAR.'images/feed/12.jpg'.'\')';} ?>;">
			<div class="anytech-art-info">
				<label class="anytech-art-title"><?php if (isset($titulo)) {echo $titulo;} else {echo 'Informação indisponível';} ?></label>
				<label class="anytech-art-author">por<b> <?php if ($nomeAutor != '') {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?> </b>em <?php if (isset($dataArtigo)) {echo date("d/m/Y", strtotime($dataArtigo)).' às '.date("H:i", strtotime($dataArtigo));} else {echo 'Informação indisponível';} ?></label>
			</div>
		</div>
		
		<div class="at-main">
			<?php include('leitor.php'); ?>
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
							<label class="button-value" id="lbl_value_comentario" style="color:gold"><?php echo $linha_Artigo['qt_comentario']; ?></label>
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
							<label class="button-value" id="lbl_value_favotiro" style="color:red"><?php echo $linha_Artigo['qt_favorito']; ?></label>
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
							<label class="anytech-author"><?php if ($nomeAutor != '') {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?></label>
							<?php 
								if($nomeAutor != '' && isset($codigoUsuario)) 
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
			
			<h2 class="at-bloco-titulo" style="color: purple; border-bottom: 2px solid purple;">Deixe seu comentário</h2>			
			<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-comments" data-href="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>" data-width="100%" data-numposts="1"></div>
				
			<div class="anytech-others">
				<h2 class="at-bloco-titulo" style="color: purple; border-bottom: 2px solid purple;">Recomendamos para você</h2>			
				<div class="at-bloco-artigo">
					<div class="at-bloco-imagem" style="background-image: url('../images/banners/1.jpg')"></div>
					<div class="at-bloco-desc">
						<h2 class="at-bloco-artigo-titulo">Conheça um pouco da história do fundador da microsoft</h2>
						<h2 class="at-bloco-artigo-autor">por Gustavo Alves em 12/12/2012</h2>
						<input class="at-bloco-artigo-btn" style="background-color: purple;" type="button" value="Ler Artigo">
					</div>
				</div>
				
				<span class="line"></span>	
			</div>
		</div>
			<div class="at-lateral">
				<div class="at-standard-banner">
					<h2 class="at-standard-banner-category">Mentes Brilhantes</h2>
					<h2 class="at-standard-banner-desc">Conheça um Pouco da História do Fundador da Microsoft</h2>
					<div class="at-standard-image" style="background-image: url('../images/banners/1.jpg')"></div>
				</div>
				
				<div class="at-standard-banner">
					<h2 class="at-standard-banner-category">PHP</h2>
					<h2 class="at-standard-banner-desc">Introdução ao PDO</h2>
					<div class="at-standard-image" style="background-image: url('../images/banners/7.jpg')"></div>
				</div>
				
				<div class="at-standard-banner">
					<h2 class="at-standard-banner-category">Moblie</h2>
					<h2 class="at-standard-banner-desc">Engatinhando no Mundo da Tecnologia Mobile</h2>
					<div class="at-standard-image" style="background-image: url('../images/banners/8.jpg')"></div>
				</div>
			</div>
		<div class="anytech-art-content">	
			<?php include(VOLTAR.'footer.php'); ?>
		</div>	
	</body>
	<script src="../js/jquery.min.js"></script>	
	<script src="../js/topbar.js"></script>
	<script src="../js/commentarea.js"></script>

</html>
