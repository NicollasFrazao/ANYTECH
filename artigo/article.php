<?php
	//print_r($_SERVER);
	//exit;
	
	$query_ArtigosRecomendados = "select tb_artigo.cd_artigo,
										tb_artigo.nm_titulo,
										tb_artigo.ds_artigo,
										tb_artigo.dt_criacao,
										tb_artigo.ic_autor_oculto,
										(select week(tb_visita.dt_visita) from tb_artigo as tb_artigo_visita inner join tb_visita  on tb_artigo_visita.cd_artigo = tb_visita.cd_artigo where tb_visita.cd_artigo = tb_artigo.cd_artigo order by tb_visita.dt_visita desc limit 1) as ss_criacao,
										tb_artigo.ds_texto,
										tb_artigo.ds_url,
										tb_artigo.im_artigo,
										tb_artigo.im_thumbnail,
										(select sum(usuario_artigo_avaliar.qt_estrelas) / count(usuario_artigo_avaliar.cd_artigo) from usuario_artigo_avaliar where usuario_artigo_avaliar.cd_artigo = tb_artigo.cd_artigo) as qt_estrelas,
										(select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario, (select tb_usuario.nm_nickname from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_nickname,
										(select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
										(select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
										(select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
										(select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
										(select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar,
										(select group_concat(tb_tema.nm_tema) from tb_artigo as tb_artigo_tags inner join artigo_tema_tag on tb_artigo_tags.cd_artigo = artigo_tema_tag.cd_artigo inner join tb_tema on artigo_tema_tag.cd_tema = tb_tema.cd_tema where tb_artigo_tags.cd_artigo = tb_artigo.cd_artigo) as ds_tags,
									   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo and year(tb_visita.dt_visita) = year(now()) and week(tb_visita.dt_visita) = week(now())) as qt_visita_rank,
									   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo  and year(tb_comentario_artigo.dt_comentario_artigo) = year(now()) and week(tb_comentario_artigo.dt_comentario_artigo) = week(now())) as qt_comentario_rank,
									   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_favorito.dt_favorito) = year(now()) and week(usuario_artigo_favorito.dt_favorito) = week(now())) as qt_favorito_rank,
									   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_leitura.dt_leitura) = year(now()) and week(usuario_artigo_leitura.dt_leitura) = week(now())) as qt_leitura_rank,
									   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_compartilhar.dt_compartilhar) = year(now()) and week(usuario_artigo_compartilhar.dt_compartilhar) = week(now())) as qt_compartilhar_rank,
									   (select (qt_favorito_rank*13) + (qt_compartilhar_rank*8) + (qt_comentario_rank*3) + (qt_leitura_rank*2) + qt_visita_rank) as ds_techrank
									from tb_artigo order by rand() limit 1";
									
									
	$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
	$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
	$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
	$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
	$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");	
									
	
?>

<!DOCTYPE html>

<html>
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
		<meta property="fb:app_id" content="701955103277894">
		<meta property="og:locale" content="pt_BR">
		<meta property="og:type" content="article">
		<meta property="og:title" content="<?php echo $titulo; ?>" />
		<meta property="og:description" content="<?php echo $descricaoArtigo; ?>" />
		<meta property="og:url" content="https://<?php echo /*str_replace('www.', '', $_SERVER['HTTP_HOST'])*/$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
		<meta property="og:site_name" content="ANYTECH"/> 
		<meta property="og:image" content="https://<?php if (isset($imagemArtigo)) {echo /*str_replace('www.', '', $_SERVER['HTTP_HOST'])*/$_SERVER['HTTP_HOST'].'/'.((str_replace('www.', '', $_SERVER['HTTP_HOST']) == 'localhost') ? 'sites/anytech/' : '').$imagemArtigo;} else {echo str_replace('www.', '', $_SERVER['HTTP_HOST']).'/'.(($_SERVER['HTTP_HOST'] == 'localhost') ? 'sites/anytech/' : '').'images/feed/12.jpg';} ?>">
		<meta property="og:image:type" content="image/jpeg">
		<meta property="og:image:width" content="800">
		<meta property="og:image:height" content="600">
		
		<meta name="twitter:card" content="photo">
		<meta name="twitter:url" content="https://<?php echo /*str_replace('www.', '', $_SERVER['HTTP_HOST'])*/$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
		<meta name="twitter:title" content="<?php echo $titulo; ?>">
		<meta name="twitter:description" content="<?php echo $descricaoArtigo; ?>">
		<meta name="twitter:image" content="https://<?php if (isset($imagemArtigo)) {echo /*str_replace('www.', '', $_SERVER['HTTP_HOST'])*/$_SERVER['HTTP_HOST'].'/'.((str_replace('www.', '', $_SERVER['HTTP_HOST']) == 'localhost') ? 'sites/anytech/' : '').$imagemArtigo;} else {echo str_replace('www.', '', $_SERVER['HTTP_HOST']).'/'.(($_SERVER['HTTP_HOST'] == 'localhost') ? 'sites/anytech/' : '').'images/feed/12.jpg';} ?>">
		
		<?php
			include VOLTAR.'php/CoresGoogle.php';
		?>
		 
		<meta charset="UTF-8">	
		<meta name="google-site-verification" content="LHwdJcSUU1ZulIu-GK3tqGfkliNNViDbzvZWIB6ZwUo" />
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta name="robots" content="index, follow">
		<meta name="description" content="<?php echo $descricaoArtigo.' - ANYTECH'; ?>">
		<meta name="keywords" content="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>"/>
		<meta name="googlebot" content="index, follow">
		<meta name="author" content="ANYTECH">
		<meta name="google" content="notranslate" />
		
		<link rel="shortcut icon" type="image/png" href="../images/logoico.png"/>		
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed-media-query-sizeone.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed-media-query-sizetwo.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-feed-media-query-sizethree.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-banners.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-article.css">
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-footer.css">
		<link rel="stylesheet" type="text/css" href="../css/searchmenu.css">
		
		
		<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '137808586645951');
		fbq('track', "PageView");</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=137808586645951&ev=PageView&noscript=1"
		/></noscript>
		<!-- End Facebook Pixel Code -->
		
		<!-- GOOGLE ANALYTICS-->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-80717206-1', 'auto');
		  ga('send', 'pageview');

		</script>
		<!-- GOOGLE ANALYTICS-->
		
		<title>ANYTECH - <?php echo $titulo; ?></title>
		
		<!-- Highlighter -->
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
		<link type="text/css" rel="stylesheet" href="highlighter/styles/shCoreDefault.css"/>
		<script type="text/javascript">
			SyntaxHighlighter.config.stripBrs = false;
			SyntaxHighlighter.all();
		</script>
		<script src="../js/ajax.js"></script>
	</head>
	<body style="background-color: #f2f2f2;">
	
	<script type="text/javascript" src="../js/jssor.slider.min.js"></script>
		<!-- use jssor.slider.debug.js instead for debug -->
		<script>
			jssor_1_slider_init = function() {
				
				var jssor_1_SlideoTransitions = [
				  [{b:5500,d:3000,o:-1,r:240,e:{r:2}}],
				  [{b:-1,d:1,o:-1,c:{x:51.0,t:-51.0}},{b:0,d:1000,o:1,c:{x:-51.0,t:51.0},e:{o:7,c:{x:7,t:7}}}],
				  [{b:-1,d:1,o:-1,sX:9,sY:9},{b:1000,d:1000,o:1,sX:-9,sY:-9,e:{sX:2,sY:2}}],
				  [{b:-1,d:1,o:-1,r:-180,sX:9,sY:9},{b:2000,d:1000,o:1,r:180,sX:-9,sY:-9,e:{r:2,sX:2,sY:2}}],
				  [{b:-1,d:1,o:-1},{b:3000,d:2000,y:180,o:1,e:{y:16}}],
				  [{b:-1,d:1,o:-1,r:-150},{b:7500,d:1600,o:1,r:150,e:{r:3}}],
				  [{b:10000,d:2000,x:-379,e:{x:7}}],
				  [{b:10000,d:2000,x:-379,e:{x:7}}],
				  [{b:-1,d:1,o:-1,r:288,sX:9,sY:9},{b:9100,d:900,x:-1400,y:-660,o:1,r:-288,sX:-9,sY:-9,e:{r:6}},{b:10000,d:1600,x:-200,o:-1,e:{x:16}}]
				];
				
				var jssor_1_options = {
				  $AutoPlay: true,
				  $SlideDuration: 800,
				  $SlideEasing: $Jease$.$OutQuint,
				  $CaptionSliderOptions: {
					$Class: $JssorCaptionSlideo$,
					$Transitions: jssor_1_SlideoTransitions
				  },
				  $ArrowNavigatorOptions: {
					$Class: $JssorArrowNavigator$
				  },
				  $BulletNavigatorOptions: {
					$Class: $JssorBulletNavigator$
				  }
				};
				
				var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
				
				//responsive code begin
				//you can remove responsive code if you don't want the slider scales while window resizing
				function ScaleSlider() {
					var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
					if (refSize) {
						refSize = Math.min(refSize, 1920);
						jssor_1_slider.$ScaleWidth(refSize);
					}
					else {
						window.setTimeout(ScaleSlider, 30);
					}
				}
				ScaleSlider();
				$Jssor$.$AddEvent(window, "load", ScaleSlider);
				$Jssor$.$AddEvent(window, "resize", ScaleSlider);
				$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
				//responsive code end
			};
		</script>

		<style>
			/* jssor slider bullet navigator skin 05 css */
			/*
			.jssorb05 div           (normal)
			.jssorb05 div:hover     (normal mouseover)
			.jssorb05 .av           (active)
			.jssorb05 .av:hover     (active mouseover)
			.jssorb05 .dn           (mousedown)
			*/
			.jssorb05 {
				position: absolute;
			}
			.jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
				position: absolute;
				/* size of bullet elment */
				width: 16px;
				height: 16px;
				display: none;
				background: url('<?php echo VOLTAR; ?>images/slider/b05.png') no-repeat;
				overflow: hidden;
				cursor: pointer;
			}
			.jssorb05 div { background-position: -7px -7px; }
			.jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
			.jssorb05 .av { background-position: -67px -7px; }
			.jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }

			/* jssor slider arrow navigator skin 22 css */
			/*
			.jssora22l                  (normal)
			.jssora22r                  (normal)
			.jssora22l:hover            (normal mouseover)
			.jssora22r:hover            (normal mouseover)
			.jssora22l.jssora22ldn      (mousedown)
			.jssora22r.jssora22rdn      (mousedown)
			*/
			.jssora22l, .jssora22r {
				display: block;
				position: absolute;
				/* size of arrow element */
				width: 40px;
				height: 58px;
				cursor: pointer;
				background: url('../images/slider/a22.png') center center no-repeat;
				overflow: hidden;
			}
			.jssora22l { background-position: -10px -31px; }
			.jssora22r { background-position: -70px -31px; }
			.jssora22l:hover { background-position: -130px -31px; }
			.jssora22r:hover { background-position: -190px -31px; }
			.jssora22l.jssora22ldn { background-position: -250px -31px; }
			.jssora22r.jssora22rdn { background-position: -310px -31px; }
			
			*
			{
				font-family: century gothic;
			}
			
			html, body
			{
				height: auto;
				background-color: #fff;
				overflow-x: hidden;
			}	
			
			.rctY
			{
			    display: inline-block;
				width: 22px;
				margin-right: 5px;
				border-radius: 50%;
			}
			
			.rating-info
			{
				display: inline-block;
				width: 95%;
				margin-left: 2.5%;
				height: auto;
				background-color: transparent;
			}
			
			.cover-label-rating
			{
				display: inline-block;
				width: 100%;
				color: #0145ff;
				font-size: 0.8em;
				text-align: center;
				margin-top: 6px;
			}
			
			.cover-label-rating-white
			{
				display: inline-block;
				width: 100%;
				color: white;
				font-size: 0.8em;
				text-align: center;
				margin-top: 6px;
			}
			
			.cover-aval-rating
			{
				display:inline-block;
				width: 100%;
				font-size: 3em;
				font-weight: bold;
				color: #0145ff;
				text-align: center;
			}
			
			.rating-star-box
			{
				display: inline-block;
				width: 95%;
				margin-left: 2.5%;
				height: 70px;
				padding-top:10px;
				padding-bottom: 10px;
				background-color: #0145ff;
				margin-top:10px;
			}
			
			.rating > span
			{
			  display: inline-block;
			  position: relative;
			  width: 1.5em;
			  height: 1.5em;
			  margin: -5px;
			  font-size: 2em;
			  color: #fff;
			}
			
			
			#cover-rating-cancel
			{
				margin-right: 2.5%;
			}
			
			.rating-redirect-label
			{
				font-weight: bold;
				color: white;
			}
			
			.rating-redirect-label:hover
			{
				color: #00ecff;
			}
			
			.mhand
			{
				cursor: pointer;
			}
			
			body
			{
				height: auto;
				background-color: #fff;
				overflow-x: hidden;
			}	
			
			#st1, #st2, #st3, #st4, #st5
			{
				transition: color 2s;
			}
			
			.button_share_facebook_art
			{
				background-color: #3b5998;
			}
			
			.button_share_facebook_art:hover
			{
				background-color: #2f4d8b;
			}
			
			.button_share_gplus_art
			{
				background-color: #dd4b39;
			}
			
			.button_share_gplus_art:hover
			{
				background-color: #E23D29;
			}
			
			.button_share_twitter_art
			{
				background-color: #33ccff;
			}
			
			.button_share_twitter_art:hover
			{
				background-color: #20C7FF;
			}
			
			.attag
			{
				margin-left: 3%;
			}
		</style>
		<div class="maincover"></div>
		<div class="anytech-option-post-cover" id="box_share_cover">
			<div class="anytech-option-post-cover-topbar" id="cover_share">
				<table cellspacing="0">
					<tr>
						<td>
							<img src="<?php echo VOLTAR; ?>images/share.png" class="anytech-option-post-cover-image">
						</td>
						<td valign="center">
							<label class="anytech-option-post-cover-title">Compartilhar</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-option-post-cover-middle">
				<form id="Frm_Compartilhar" method="POST" action="<?php echo VOLTAR; ?>php/CompartilharArtigo.php" style="height: 100%;">
					<textarea id="txt_sobre_share_s" name="sobreCompartilhar" class="cover-textarea" placeholder="<?php echo (($logado != 0) ? 'Escreva algo sobre este artigo...' : 'Efetue o login para compartilhar na ANYTECH!'); ?>" <?php echo (($logado == 0) ? 'disabled' : ''); ?>></textarea>
					<input type="hidden" name="codigoArtigo" id="txt_share_code" value="" readonly/>			
					<input type="hidden" id="txt_share_link" value="" readonly/>
					<div class="info-share">
						<b><label class="cover-label" id="lbl_share_title"></label></b>
						<label class="cover-author" id="lbl_share_author"></label>
					</div>
					<input type="submit" class="mhand" id="btn_compartilhar" style="display: none;"/>
				</form>
			</div>
			
			<div class="anytech-option-post-cover-bottom">
				<?php if($logado != 0){?><input type="button" value="Compartilhar" class="cover-button mhand" id="cover_share_ok";/><?php }?>

				<script>
					<?php if($logado != 0){?>
					cover_share_ok.onclick = function()
					{
						setShares();
					}
					<?php } ?>
					
					function setShares()
					{
						if (txt_sobre_share_s.value != "" && <?php echo $logado; ?> == 1)
						{
							cover_share_ok.disabled = true;
							
							msgShare = txt_sobre_share_s.value;
							cdartShare = txt_share_code.value;
							
							Ajax("GET", "<?php echo VOLTAR; ?>php/CompartilharArtigo.php", "sobreCompartilhar=" + msgShare + "&codigoArtigo=" + cdartShare, "var retorno = this.responseText; if (retorno == 1) {alert('Artigo compartilhado com sucesso!'); hideShareBox(); txt_sobre_share_s.value = '';} else {alert('Não foi possível compartilhar o artigo!');} cover_share_ok.disabled = false;"); 
						} 
						
						return false;
					}
				</script>
				
				<a href="javascript: void(0);" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + txt_share_link.value/*.replace('www.', '')*/,'ventanacompartir', 'toolbar=0, status=0, width=650, height=900px');">
					<input type="image" src="<?php echo VOLTAR; ?>images/facebookshare.png" class="cover-button"  id="cover-share-facebook"></a>
				<a href="javascript: void(0);" data-text="Título Teste" onclick="window.open('https://twitter.com/intent/tweet?text='+lbl_share_title.textContent+'%0a' + txt_share_link.value/*.replace('www.', '')*/ + '%0aSiga @AnyTechOficial','ventanacompartir', 'toolbar=0, status=0, width=650, height=650px');" class="twitter- share-button" data-count="horizontal" data-via="brunowebdev" data-lang="pt">
					<input type="image"  src="<?php echo VOLTAR; ?>images/twittershare.png"  class="cover-button"  id="cover-share-twitter"></a>
				
				<a href="javascript: void(0);" onclick="window.open('https://plus.google.com/share?url=' + txt_share_link.value/*.replace('www.', '')*/,
				'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
					<input type="image"  src="<?php echo VOLTAR; ?>images/googleshare.png"  class="cover-button"  id="cover-share-google"></a>
									
				<input type="button" value="Cancelar" class="cover-button mhand"  id="cover-share-cancel" onclick="hideShareBox()">	
							
			</div>
		</div>
					
		<div class="anytech-option-post-cover" id="box_comment_cover">
			<div class="anytech-option-post-cover-topbar" id="cover_comment">
				<table cellspacing="0">
					<tr>
						<td>
							<img src="<?php echo VOLTAR; ?>images/comment.png" class="anytech-option-post-cover-image">
						</td>
						<td valign="center">
							<label class="anytech-option-post-cover-title">Comentar</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-option-post-cover-middle">
				<textarea id="txt_sobre_share" name="sobreCompartilhar" class="cover-textarea" placeholder="<?php echo (($logado != 0) ? 'Escreva algo sobre este artigo...' : 'Efetue o login para comentar na ANYTECH!'); ?>" <?php echo (($logado == 0) ? 'disabled' : ''); ?>></textarea>
				<a id="commentATx" href="" style="border: 0px; margin-left: 2.5%; margin-right:2.5%; font-size: 0.9em; background-color: transparent;">Comentar via Facebook</a>
			</div>
			<div class="anytech-option-post-cover-bottom">
				<?php if($logado != 0){?><input type="button" value="Comentar" class="cover-button mhand"  id="cover-comment-ok"><?php }?>
				<input type="button" value="Cancelar" class="cover-button mhand"  id="cover-comment-cancel" onclick="hideCommentBox()">		
			</div>
		</div>

		<div class="anytech-option-post-cover" id="box_rating_cover">
			<div class="anytech-option-post-cover-topbar" id="cover_rating">
				<table cellspacing="0">
					<tr>
						<td>
							<img src="<?php echo VOLTAR; ?>images/star.png" class="anytech-option-post-cover-image">
						</td>
						<td valign="center">
							<label class="anytech-option-post-cover-title">Avaliar</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-option-post-cover-middle">
				<div class="info-share mhand">
					<a id="at_ref_art" class="mhand" href="" style="height: 10px; text-align: left; color: black;">
					<label class="cover-label mhand"><b id="lbl_rating_title"></b></label>
					<label class="cover-author mhand" id="lbl_rating_author"></label>
					</a>
				</div>
				<div class="rating-info">
					<label class="cover-label-rating">Avaliação Geral</label>
					<label class="cover-aval-rating" id="at_avalreader"></label>
				</div>
				
				<div class="rating-star-box" id="ratingbox_id">
				</div>
				<script>
					function starSBAYover(starCode)
					{	
						
						counter1 = starCode.split("st");
						counter = parseInt(counter1[1]);
						qR = 1;
						do
						{
							document.getElementById("st"+qR).style.color = "gold";
							qR++;
						}
						while(qR <= counter);					
													
					}
					
					
					function starSBAYout()
					{
						for(ix = 0; ix < 5; ix++)
						{
							jx = ix+1;
							document.getElementById("st"+jx).style.color = "white";
						}
						
						if(vStar !=0)
						{
							
							for(i = 0; i < vStar; i++)
							{
								j = i+1;
								document.getElementById("st"+j).style.color = "gold";
							}
						}
					}
					
					function starSBAYonclick(stVec, stcdArtigo)
					{
						counter2 = stVec.split("st");
						qR = parseInt(counter2[1]);
						vStar = qR;
						Ajax("GET", "<?php echo VOLTAR; ?>php/AvaliarArtigo.php", "avaliacao=" + qR + "&codigoArtigo=" + stcdArtigo, "");
						Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + stcdArtigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); at_avalreader.innerHTML = retorno; at_dsa_text.innerHTML = 'Você avaliou em "+qR+" estrelas';");						
						
						for(ix = 0; ix < 5; ix++)
						{
							jx = ix+1;
							document.getElementById("st"+jx).style.color = "white";
						}
						
						for(i = 0; i < qR; i++)
						{
							j = i+1;
							document.getElementById("st"+j).style.color = "gold";
						}
						
					}
				</script>
					
					<!---->
					<!-- Se o user não tiver visualizado o artigo ainda-->
					<div class="rating-alert" style="display: none;">
						<label class="cover-label-rating-white">Para avaliar este artigo você deve primeiramente lê-lo.<br><a class="rating-redirect-label" href="<?php echo VOLTAR; ?>artigo/<?php echo urlencode($linha_Artigos['ds_url']); ?>">Clique aqui para acessar!</a></label>
					</div>
					<!---->
				
			</div>
			
		
			<div class="anytech-option-post-cover-bottom">
				<input type="button" value="Voltar" class="cover-button mhand"  id="cover-rating-cancel" onclick="hideRatingBox()">		
			</div>
			
		</div>

		<div class="anytech-option-post-cover" id="box_favorite_cover">
			<table cellspacing="0">
				<tr>
					<td>
						<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-option-post-cover-image">
					</td>
					<td valign="center">
						<label class="anytech-option-post-cover-title" id="favotite_title">Artigo favoritado!</label>
					</td>
				</tr>
			</table>
		</div>

		<div class="anytech-option-post-cover" id="box_read_cover">
			<table cellspacing="0" align="center">
				<tr>
					<td>
						<img src="<?php echo VOLTAR; ?>images/time.png" class="anytech-option-post-cover-image">
					</td>
					<td valign="center">
						<label class="anytech-option-post-cover-title" id="read_title">Marcado para leitura!</label>
					</td>
				</tr>
			</table>
		</div>
		<?php			
			if ($logado == 1)
			{
				include VOLTAR.'topbar-on.php';		
				include VOLTAR.'menu.php';	
			?>
			<style>
				#at_corp
				{
					margin-top: 70px;
				}
				
				#jssor_1
				{
					top: 70px;
				}
			</style>
			<?php
			}
			else
			{
				include VOLTAR.'topbar-search.php';
				
				?>
				<style>				
				#jssor_1
				{
					top: 0px;
				}
			</style>
			<?php
			}
			
			if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true) {
		?>
		
		
		<div id="jssor_1" style="position: relative; margin: 0 auto; left: 0px; width: 1300px; height: 1300px; overflow: hidden; visibility: hidden;">
		   
			<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
				<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
				<div style="position:absolute;display:block;background:url('<?php echo VOLTAR; ?>images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
			</div>
			<div data-u="slides" class="at-slider-artigo" style="display: inline-block; cursor: default; position: absolute; top: 0px; left: 0px; width: 1300px; height: 1300px; overflow: hidden;">
				
				<div data-p="225.00" style="display: none;" ondrag="return false">								
					<!--<img class="at-imagem-artigo" alt="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" src="<?php if (isset($imagemArtigo)) {echo VOLTAR.$imagemArtigo;} else {echo VOLTAR.'images/feed/12.jpg';} ?>" />								-->
					<img class="at-imagem-artigo" style=""alt="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" src="<?php echo VOLTAR.(($linha_Artigos['im_thumbnail'] == '') ? 'images/feed/thumbnail.jpg' : $linha_Artigos['im_thumbnail']); ?>" />
					
					<H1 class="at-titulo-artigo" style="font-size: 100px; line-height: 100px; bottom: 700px; text-align: left; text-shadow: 2px 2px 20px rgba(0,0,0,1), -2px -2px 20px rgba(0,0,0,1);"><?php if (isset($titulo)) {echo $titulo;} else {echo 'Informação indisponível';} ?></H1>
					<!--<H2 class="at-descricao-artigo" style=""><?php if ($autorOculto == 1) {echo 'ANYTECH';} else if ($nomeAutor != '') {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?> </b>em <?php if (isset($dataArtigo)) {echo date("d/m/Y", strtotime($dataArtigo)).' às '.date("H:i", strtotime($dataArtigo));} else {echo 'Informação indisponível';} ?></H2>-->
					
				</div>
				
			</div>
			<div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">          
				<div data-u="prototype" style="width:16px;height:16px;"></div>
			</div>
			<span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
			<span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
		 
		</div>
		
		<?php
		}
		else
		{		
		?>
		<div id="jssor_1" style="position: relative; margin: 0 auto; left: 0px; width: 1300px; height: 650px; overflow: hidden; visibility: hidden;">
		   
			<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
				<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
				<div style="position:absolute;display:block;background:url('<?php echo VOLTAR; ?>images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
			</div>
			<div data-u="slides" class="at-slider-artigo" style="display: inline-block; cursor: default; position: absolute; top: 0px; left: 0px; width: 1300px; height: 650px; overflow: hidden;">
				
				<div data-p="225.00" style="display: none;" ondrag="return false">								
					<img class="at-imagem-artigo" alt="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" src="<?php if (isset($imagemArtigo)) {echo VOLTAR.$imagemArtigo;} else {echo VOLTAR.'images/feed/12.jpg';} ?>" />								
					<div style="display: inline-block; background-image: linear-gradient(to top, rgba(0,0,0,0.3), rgba(0,0,0,0)); bottom: 0px; width: 60%; padding-left: 20%; padding-right: 20%; position: absolute; height: auto; padding-top: 300px;">
						<H1 class="at-titulo-artigo" style="position: relative; vertical-align: bottom; height: auto; left: 0px; width:100%; font-size: 3em; margin-bottom: 20px; bottom: 0px; word-spacing: 0px; line-height: 110%;"><?php if (isset($titulo)) {echo $titulo;} else {echo 'Informação indisponível';} ?></H1>
						<H2 class="at-descricao-artigo" style="position: relative; vertical-align: bottom; bottom: 0px; left: 0px; font-size: 1.2em; width:100%;"><?php if ($autorOculto == 1) {echo 'ANYTECH';} else if ($nomeAutor != '') {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?> </b>em <?php if (isset($dataArtigo)) {echo date("d/m/Y", strtotime($dataArtigo)).' às '.date("H:i", strtotime($dataArtigo));} else {echo 'Informação indisponível';} ?></H2>
					</div>
				</div>
				
			</div>
			<div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">          
				<div data-u="prototype" style="width:16px;height:16px;"></div>
			</div>
			<span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
			<span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
		 
		</div>
		<?php
		}
		?>
		<div id="at_corp" style="max-width: 1024px; margin-left: auto; margin-right: auto;">
			<?php			
				if ($logado == 1)
				{
					
				}
				else
				{
									
			?>
					
			<?php
				}
			?>			
			<div class="at-main">
				<?php
					$nivelUsuario = ((isset($_SESSION['AnyTech']['nivelUsuario'])) ? $_SESSION['AnyTech']['nivelUsuario'] : '');
			
					if ($nivelUsuario > 1)
					{
				?>
						<div style="width: 100%; height: 50px; display: block;">
							<table style="width: 100%; height: 100%;">
								<tr>
									<td align="right">
										<input type="button" class="button-follow-author" value="Editar Artigo" onclick="window.location.href = '<?php echo VOLTAR.'at-admin/EditorArtigo.php?codigoArtigo='.$codigoArtigo; ?>';" style="padding: 1%;"/>
									</td>
								</tr>
							</table>
						</div>
				<?php
				}
				?>
				
				<div class="button_share_gplus_art" style="float: right; box-shadow: 0px 2px 2px rgba(0,0,0,0.9); position: relative; width: 40px; margin-top: 10px; height: 40px; padding-right: 5px;  margin-left: 10px;" onclick="window.open('https://plus.google.com/share?url=<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigo['ds_url']; ?>','ventanacompartir','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');">
					<table width="100%" height="35px" valign="center" cellspacing="0">
						<tr valign="center">
							<td width="35px" valign="center">
								<img src="../images/googleshare.png" style="width: 25px; padding-top: 10px; padding-left: 10px;">
							</td>
						</tr>
					</table>
				</div>
				
				<div class="button_share_twitter_art" style="float: right; box-shadow: 0px 2px 2px rgba(0,0,0,0.9); position: relative; width: 40px; margin-top: 10px; height: 40px; padding-right: 5px;  margin-left: 10px;" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigo['ds_url']; ?>%0a%0aSiga @AnyTechOficial','ventanacompartir', 'toolbar=0, status=0, width=650, height=650px');">
					<table width="100%" height="35px" valign="center" cellspacing="0">
						<tr valign="center">
							<td width="35px" valign="center">
								<img src="../images/twittershare2.png" style="width: 25px; padding-top: 10px; padding-left: 10px;">
							</td>
						</tr>
					</table>
				</div>
						
				<div class="button_share_facebook_art" style="float: right; box-shadow: 0px 2px 2px rgba(0,0,0,0.9); margin-bottom: 20px; position: relative; width: 150px; margin-top: 10px; padding-right: 10px; height: 40px; margin-left: 10px;" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigo['ds_url']; ?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=900px');">
					<table width="100%" height="35px" valign="center" cellspacing="0">
						<tr valign="center">
							<td width="35px" valign="center">
								<img src="../images/facebookbar.png" style="width: 25px; padding-top: 10px; padding-left: 10px;">
							</td>
							<td width="auto" valign="center" align="center" style="width: 25px; padding-top: 5px;">
								<label style="color: white; font-size: 0.8em; font-weight: bold;">Compartilhar</label>
							</td>
						</tr>
					</table>
				</div>
				
				<?php include('leitor.php'); ?>
				
				<?php
					if ($nomeFonte != '')
					{
				?>
						<div class="attag">
							<label class="post-font"><a href="<?php echo $urlFonte; ?>" title="Acessar <?php echo $nomeFonte; ?>" target="_blank"><b>Fonte:</b> <?php echo $nomeFonte; ?></a></label>
						</div>
				<?php
					}
				?>
				
				
				<?php
					$result_Topicos = $conexaoPrincipal -> Query("select tb_tema.cd_tema,
																		   tb_tema.nm_tema
																	  from tb_artigo inner join artigo_tema_tag
																		on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
																		  inner join tb_tema
																			on artigo_tema_tag.cd_tema = tb_tema.cd_tema
																		where tb_artigo.cd_artigo = '$codigoArtigo'
																		  order by tb_tema.nm_tema");
					$linha_Topicos = mysqli_fetch_assoc($result_Topicos);
					$total_Topicos = mysqli_num_rows($result_Topicos);
					
					if ($total_Topicos > 0)
					{
						?>
						<div class="attag">
						<label class="post-font" style="font-size: 0.9em;">Tags:</label>
						
						<?php
						do
						{
				?>
							<a href="<?php echo VOLTAR.'news?categoria='.$linha_Topicos['cd_tema']; ?>" target="_top" title="Ir para o categoria <?php echo $linha_Topicos['nm_tema']; ?>"><label style="cursor: pointer;" class="topic"><?php echo $linha_Topicos['nm_tema']; ?></label></a>
				<?php
						}
						while ($linha_Topicos = mysqli_fetch_assoc($result_Topicos));
						?>
							</div>
						<?php	
					}
					
				?>
				<br>
				<div class="anytech-post-buttons-art" style="display: inline-block; background-color: #fdfdfd;" align="left" >
					<table class="table-anytech-buttons"valign="center">
						<tr>
							<td>
								<input type="image" id="col_one_anytech_post_rating<?php echo $linha_Artigo['cd_artigo']; ?>" class="anytech-post-rating" src="../images/star.png">
							</td>
							<td>
								<label class="button-value" id="lbl_value_avaliacao" style="color:blue"><?php $exibe = number_format($linha_Artigo['qt_estrelas'],1,'.',','); if($exibe >0){echo $exibe;}else{ echo "5.0";} ?></label>
							</td>
							<td>
								<input type="image" id="col_one_anytech_post_comment<?php echo $linha_Artigo['cd_artigo']; ?>" class="anytech-post-comment" src="../images/comment.png" onclick="txt_comentario.focus();">
							</td>
							<td>
								<label class="button-value" id="lbl_value_comentario" style="color:gold"><?php echo $linha_Artigo['qt_comentario']; ?></label>
							</td>
							<td>
								<input type="image" id="col_one_anytech_post_share<?php echo $linha_Artigo['cd_artigo']; ?>" class="anytech-post-share" src="../images/share.png" onclick="showShareBox('<?php echo $linha_Artigo['cd_artigo']; ?>', '<?php if ($linha_Artigo['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigo['nm_titulo'];} ?>', 'por <?php if ($linha_Artigo['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigo['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigo['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigo['ds_url']; ?>');">
							</td>
							<td>
								<label class="button-value" id="lbl_value_compartilhar" style="color:green"><?php echo $linha_Artigo['qt_compartilhar']; ?></label>
							</td>
							<td>
								<input type="image" id="col_one_anytech_post_favorite<?php echo $linha_Artigo['cd_artigo']; ?>" class="anytech-post-favorite" src="../images/favorite.png">
							</td>
							<td>
								<label class="button-value" id="lbl_value_favorito" style="color:red"><?php echo $linha_Artigo['qt_favorito']; ?></label>
							</td>
						<tr>
					</table>
					<script>
						col_one_anytech_post_rating<?php echo $linha_Artigo['cd_artigo']; ?>.onclick = function()
						{
							EsconderValores();
							col_one_anytech_post_rating<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = true;
							//col_one_anytech_post_time<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = true;
							col_one_anytech_post_comment<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = true;
							col_one_anytech_post_favorite<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = true;
							col_one_anytech_post_share<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = true;
							var codigo = <?php echo $linha_Artigo['cd_artigo']; ?>;
							
							Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); at_avalreader.innerHTML = retorno; showRatingBox(spt[1],spt[2], '<?php echo $linha_Artigo['nm_titulo']; ?>','por <?php if ($linha_Artigo['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigo['nm_usuario'] == '')  {echo 'Autor desconhecido';} else {echo $linha_Artigo['nm_usuario'];} ?>','<?php echo VOLTAR."artigo/".$linha_Artigo['ds_url']; ?>','<?php echo $linha_Artigo['cd_artigo']; ?>'); col_one_anytech_post_rating<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = false; col_one_anytech_post_comment<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = false;col_one_anytech_post_favorite<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = false;col_one_anytech_post_share<?php echo $linha_Artigo['cd_artigo']; ?>.disabled = false;");
						}
						
						
						col_one_anytech_post_rating<?php echo $linha_Artigo['cd_artigo']; ?>.onmouseover = function()
						{
							EsconderValores();
							
							var codigo = <?php echo $linha_Artigo['cd_artigo']; ?>;							
																					
							Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); lbl_value_avaliacao.innerHTML = retorno;");

						}
						
						
						col_one_anytech_post_favorite<?php echo $linha_Artigo['cd_artigo']; ?>.onclick = function()
						{
							var codigo = <?php echo $linha_Artigo['cd_artigo']; ?>;
							
							if (<?php echo $logado ?> == 1)
							{
								Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox('Artigo favoritado!');} else if (retorno == 0) {showFavoriteBox('Artigo desfavoritado!');} col_one_anytech_post_favorite<?php echo $linha_Artigo['cd_artigo']; ?>.onmouseover();");
							}
							else
							{
								alert('Efetue login para executar essa ação!');
							}
						}
						
						
														
						col_one_anytech_post_comment<?php echo $linha_Artigo['cd_artigo']; ?>.onmouseover = function()
						{
							EsconderValores();
							
							var codigo = <?php echo $linha_Artigo['cd_artigo']; ?>;
														
							Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; lbl_value_comentario.textContent = retorno; ");
						}
						
						
						col_one_anytech_post_share<?php echo $linha_Artigo['cd_artigo']; ?>.onmouseover = function()
						{
							var codigo = <?php echo $linha_Artigo['cd_artigo']; ?>;
							
							EsconderValores();							
							
							Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; lbl_value_compartilhar.textContent = retorno;");
						}
						
						col_one_anytech_post_favorite<?php echo $linha_Artigo['cd_artigo']; ?>.onmouseover = function()
						{
							EsconderValores();
							
							var codigo = <?php echo $linha_Artigo['cd_artigo']; ?>;		
							
							Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; var aux = retorno.split(';-;')[0]; var qnt = retorno.split(';-;')[1]; var conteudo = ''; if (aux == 1) {if (qnt > 1) {if (qnt - 1 > 1) {conteudo = 'Você e outras ' + (qnt - 1) + ' pessoas favoritaram';} else {conteudo = 'Você e outra pessoa favoritaram';}} else {conteudo = 'Você favoritou';}} else {conteudo = qnt + ((qnt == 1) ? ' pessoa favoritou' : ' pessoas favoritaram');} lbl_value_favorito.textContent = qnt;");
						}
						
						
					</script>
				</div>
				
				<?php
					if ($autorOculto != 1)
					{
				?>
						<div class="author-info">
							<Table>
								<tr>
									<td>
										<img src="../<?php if (!isset($imagemAutor) || $imagemAutor == '') {echo 'images/user.png';} else {echo $imagemAutor;} ?>" class="author-image">
									</td>
									<td>
										<label class="anytech-art-by">Artigo escrito por</label>
										<label class="anytech-author" id="lkcomm"><a href="<?php if ($autorOculto == 1 || $nicknameAutor == '') {echo VOLTAR.'news';} else {echo VOLTAR.'@'.$nicknameAutor;} ?>" title="Ir para o perfil do autor" target="_blank"><?php if ($nomeAutor != '') {echo $nomeAutor;} else {echo 'Autor desconhecido';} ?></a></label>
										<?php 
											if($nomeAutor != '' && isset($codigoUsuario) && $codigoUsuario != $codigoAutor) 
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
				<?php
					}
				?>
				
				<h2 class="at-bloco-titulo" style="color: purple; border-bottom: 2px solid purple; line-height: 150%">Comentários(<label id="qt_comentarios"><?php echo $total_Comentarios; ?></label>)</h2>
				<input type="button" id="changeC" style="border:0px; background-color: #3B5998; color:#fff; padding:3px; padding-right: 10px; padding-left: 10px; margin-bottom: 20px;" value="Comentar via Facebook" onclick="if (at_comments.style.display == 'none') {this.value = 'Comentar via Facebook'; at_comments.style.display = 'block'; fb_comments.style.display = 'none';} else {this.value = 'Comentar pelo perfil no ANYTECH'; at_comments.style.display = 'none'; fb_comments.style.display = 'block';}">				
				
				<div id="at_comments" style="display: block;">
					<!--<label class="anytech-comment-titles" style="margin-top: 0px;">Comentários (<label id="qt_comentarios"><?php echo $total_Comentarios; ?></label>)</label>-->
					<br/>
					<br/>
					<label class="anytech-notify" id="notificacao_comentario" style="display: none;"></label>
					<form id="Frm_Comentario" method="POST" action="php/EnviarComentario.php">
						<div class="anytech-art-comment-now">
							<input type="hidden" name="codigoArtigo" value="<?php echo $codigoArtigo; ?>" required/>
							<textarea id="txt_conteudo" name="comentarioArtigo" class="comment-area" data-autoresize rows="1" style="display: none;"></textarea>
							<textarea id="txt_comentario" class="comment-area" data-autoresize rows="1" placeholder="<?php if (!isset($codigoUsuario)) {echo 'Efetue login para deixar seu comentário';} else {echo 'Deixe seu comentário';} ?>" required <?php echo ((!isset($codigoUsuario)) ? 'disabled' : ''); ?>></textarea>
							<?php
								if (isset($codigoUsuario))
								{
							?>
									<input type="submit" id="btn_enviar" value="Enviar" class="button-comment-submit"/>
							<?php
								}
							?>
						</div>
					</form>
					
					<script>
						function AtualizarComentarios()
						{
							setInterval('CarregarComentarios();', 3000);
						}
						
						AtualizarComentarios();
					
						function CarregarComentarios()
						{
							var comentarios = document.getElementsByClassName('anytech-art-comment');
								comentarios = Array.prototype.slice.call(comentarios);
							
							var codigos = '';
							
							for (cont = 0; cont <= comentarios.length - 1; cont = cont + 1)
							{
								if (cont == comentarios.length - 1)
								{
									codigos = codigos + comentarios[cont].getAttribute('codigoComentario');
								}
								else
								{
									codigos = codigos + comentarios[cont].getAttribute('codigoComentario') + ';';
								}
							}
							
							Ajax("GET", "php/BuscarComentarios.php", "codigoArtigo=<?php echo $codigoArtigo; ?>&codigosComentarios=" + codigos, "var retorno = this.responseText; var aux = retorno.split('<--;-;--\>'); var quant = aux[0].trim(); qt_comentarios.textContent = quant; lbl_value_comentario.textContent = quant; if (quant != 0) {try {anytech_comentarios.removeChild(anytech_comentarios.getElementsByTagName('center')[0]);} catch (exe) {var a = '';} anytech_comentarios.innerHTML = aux[1].trim() + anytech_comentarios.innerHTML;} else {anytech_comentarios.innerHTML = aux[1].trim();}");
						}
						
						Frm_Comentario.onsubmit = function()
						{
							txt_conteudo.value = txt_comentario.value;
							
							if (txt_conteudo.value.trim() != "")
							{
								AjaxForm(this, "txt_comentario.disabled = true; btn_enviar.disabled = true;", "txt_comentario.disabled = false; btn_enviar.disabled = false; var retorno = this.responseText; var aux = retorno.split(';-;'); var enviou = aux[0]; var aviso = aux[1]; notificacao_comentario.textContent = aviso; $(notificacao_comentario).show(); if (enviou == 1) {Frm_Comentario.reset();}");
							}
							
							return false;
						}
					</script>
					
					<div id="anytech_comentarios">
						<?php
							if ($total_Comentarios > 0)
							{
								do
								{
						?>
									<div class="anytech-art-comment" codigoComentario="<?php echo $linha_Comentarios['cd_comentario_artigo']; ?>">
										<table class="table-comment">
											<tr>
												<td>
													<img src="../<?php if ($linha_Comentarios['im_perfil'] == '') {echo 'images/user.png';} else {echo $linha_Comentarios['im_perfil'];} ?>" class="comment-image">
												</td>
												<td>
													<label class="comment-author"><?php echo $linha_Comentarios['nm_usuario_completo']; ?></label><br>
													<label class="comment-date"><?php echo date('d/m/Y', strtotime($linha_Comentarios['dt_comentario_artigo'])); ?> às <?php echo date('H:i:s', strtotime($linha_Comentarios['dt_comentario_artigo'])); ?></label>							
												</td>
											</tr>
										</table>
										<label class="comment-text"><?php echo trim(htmlentities($linha_Comentarios['ds_conteudo'], ENT_QUOTES, 'UTF-8')); ?></label>
										<?php
											if (isset($codigoUsuario))
											{
										?>
												<table width="100%" class="table-aval-com">
													<tr>
														<td width="22px">
															<img src="../images/like.png" id="btn_avaliacao<?php echo $linha_Comentarios['cd_comentario_artigo']; ?>" class="com-like" onclick="EnviarAvaliacao('<?php echo $linha_Comentarios['cd_comentario_artigo']; ?>');">
														</td>
														<td width="50px"  valign="top">
															<label class="com-aval-label" id="qt_avaliacao<?php echo $linha_Comentarios['cd_comentario_artigo']; ?>"><?php echo $linha_Comentarios['qt_avaliacao']; ?></label>
														</td>
														<td width="22px">
															<img src="../images/negativo.png" class="com-delation">
														</td>
														<td  valign="top">
															<label class="com-aval-label-del">denunciar</label>
														</td>
													<tr>
												</table>
										<?php
											}
										?>
									</div>
						<?php
								}
								while ($linha_Comentarios = mysqli_fetch_assoc($result_Comentarios));
							}
							else
							{
						?>
								<center><label class="anytech-comment-titles">Não perca tempo e seja o primeiro á comentar.</label></center>
						<?php
							}
						?>
					</div>
					
					<form id="Frm_Avaliacao" method="POST" action="<?php echo VOLTAR; ?>php/AvaliarComentarioArtigo.php">
						<input type="hidden" name="codigoComentario" id="txt_avaliacao" value="" required/>
						<input type="submit" id="btn_avaliacao" style="display: none;"/>
					</form>

					<script>
						var loading = 0;
						var codigoComentario = '';
						var auxEval = '';
						
						function EnviarAvaliacao(auxCodigoComentario)
						{
							if (loading == 0 && auxCodigoComentario != '')
							{
								txt_avaliacao.value = auxCodigoComentario;
								codigoComentario = auxCodigoComentario;
								auxEval = 'qt_avaliacao' + auxCodigoComentario;
								
								btn_avaliacao.click();
							}
						}
						
						Frm_Avaliacao.onsubmit = function()
						{
							AjaxForm(this, "loading = 1;", "loading = 0; var retorno = this.responseText; var aux = retorno.split(';-;'); var enviou = aux[0]; var quantidade = aux[1]; if (enviou == 1) {eval(auxEval + '.textContent = ' + quantidade);}");
							
							return false;
						}
					</script>
				</div>
				
				<div id="fb_comments" style="display: none;">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-comments" data-href="http://<?php echo str_replace('www.', '', $_SERVER['SERVER_NAME']).$_SERVER ['REQUEST_URI']; ?>" data-width="100%" data-numposts="1"></div>
				</div>
				<?php
					$endereco = $_SERVER ['REQUEST_URI'];
					$sep = explode("?",$endereco);	
					
					if($sep[1] == "fb")
					{
						echo'<script type="text/javascript">
						  changeC.click();
						  changeC.focus();
						</script>';
					};
				?>
				<div class="anytech-others">
					<h2 class="at-bloco-titulo" style="color: purple; border-bottom: 2px solid purple; line-height: 150%">Recomendamos para você</h2>			
					<?php
						
						$result_Artigos = $conexaoPrincipal -> Query($query_ArtigosRecomendados);
						$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
						$total_Artigos = mysqli_num_rows($result_Artigos);
					
						if ($total_Artigos > 0)
						{
							do
							{
								/*FormatarTags($linha_Artigos['ds_tags']);*/
					?>
						<div class="at-bloco-artigo">
							<a href="<?php echo VOLTAR; ?>artigo/<?php echo urlencode($linha_Artigos['ds_url']); ?>" target="_blank"><div class="at-bloco-imagem" alt="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>"style="background-image: url('<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_thumbnail'] == '') {echo 'images/feed/thumbnail.jpg';} else {echo $linha_Artigos['im_thumbnail'];} ?>');"></div></a>
							<div class="at-bloco-desc">
								
								<a style="margin-bottom: 0px; text-align: left; width: 100%;" href="<?php echo VOLTAR; ?>artigo/<?php echo urlencode($linha_Artigos['ds_url']); ?>" target="_blank"><h2 class="at-bloco-artigo-titulo"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></h2></a>
								<h2 class="at-bloco-artigo-autor">por <a href="<?php if ($linha_Artigos['ic_autor_oculto'] == 1 || $linha_Artigos['nm_nickname'] == '') {echo VOLTAR.'news';} else {echo VOLTAR.'@'.$linha_Artigos['nm_nickname'];} ?>" title="Ir para o perfil do autor" class="at-author-link" target="_blank"><?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?></a> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></h2>
								<h2 class="at-bloco-artigo-desc"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></h2>
								
								<h2 class="at-bloco-artigo-buttons-desc">
									<table style="width: 100%;" cellspacing="5">
										<tr>
											<td align="left">
												<!--<label>Visualizações: <label><?php echo $linha_Artigos['qt_visita']; ?></label></label>-->
											</td>
											<td align="left">
												<input type="image" id="col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-rating rctY" src="<?php echo VOLTAR; ?>images/star.png">
												<input type="image" id="col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-comment rctY" src="<?php echo VOLTAR; ?>images/comment.png" onclick="showCommentBox()">
												<input type="image" id="col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-share rctY" src="<?php echo VOLTAR; ?>images/share.png" onclick="botaoCompartilhar = this; showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
												<input type="image" id="col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-favorite rctY" src="<?php echo VOLTAR; ?>images/favorite.png"/>
												<input type="image" id="col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-time rctY" src="<?php echo VOLTAR; ?>images/time.png"/>
												<!--<label>Avaliações: <label id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>">-</label></label><br/>-->
											</td>
										</tr>
									</table>
									<h2 class="at-bloco-artigo-desc-result" id="view1<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_visita']; ?> visualizaç<?php echo (($linha_Artigos['qt_visita'] == 1) ? 'ão' : 'ões'); ?></h2>
									<label class="at-bloco-artigo-desc-result" style="display: none; color:blue; background-color: #fff;" id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>"><?php $stars = number_format($linha_Artigos['qt_estrelas'], 1, '.',','); if($linha_Artigos['qt_estrelas'] > 0) { if ($linha_Artigos['qt_estrelas'] == 1){echo $stars." estrela";} else {echo $stars.' estrelas';}} else {echo '5.0 estrelas';}?></label>
									<label class="at-bloco-artigo-desc-result" style="display: none; color:red; background-color: #fff;" id="col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_favorito'].' favoritadas'; ?></label>
									<label class="at-bloco-artigo-desc-result" style="display: none; color:gold; background-color: #fff;" id="col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_comentario'].' comentários'; ?></label>
									<label class="at-bloco-artigo-desc-result" style="display: none; color:green; background-color: #fff;" id="col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_compartilhar'].' compartilhamentos'; ?></label>
									<label class="at-bloco-artigo-desc-result" style="display: none; color:#333; background-color: #fff;" id="col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_leitura'].' marcações'; ?></label>
									<!--<table>
										<tr>
											<td align="left">
												
												<label>Comentários: <label id="col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_comentario']; ?></label></label>
											</td>
											<td align="left">
												
												
												<label>Compartilhamentos: <label id="col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_compartilhar']; ?></label></label><br/>
											</td>
										</tr>
										<tr>
											<td align="left">
												
												<label>Favoritos: <label id="col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_favorito']; ?></label></label>
											</td>
											<td align="left">
												
												
												<label>Ler depois: <label id="col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_leitura']; ?></label></label><br/>
											</td>
										</tr>
									</table>-->
								</h2>
								<script>
									col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
									{
										EsconderValores();
										col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
										col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
										col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
										col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
										col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); at_avalreader.innerHTML = retorno; showRatingBox(spt[1],spt[2], '<?php echo $linha_Artigos['nm_titulo']; ?>','por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '')  {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>','<?php echo VOLTAR."artigo/".$linha_Artigos['ds_url']; ?>','<?php echo $linha_Artigos['cd_artigo']; ?>'); col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false; col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;");
										
									}
									
									col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
									{
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										if (<?php echo $logado ?> == 1)
										{
											Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox('Artigo favoritado!');} else if (retorno == 0) {showFavoriteBox('Artigo desfavoritado!');} col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover();");
										}
										else
										{
											alert('Efetue login para executar essa ação!');
										}
									}
									
									col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
									{
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										if (<?php echo $logado ?> == 1)
										{
											Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox('Marcado para leitura!');} else if (retorno == 0) {showReadBox('Desmarcado para leitura!');} col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover();");
										}
										else
										{
											alert('Efetue login para executar essa ação!');
										}
									}
									
									col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
									{
										EsconderValores();
										
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										
										col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
										
																								
										Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); if(retorno > 0){ if(retorno == 1){col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = retorno+' estrela'}else{col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = retorno+' estrelas';}} else {col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = '5.0 estrela';}");

									}
									
									col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
									{
										col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';															
										
									}
									
									col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
									{
										EsconderValores();
										
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										//Tirei isso aqui de dentro da função abaixo
										
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										
										col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
										
										Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + '  comentários'; ");
									}
									
									col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
									{
										
										col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
									}
									
									col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
									{
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										EsconderValores();
										
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
										
										Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' compartilhamento' + ((retorno == 1) ? '' : 's');");
									}
									
									col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
									{
										col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
									}
									
									col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
									{
										EsconderValores();
										
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';

										col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
										if (<?php echo $logado ?> == 1)
										{
											Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; var aux = retorno.split(';-;')[0]; var qnt = retorno.split(';-;')[1]; var conteudo = ''; if (aux == 1) {if (qnt > 1) {if (qnt - 1 > 1) {conteudo = 'Você e outras ' + (qnt - 1) + ' pessoas favoritaram';} else {conteudo = 'Você e outra pessoa favoritaram';}} else {conteudo = 'Você favoritou';}} else {conteudo = qnt + ((qnt == 1) ? ' pessoa favoritou' : ' pessoas favoritaram');} col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = conteudo;");
										}
										else
										{
											Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigoOff.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' favoritada' + ((retorno == 1) ? '' : 's');");
										}
									}
									
									col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
									{
										col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
									}
									
									col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
									{
										EsconderValores();
										
										
										var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
										
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
										
										if (<?php echo $logado ?> == 1)
										{
											Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; var aux = retorno.split(';-;')[0]; var qnt = retorno.split(';-;')[1]; var conteudo = ''; if (aux == 1) {if (qnt > 1) {if (qnt - 1 > 1) {conteudo = 'Você e outras ' + (qnt - 1) + ' pessoas marcaram';} else {conteudo = 'Você e outra pessoa marcaram';}} else {conteudo = 'Você marcou';}} else {conteudo = qnt + ((qnt == 1) ? ' pessoa marcou' : ' pessoas marcaram');} col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = conteudo;");
										}
										else
										{
											Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigoOff.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' marcaç' + ((retorno == 1) ? 'ão' : 'ões');");
										}
									}
									
									col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
									{
										col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
										view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
									}
								</script>
								<!--<input class="at-bloco-artigo-btn" style="background-color: purple;" type="button" value="Ler Artigo">-->
							</div>
						</div>
						
					
					<span class="anytech-line"></span>	
					
					<?php
							}
							while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
						}
					?>
				</div>
			</div>
			
			<div class="at-lateral">
			<?php
				$lateral_sugestao = $conexaoPrincipal -> Query("SELECT * FROM tb_artigo inner join artigo_tema_tag
																on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
																inner join tb_tema
																on tb_tema.cd_tema = artigo_tema_tag.cd_tema order by rand() desc limit 3") or die("Mensagem Não Enviada");
						
				$linha_ls = mysqli_fetch_assoc($lateral_sugestao);
				$total_ls = mysqli_num_rows($lateral_sugestao);

				if ($total_ls > 0)
				{
					do
					{	
						$url_ls = VOLTAR."artigo/".$linha_ls['ds_url'];
						$titulo_ls = $linha_ls['nm_titulo'];
						$imagem_ls = $linha_ls['im_thumbnail'];
						$tag_ls = $linha_ls['nm_tema'];
					?>
						<div class="at-standard-banner">	
							
							<h2 class="at-standard-banner-category"><?php echo $tag_ls;?></h2>
							<h2 class="at-standard-banner-desc mhand"><a href="<?php echo $url_ls; ?>" style="text-decoration: none; margin-bottom: 0px; bottom: 20px; color: white; text-align: left;"><?php echo $titulo_ls; ?></a></h2>
							<a href="<?php echo $url_ls; ?>" class="at-standard-image"  alt="<?php if (isset($imagem_ls)) {$tr = str_replace('artigo/imagens/','',$imagem_ls); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagem_ls)) {$tr = str_replace('artigo/imagens/','',$imagem_ls); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>"  style="cursor: pointer; background-image: url('<?php if(isset($imagem_ls)){echo VOLTAR.$imagem_ls;} else { echo VOLTAR.'images/feed/thumbnail.jpg';} ?>');"></a>
							
						</div>
						
					<?php
					
					}
					while ($linha_ls = mysqli_fetch_assoc($lateral_sugestao));
					
				}
			?>
			</div>
			<div class="anytech-art-content">	
			</div>
						
		</div>
		<?php include(VOLTAR.'footer.php'); ?>	
	</body>
	<script src="../js/jquery.min.js"></script>	
	<script src="../js/topbar.js"></script>
	<script src="../js/commentarea.js"></script>
	<script>
        jssor_1_slider_init();
    </script>
	<script>	
	
		<?php	
		
		if($linha_Artigo['cd_artigo'] == 124)
		{
			echo"
				window.onload = function()
				{
					ICQS();	
				}
				
				window.onclick = function()
				{
					ICQS();	
				}
				
				function ICQS()
				{
					var audio = new Audio('ANYTECH_ICQ_SOUND.mp3');
					audio.play();
				}
				
				";
		}
		?>
		
		
		function EsconderValores()
		{
			var aux = document.getElementsByClassName('value-btn');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				aux[cont].style.display = 'none';
			}
		}
		
		function showFavoriteBox(title)
			{
				favotite_title.textContent = title;
				$('#box_favorite_cover').fadeIn();
				setTimeout('hideFavoriteBox();',2000);
			}
			
			function hideFavoriteBox()
			{
				$('#box_favorite_cover').fadeOut();
			}
			
			function showReadBox(title)
			{
				read_title.textContent = title;
				
				$('#box_read_cover').fadeIn();
				setTimeout('hideReadBox();',2000);
			}
			
			function hideReadBox()
			{
				$('#box_read_cover').fadeOut();
			}
			
			function showRatingBox(qtST, bL, title, author, link, code)
			{
				vStar = 0;
				vStar = qtST;
				lbl_rating_title.innerHTML = title;
				lbl_rating_author.innerHTML = author;
				at_ref_art.href = link;
				<?php			
				if ($logado == 1)
				{
				?>
					if(bL == 1)
					{	
						
						isnt = "";
						
						if(vStar > 0)
						{
							isnt += "<label class='cover-label-rating-white' id='at_dsa_text'>Você avaliou em "+vStar+" estrelas</label>";	
							//at_dsa_text.innerHTML = "Você avaliou em "+vStar+" estrelas";
						}
						else
						{
							isnt += "<label class='cover-label-rating-white' id='at_dsa_text'>Deixe sua avaliação</label>";	
							//at_dsa_text.innerHTML = "Deixe sua avaliação";
						}				
						isnt += "<div class=\'rating\' align=\'center\'>";
						isnt += "<span id='st1' class='mhand' onmouseover='starSBAYover(this.id)' onmouseout='starSBAYout()' onclick='starSBAYonclick(this.id,"+code+")'>★</span>";
						isnt += "<span id='st2' class='mhand' onmouseover='starSBAYover(this.id)' onmouseout='starSBAYout()' onclick='starSBAYonclick(this.id,"+code+")'>★</span>";
						isnt += "<span id='st3' class='mhand' onmouseover='starSBAYover(this.id)' onmouseout='starSBAYout()' onclick='starSBAYonclick(this.id,"+code+")'>★</span>";
						isnt += "<span id='st4' class='mhand' onmouseover='starSBAYover(this.id)' onmouseout='starSBAYout()' onclick='starSBAYonclick(this.id,"+code+")'>★</span>";
						isnt += "<span id='st5' class='mhand' onmouseover='starSBAYover(this.id)' onmouseout='starSBAYout()' onclick='starSBAYonclick(this.id,"+code+")'>★</span>";
						isnt += "</div>";					
						
						ratingbox_id.innerHTML = isnt;
						starSBAYout();	
					}
					else
					{	
						isnt = "";
						isnt += "<div class='rating-alert'>";
						isnt += "<label class='cover-label-rating-white'>Para avaliar este artigo você primeiramente lê-lo.<br><a class='rating-redirect-label' href='"+link+"' target='_blank' onclick='hideRatingBox();'>Clique aqui para acessar!</a></label>";
						isnt += "</div>";
						
						ratingbox_id.innerHTML = isnt;
					}					
				<?php
				}
				else
				{
				?>
					isnt = "";
					isnt += "<div class='rating-alert'>";
					isnt += "<label class='cover-label-rating-white'>Para avaliar este artigo você deve estar logado.<br><a class='rating-redirect-label' onclick='anytech_login_button.click();'>Clique aqui para logar!</a></label>";
					isnt += "</div>";
					ratingbox_id.innerHTML = isnt;
				<?php
				}
				?>
							
				document.body.style.overflow = "hidden";
				$('.maincover').fadeIn();
				$('#box_rating_cover').toggle('slide');
			}
			
			function hideRatingBox()
			{
				document.body.style.overflow = "visible";
				$('#box_rating_cover').toggle('slide');
				$('.maincover').fadeOut();
			}
			
			function showShareBox(codigo, titulo, autor, link)
			{
				document.body.style.overflow = "hidden";
				lbl_share_title.textContent = titulo;
				lbl_share_author.textContent = autor;
				txt_share_link.value = link;
				txt_share_code.value = codigo;
				
				$('.maincover').fadeIn();
				$('#box_share_cover').toggle('slide');
			}
			
			function hideShareBox()
			{
				document.body.style.overflow = "visible";
				$('#box_share_cover').toggle('slide');
				$('.maincover').fadeOut();
			}
			
			
			
			function showCommentBox(atlk)
			{
				document.body.style.overflow = "hidden";
				commentATx.href = atlk;
				$('.maincover').fadeIn();
				$('#box_comment_cover').toggle('slide');
			}
			
			function hideCommentBox()
			{
				document.body.style.overflow = "visible";
				$('#box_comment_cover').toggle('slide');
				$('.maincover').fadeOut();
			}		
	</script>
</html>

<?php
	if ((!isset($codigoUsuario)) || (isset($codigoUsuario) && $codigoUsuario != $codigoAutor))
	{
		$result = $conexaoPrincipal -> Query("insert into tb_visita(cd_artigo, cd_usuario, dt_visita) values('$codigoArtigo', ".((isset($codigoUsuario)) ? "'$codigoUsuario'" : "null").", now())");
		
		if (!$result)
		{
			echo mysqli_error($conexaoPrincipal -> getConexao());
		}
	}
	
	//$conexaoPrincipal -> FecharConexao();
?>