<?php
	if (!isset($logado))
	{
		exit;
	}
	
	$deslocamento = 0;
	$limite = 5;
	$timeAtual = date('Y/m/d H:i:s');
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png"/>
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed-media-query-sizeone.css">
		<title>ANYTECH - Feed de notícias</title>
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
				include VOLTAR.'topbar-off.php';
			}
		?>
		<div class="anytech-body">
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
					<textarea id="txt_sobre_share" name="sobreCompartilhar" class="cover-textarea" placeholder="Escreva algo sobre este artigo..."></textarea>
					<input type="hidden" name="codigoArtigo" id="txt_share_code" value="" readonly/>			
					<input type="hidden" id="txt_share_link" value="" readonly/>
					<div class="info-share">
						<b><label class="cover-label" id="lbl_share_title">P.O.P. - Programação Orientada à Potássio</label></b>
						<label class="cover-author" id="lbl_share_author">por Gustavo Alves</label>
					</div>
				</div>
				
				<div class="anytech-option-post-cover-bottom">
					<input type="button" value="Compartilhar" class="cover-button" id="cover_share_ok"/>

					<script>
						cover_share_ok.onclick = function()
						{
							if (txt_sobre_share.value.trim() != "" && <?php echo $logado; ?> == 1)
							{
								cover_share_ok.disabled = true;
								
								Ajax("GET", "<?php echo VOLTAR; ?>php/CompartilharArtigo.php", "codigoArtigo=" + txt_share_code.value + "&sobreCompartilhar=" + txt_sobre_share.value.trim(), "cover_share_ok.disabled = false; var retorno = this.responseText; if (retorno == 1) {txt_sobre_share.value = ''; hideShareBox();}"); 
							}
						}
					</script>
					
					<a href="javascript: void(0);" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+txt_share_link.value,'ventanacompartir', 'toolbar=0, status=0, width=650, height=900px');">
						<input type="image" src="<?php echo VOLTAR; ?>images/facebookshare.png" class="cover-button"  id="cover-share-facebook"></a>
					<a href="javascript: void(0);" data-text="Título Teste" onclick="window.open('https://twitter.com/intent/tweet?text='+lbl_share_title.textContent+'%0a'+txt_share_link.value+'%0aSiga @AnyTechOficial','ventanacompartir', 'toolbar=0, status=0, width=650, height=650px');" class="twitter- share-button" data-count="horizontal" data-via="brunowebdev" data-lang="pt">
						<input type="image"  src="<?php echo VOLTAR; ?>images/twittershare.png"  class="cover-button"  id="cover-share-twitter"></a>
					
					<a href="javascript: void(0);" onclick="window.open('https://plus.google.com/share?url='+txt_share_link.value,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<input type="image"  src="<?php echo VOLTAR; ?>images/googleshare.png"  class="cover-button"  id="cover-share-google"></a>
										
					<input type="button" value="Cancelar" class="cover-button"  id="cover-share-cancel" onclick="hideShareBox()">	
								
				</div>
			</div>
						
			<div class="anytech-option-post-cover">
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
					
				</div>
				<div class="anytech-option-post-cover-bottom">
					<input type="button" value="Comentar" class="cover-button"  id="cover-comment-ok">						
					<input type="button" value="Cancelar" class="cover-button"  id="cover-comment-cancel">		
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
					<div class="info-share">
						<label class="cover-label"><b>P.O.P. - Programação Orientada à Potássio</b></label>
						<label class="cover-author">por Gustavo Alves</label>
					</div>
				</div>
				<div class="anytech-option-post-cover-bottom">
					<input type="button" value="Avaliar" class="cover-button"  id="cover-rating-ok">						
					<input type="button" value="Cancelar" class="cover-button"  id="cover-rating-cancel" onclick="hideRatingBox()">		
				</div>
			</div>
			
			<div class="anytech-option-post-cover" id="box_favorite_cover">
				<table cellspacing="0">
					<tr>
						<td>
							<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-option-post-cover-image">
						</td>
						<td valign="center">
							<label class="anytech-option-post-cover-title">Artigo favoritado!</label>
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
							<label class="anytech-option-post-cover-title">Marcado para leitura!</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-group-posts">
				<table width="100%" cellspacing="0">
					<tr>
						<td width="95%">
							<div class="anytech-suggestion" id="anytech_suggestion">
								<!--<input type="button" value="Teste de Pesquisa" class="suggestion-item" id="suggestion_item">-->
							</div>
							<div class="anytech-search">
								<form id="Frm_Pesquisa" method="POST" action="<?php echo VOLTAR; ?>php/PesquisarFeed.php">
									<table width="100%" cellspacing="0">
										<tr>
											<td width="100%">
												<input type="text" class="anytech-search-input" placeholder="Digite sua pesquisa" id="anytech_feed_input_search" name="valorBusca" autocomplete="off" required>
											</td>
											<td width="30px">
												<input type="image" id="btn_pesquisar" class="anytech-search-button" src="<?php echo VOLTAR; ?>images/searcha.png" onclick="btn_pesquisar.click();">
												<input type="submit" id="btn_pesquisar" style="display: none;">
											</td>
										</tr>
									</table>
								</form>
								<script>
									Frm_Pesquisa.onsubmit = function()
									{
										AjaxForm(this, "btn_pesquisar.disabled = true;", "btn_pesquisar.disabled = true; var retorno = this.responseText; var resultados = retorno.split('###'); OrdenarColunasSearch(resultados);");
										
										return false;
									}
									
									function OrdenarColunasSearch(resultados)
									{
										search_anytech_col_one.innerHTML = '';
										search_anytech_col_two.innerHTML = '';
										search_anytech_col_three.innerHTML = '';
										
										counter = 0;
										
										for(k = 0; k < resultados.length; k++)
										{ 
											if(counter == 0)
											{
												search_anytech_col_one.innerHTML += resultados[k];
												counter++;
											}
											else if(counter == 1)
											{
												search_anytech_col_two.innerHTML += resultados[k];
												counter++;
											}
											else if(counter == 2)
											{
												search_anytech_col_three.innerHTML += resultados[k];	
												counter = 0;
											}
										}
										
										ReaplicarScript();
										
										anytech_articles.style.display = 'none';
										anytech_result_search.style.display = 'inline-block';
									}
									
									
									anytech_feed_input_search.onkeyup = function()
									{	
										mensagem = anytech_feed_input_search.value;			
										$.ajax({
												url:'../php/PesquisaSugestao.php',
												type:'POST',
												data:{
														Mensagem:mensagem},
												success:function(retorno){
													//itensSugestao = retorno.split(';');	
													anytech_suggestion.innerHTML = "";
													anytech_suggestion.innerHTML = retorno;
												}
											})
									}
									
								</script>
							</div>
						</td>
					</tr>
				</table>
				
				<div id="anytech_result_search">
					<div class="anytech-col-one" id="search_anytech_col_one">
					</div>
					
					<div class="anytech-col-two" id="search_anytech_col_two">
					</div>
					
					<div class="anytech-col-three" id="search_anytech_col_three">
					</div>
				</div>
				
				<div id="anytech_articles">
					<div class="anytech-col-one" id="anytech_col_one">
						<?php
							$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
																			   tb_artigo.nm_titulo,
																			   tb_artigo.ds_artigo,
																			   tb_artigo.dt_criacao,
																			   tb_artigo.ds_texto,
																			   tb_artigo.ds_url,
																			   tb_artigo.im_artigo,
																			   (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario,
																			   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
																			   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
																			   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
																			   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
																			   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar,
																			   (select group_concat(tb_tema.nm_tema) from tb_artigo as tb_artigo_tags inner join artigo_tema_tag on tb_artigo_tags.cd_artigo = artigo_tema_tag.cd_artigo inner join tb_tema on artigo_tema_tag.cd_tema = tb_tema.cd_tema where tb_artigo_tags.cd_artigo = tb_artigo.cd_artigo) as ds_tags
																		  from tb_artigo
																			where tb_artigo.dt_criacao <= '$timeAtual'
																				order by qt_visita desc , qt_comentario desc, qt_favorito desc, qt_leitura desc limit $deslocamento,$limite");
							$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
							$total_Artigos = mysqli_num_rows($result_Artigos);
							
							if ($total_Artigos > 0)
							{
								do
								{
									$tags = $linha_Artigos['ds_tags'];
									$tags = explode(',', $tags);
									
									$aux = $tags;
									$tags = '';
									
									for ($i = 0; $i <= count($aux) - 1; $i = $i + 1)
									{
										if ($i == count($aux) - 1)
										{
											$tags = $tags.$aux[$i];
										}
										else
										{
											$tags = $tags.$aux[$i].', ';
										}
									}
						?>
									<div class="anytech-post-box">
										<div class="img-outer">
											<img src="<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_artigo'] == '') {echo 'images/feed/12.jpg';} else {echo $linha_Artigos['im_artigo'];} ?>" class="anytech-post-image">
										</div>
										<a href="<?php echo VOLTAR; ?>artigo/<?php echo $linha_Artigos['ds_url']; ?>" target="_blank" class="anytech-post-title"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></a>
										<a class="anytech-post-author">por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></a>
										<a class="anytech-post-desc"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></a>
										<a class="anytech-post-tags"><b>Tags: </b><?php echo $tags; ?></a>	
										
										<div class="anytech-post-buttons"  align="center">
											<table class="data-buttons-table" align="center" cellspacing="3">
												<tr>
													<td>
														<input type="text" class="anytech-post-rating value-btn-rating value-btn" id="col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>" value="10" disabled>
													</td>
													<td>
														<input type="text" class="anytech-post-comment value-btn-comment value-btn" id="col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_comentario']; ?>" disabled>
													</td>
													<td>
														<input type="text" class="anytech-post-share value-btn-share value-btn" id="col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_compartilhar']; ?>" disabled>
													</td>
													<td>
														<input type="text" class="anytech-post-favorite value-btn-favorite value-btn" id="col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_favorito']; ?>" disabled>
													</td>
													<td>
														<input type="text" class="anytech-post-time value-btn-time value-btn" id="col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_leitura']; ?>" disabled>
													</td>
												</tr>
											</table>
											<input type="image" id="col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox()">
											<input type="image" id="col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png">
											<input type="image" id="col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
											<input type="image" id="col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png">
											<input type="image" id="col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png">
											
											<script>
												col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
												{
													var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
													
													Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox();}");
												}
												
												col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
												{
													var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
													
													Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox();}");
												}
												
												col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
												{
													EsconderValores();
													
													col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
												}
												
												col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
												{
													col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
												}
												
												col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
												{
													EsconderValores();
													
													var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
													
													//Tirei isso aqui de dentro da função abaixo
													col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
													
													Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno; ");
												}
												
												col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
												{
													col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
												}
												
												col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
												{
													var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
													
													EsconderValores();
													
													col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
													
													Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
												}
												
												col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
												{
													col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
												}
												
												col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
												{
													EsconderValores();
													
													var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;

													col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
													
													Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
												}
												
												col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
												{
													col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
												}
												
												col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
												{
													EsconderValores();
													
													var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
													
													col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
													
													Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
												}
												
												col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
												{
													col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
												}
											</script>
										</div>
									</div>
						<?php
								}
								while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
							}
						?>
					</div>
					
					<div class="anytech-col-two" id="anytech_col_two">
						<?php
							$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
																			   tb_artigo.nm_titulo,
																			   tb_artigo.ds_artigo,
																			   tb_artigo.dt_criacao,
																			   tb_artigo.ds_texto,
																			   tb_artigo.ds_url,
																			   tb_artigo.im_artigo,
																			   (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario,
																			   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
																			   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
																			   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
																			   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
																			   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar,
																			   (select group_concat(tb_tema.nm_tema) from tb_artigo as tb_artigo_tags inner join artigo_tema_tag on tb_artigo_tags.cd_artigo = artigo_tema_tag.cd_artigo inner join tb_tema on artigo_tema_tag.cd_tema = tb_tema.cd_tema where tb_artigo_tags.cd_artigo = tb_artigo.cd_artigo) as ds_tags
																		  from tb_artigo
																			where tb_artigo.dt_criacao <= '$timeAtual'
																				order by tb_artigo.dt_criacao desc limit $deslocamento,$limite");
							$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
							$total_Artigos = mysqli_num_rows($result_Artigos);
							
							if ($deslocamento%2 != 0)
							{
								$cont = 1;
							}
							else
							{
								$cont = 0;
							}
							
							if ($total_Artigos > 0)
							{
								do
								{
									$tags = $linha_Artigos['ds_tags'];
									$tags = explode(',', $tags);
									
									$aux = $tags;
									$tags = '';
									
									for ($i = 0; $i <= count($aux) - 1; $i = $i + 1)
									{
										if ($i == count($aux) - 1)
										{
											$tags = $tags.$aux[$i];
										}
										else
										{
											$tags = $tags.$aux[$i].', ';
										}
									}
									
									$cont = $cont + 1;
									
									if ($logado == 1)
									{
						?>
										<div class="anytech-post-box-mini">
											<div class="img-outer">
												<img src="<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_artigo'] == '') {echo 'images/feed/12.jpg';} else {echo $linha_Artigos['im_artigo'];} ?>" class="anytech-post-image">
											</div>
											<a href="<?php echo VOLTAR; ?>artigo/<?php echo $linha_Artigos['ds_url']; ?>" target="_blank" class="anytech-post-title-mini"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></a>
											<a class="anytech-post-author-mini">por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></a>
											<a class="anytech-post-desc-mini"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></a>
											<a class="anytech-post-tags-mini"><b>Tags: </b><?php echo $tags; ?></a>	
											
											<div class="anytech-post-buttons"  align="center">
												<table class="data-buttons-table" align="center" cellspacing="3">
													<tr>
														<td>
															<input type="text" class="anytech-post-rating value-btn-rating value-btn" id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>" value="10" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-comment value-btn-comment value-btn" id="col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_comentario']; ?>" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-share value-btn-share value-btn" id="col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_compartilhar']; ?>" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-favorite value-btn-favorite value-btn" id="col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_favorito']; ?>" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-time value-btn-time value-btn" id="col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_leitura']; ?>" disabled>
														</td>
													</tr>
												</table>
												<input type="image" id="col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox()">
												<input type="image" id="col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png">
												<input type="image" id="col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
												<input type="image" id="col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png">
												<input type="image" id="col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png">
												
												<script>
													col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
													{
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox();}");
													}
													
													col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
													{
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox();}");
													}
													
													col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
													{
														EsconderValores();
														
														col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
													}
													
													col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
													{
														col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
													}
													
													col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
													{
														EsconderValores();
														
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
													}
													
													col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
													{
														col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
													}
													
													col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
													{
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														EsconderValores();
														
														col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
													}
													
													col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
													{
														col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
													}
													
													col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
													{
														EsconderValores();
														
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
													}
													
													col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
													{
														col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
													}
													
													col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
													{
														EsconderValores();
														
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
													}
													
													col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
													{
														col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
													}
												</script>
											</div>
										</div>
						<?php
									}
									else
									{
										if ($cont%2 != 0)
										{
						?>
											<div class="anytech-post-box-mini">
												<div class="img-outer">
													<img src="<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_artigo'] == '') {echo 'images/feed/12.jpg';} else {echo $linha_Artigos['im_artigo'];} ?>" class="anytech-post-image">
												</div>
												<a href="<?php echo VOLTAR; ?>artigo/<?php echo $linha_Artigos['ds_url']; ?>" target="_blank" class="anytech-post-title-mini"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></a>
												<a class="anytech-post-author-mini">por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></a>
												<a class="anytech-post-desc-mini"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></a>
												<a class="anytech-post-tags-mini"><b>Tags: </b><?php echo $tags; ?></a>	
												
												<div class="anytech-post-buttons"  align="center">
													<table class="data-buttons-table" align="center" cellspacing="3">
														<tr>
															<td>
																<input type="text" class="anytech-post-rating value-btn-rating value-btn" id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>" value="10" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-comment value-btn-comment value-btn" id="col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_comentario']; ?>" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-share value-btn-share value-btn" id="col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_compartilhar']; ?>" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-favorite value-btn-favorite value-btn" id="col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_favorito']; ?>" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-time value-btn-time value-btn" id="col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_leitura']; ?>" disabled>
															</td>
														</tr>
													</table>
													<input type="image" id="col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox()">
													<input type="image" id="col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png">
													<input type="image" id="col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
													<input type="image" id="col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png">
													<input type="image" id="col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png">
													
													<script>
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox();}");
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox();}");
														}
														
														col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															EsconderValores();
															
															col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
													</script>
												</div>
											</div>
						<?php
										}
									}
								}
								while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
							}
						?>
					</div>
					
					<div class="anytech-col-three" id="anytech_col_three">
						<?php
							if ($logado == 1)
							{
								$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
																				   tb_artigo.nm_titulo,
																				   tb_artigo.ds_artigo,
																				   tb_artigo.dt_criacao,
																				   tb_artigo.ds_texto,
																				   tb_artigo.ds_url,
																				   tb_artigo.im_artigo,
																				   usuario_artigo_compartilhar.ds_sobre,
																				   (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario,
																				   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
																				   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
																				   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
																				   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
																				   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar,
																				   (select group_concat(tb_tema.nm_tema) from tb_artigo as tb_artigo_tags inner join artigo_tema_tag on tb_artigo_tags.cd_artigo = artigo_tema_tag.cd_artigo inner join tb_tema on artigo_tema_tag.cd_tema = tb_tema.cd_tema where tb_artigo_tags.cd_artigo = tb_artigo.cd_artigo) as ds_tags,
																					(select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = usuario_artigo_compartilhar.cd_usuario) as nm_seguidor,
																	usuario_artigo_compartilhar.dt_compartilhar
																			  from tb_usuario as tb_usuario_seguidor inner join tb_seguidor
																				on tb_usuario_seguidor.cd_usuario = tb_seguidor.cd_seguidor
																				  inner join tb_usuario
																					on tb_seguidor.cd_usuario = tb_usuario.cd_usuario
																					  inner join usuario_artigo_compartilhar
																						on tb_usuario.cd_usuario = usuario_artigo_compartilhar.cd_usuario
																						  inner join tb_artigo
																							on usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo
																							  where tb_usuario_seguidor.cd_usuario = '$codigoUsuario' and dt_compartilhar <= '$timeAtual'
																					order by dt_compartilhar limit $deslocamento,$limite;");
							}
							else
							{
								$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
																				   tb_artigo.nm_titulo,
																				   tb_artigo.ds_artigo,
																				   tb_artigo.dt_criacao,
																				   tb_artigo.ds_texto,
																				   tb_artigo.ds_url,
																				   tb_artigo.im_artigo,
																				   (select tb_usuario.nm_usuario_completo from tb_usuario where tb_usuario.cd_usuario = tb_artigo.cd_usuario) as nm_usuario,
																				   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo) as qt_visita,
																				   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo) as qt_comentario,
																				   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo) as qt_favorito,
																				   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo) as qt_leitura,
																				   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo) as qt_compartilhar,
																				   (select group_concat(tb_tema.nm_tema) from tb_artigo as tb_artigo_tags inner join artigo_tema_tag on tb_artigo_tags.cd_artigo = artigo_tema_tag.cd_artigo inner join tb_tema on artigo_tema_tag.cd_tema = tb_tema.cd_tema where tb_artigo_tags.cd_artigo = tb_artigo.cd_artigo) as ds_tags
																			  from tb_artigo
																				where tb_artigo.dt_criacao <= '$timeAtual'
																					order by tb_artigo.dt_criacao desc limit $deslocamento,$limite");
							}
							
							$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
							$total_Artigos = mysqli_num_rows($result_Artigos);
							
							if ($deslocamento%2 != 0)
							{
								$cont = 1;
							}
							else
							{
								$cont = 0;
							}
							
							if ($total_Artigos > 0)
							{
								do
								{
									$tags = $linha_Artigos['ds_tags'];
									$tags = explode(',', $tags);
									
									$aux = $tags;
									$tags = '';
									
									for ($i = 0; $i <= count($aux) - 1; $i = $i + 1)
									{
										if ($i == count($aux) - 1)
										{
											$tags = $tags.$aux[$i];
										}
										else
										{
											$tags = $tags.$aux[$i].', ';
										}
									}
									
									$cont = $cont + 1;
									
									if ($logado == 1)
									{
						?>	
										<div class="anytech-post-box">
											<div class="img-outer">
												<img src="<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_artigo'] == '') {echo 'images/feed/12.jpg';} else {echo $linha_Artigos['im_artigo'];} ?>" class="anytech-post-image">
											</div>
											<a href="<?php echo VOLTAR; ?>artigo/<?php echo $linha_Artigos['ds_url']; ?>" target="_blank" class="anytech-post-title"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></a>
											<a class="anytech-post-author">por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></a>
											<a class="anytech-post-desc"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></a>
											<a class="anytech-post-tags"><b>Tags: </b><?php echo $tags; ?></a>	
											
											<div class="anytech-post-buttons"  align="center">
												<table class="data-buttons-table" align="center" cellspacing="3">
													<tr>
														<td>
															<input type="text" class="anytech-post-rating value-btn-rating value-btn" id="col_three_value_btn_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="10" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-comment value-btn-comment value-btn" id="col_three_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_comentario']; ?>" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-share value-btn-share value-btn" id="col_three_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_compartilhar']; ?>" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-favorite value-btn-favorite value-btn" id="col_three_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_favorito']; ?>" disabled>
														</td>
														<td>
															<input type="text" class="anytech-post-time value-btn-time value-btn" id="col_three_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" value="<?php echo $linha_Artigos['qt_leitura']; ?>" disabled>
														</td>
													</tr>
												</table>
												<input type="image" id="col_three_anytech_post_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox()">
												<input type="image" id="col_three_anytech_post_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png">
												<input type="image" id="col_three_anytech_post_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
												<input type="image" id="col_three_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png">
												<input type="image" id="col_three_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>" class="anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png">
												
												<script>
													col_three_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onclick = function()
													{
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox();}");
													}
													
													col_three_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onclick = function()
													{
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox();}");
													}
													
													col_three_anytech_post_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
													{
														EsconderValores();
														
														col_three_value_btn_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
													}
													
													col_three_anytech_post_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
													{
														col_three_value_btn_rating<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
													}
													
													col_three_anytech_post_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
													{
														EsconderValores();
														
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														//Tirei isso aqui de dentro da função abaixo
														col_three_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_three_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno; ");
													}
													
													col_three_anytech_post_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
													{
														col_three_value_btn_comment<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
													}
													
													col_three_anytech_post_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
													{
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														EsconderValores();
														
														col_three_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_three_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno;");
													}
													
													col_three_anytech_post_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
													{
														col_three_value_btn_share<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
													}
													
													col_three_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
													{
														EsconderValores();
														
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;

														col_three_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_three_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno;");
													}
													
													col_three_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
													{
														col_three_value_btn_favorite<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
													}
													
													col_three_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseover = function()
													{
														EsconderValores();
														
														var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
														
														col_three_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'inline-block';
														
														Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_three_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.value = retorno;");
													}
													
													col_three_anytech_post_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.onmouseout = function()
													{
														col_three_value_btn_time<?php echo $linha_Artigos['cd_artigo'].$cont; ?>.style.display = 'none';
													}
												</script>
											</div>
											<label class="post-share-status" style="background-color:#2dc100"><?php echo $linha_Artigos['ds_sobre']; ?></br></br><b>Compartilhado em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_compartilhar'])); ?> ás <?php echo date('H:i', strtotime($linha_Artigos['dt_compartilhar'])); ?> por <?php echo $linha_Artigos['nm_seguidor']; ?></b></label>
										</div>
										<span></span>
						<?php
									}
									else
									{
										if ($cont%2 == 0)
										{
						?>
											<div class="anytech-post-box-mini">
												<div class="img-outer">
													<img src="<?php echo VOLTAR; ?><?php if ($linha_Artigos['im_artigo'] == '') {echo 'images/feed/12.jpg';} else {echo $linha_Artigos['im_artigo'];} ?>" class="anytech-post-image">
												</div>
												<a href="<?php echo VOLTAR; ?>artigo/<?php echo $linha_Artigos['ds_url']; ?>" target="_blank" class="anytech-post-title-mini"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></a>
												<a class="anytech-post-author-mini">por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?> em <?php echo date('d/m/Y', strtotime($linha_Artigos['dt_criacao'])); ?> às <?php echo date('H:i', strtotime($linha_Artigos['dt_criacao'])); ?></a>
												<a class="anytech-post-desc-mini"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></a>
												<a class="anytech-post-tags-mini"><b>Tags: </b><?php echo $tags; ?></a>	
												
												<div class="anytech-post-buttons"  align="center">
													<table class="data-buttons-table" align="center" cellspacing="3">
														<tr>
															<td>
																<input type="text" class="anytech-post-rating value-btn-rating value-btn" id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>" value="10" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-comment value-btn-comment value-btn" id="col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_comentario']; ?>" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-share value-btn-share value-btn" id="col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_compartilhar']; ?>" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-favorite value-btn-favorite value-btn" id="col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_favorito']; ?>" disabled>
															</td>
															<td>
																<input type="text" class="anytech-post-time value-btn-time value-btn" id="col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>" value="<?php echo $linha_Artigos['qt_leitura']; ?>" disabled>
															</td>
														</tr>
													</table>
													<input type="image" id="col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox()">
													<input type="image" id="col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png">
													<input type="image" id="col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
													<input type="image" id="col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png">
													<input type="image" id="col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png">
													
													<script>
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox();}");
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox();}");
														}
														
														col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															EsconderValores();
															
															col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.value = retorno;");
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
														}
													</script>
												</div>
											</div>
						<?php
										}
									}
								}
								while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
							}
						?>
					</div>
					<center><input type="button" id="btn_verMais" value="Ver mais artigos" onclick="MaisArtigos();" style="height: 50px;"><img src="<?php echo VOLTAR; ?>images/loader.gif" id="im_loaderVerMais" style="width: 50px; height: 50px; display: none;"></center>
					<br/>
				</div>
			</div>
		</div>
	</body>
	
	<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>
	<script src="<?php echo VOLTAR; ?>js/Ajax.js"></script>

	<script>
		var deslocamento = '<?php echo $deslocamento; ?>';

		function ReaplicarScript()
		{
			var cont = 0;
			
			aux = anytech_col_one.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			aux = anytech_col_two.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			aux = anytech_col_three.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			aux = search_anytech_col_one.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			aux = search_anytech_col_two.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			aux = search_anytech_col_three.getElementsByTagName('script');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				eval(aux[cont].innerHTML);
			}
			
			return true;
		}
		
		function MaisArtigos()
		{
			var limite = '<?php echo $limite; ?>';
			var timeAtual = '<?php echo $timeAtual; ?>';
			
			btn_verMais.style.display = 'none';
			im_loaderVerMais.style.display = 'inline-block';
		
			Ajax("GET", "<?php echo VOLTAR; ?>php/MaisArtigos.php", "limite=" + limite + "&deslocamento=" + deslocamento + "&timeAtual=" + timeAtual, "im_loaderVerMais.style.display = 'none'; btn_verMais.style.display = 'inline-block'; var retorno = this.responseText; var artigos = retorno.split('<!--Coluna01--\>')[1]; if (artigos != undefined) {anytech_col_one.innerHTML = anytech_col_one.innerHTML + artigos;} var artigos = retorno.split('<!--Coluna02--\>')[1]; if (artigos != undefined) {anytech_col_two.innerHTML = anytech_col_two.innerHTML + artigos;} var artigos = retorno.split('<!--Coluna03--\>')[1]; if (artigos != undefined) {anytech_col_three.innerHTML = anytech_col_three.innerHTML + artigos;} deslocamento = retorno.split('<!--Deslocamento--\>')[1]; ReaplicarScript();");
		}
		
		function EsconderValores()
		{
			var aux = document.getElementsByClassName('value-btn');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				aux[cont].style.display = 'none';
			}
		}
		
		function showFavoriteBox()
		{
			$('#box_favorite_cover').fadeIn();
			setTimeout('hideFavoriteBox();',2000);
		}
		
		function hideFavoriteBox()
		{
			$('#box_favorite_cover').fadeOut();
		}
		
		function showReadBox()
		{
			$('#box_read_cover').fadeIn();
			setTimeout('hideReadBox();',2000);
		}
		
		function hideReadBox()
		{
			$('#box_read_cover').fadeOut();
		}
		
		function showRatingBox()
		{
			$('.maincover').fadeIn();
			$('#box_rating_cover').toggle('slide');
		}
		
		function hideRatingBox()
		{
			$('#box_rating_cover').toggle('slide');
			$('.maincover').fadeOut();
		}
		
		function showShareBox(codigo, titulo, autor, link)
		{
			lbl_share_title.textContent = titulo;
			lbl_share_author.textContent = autor;
			txt_share_link.value = link;
			txt_share_code.value = codigo;
			
			$('.maincover').fadeIn();
			$('#box_share_cover').toggle('slide');
		}
		
		function hideShareBox()
		{
			$('#box_share_cover').toggle('slide');
			$('.maincover').fadeOut();
		}
		
		anytech_feed_input_search.onfocus = function()
		{
			$('.anytech-suggestion').fadeIn();
		}
		
		anytech_feed_input_search.onblur = function()
		{
			
			$('.anytech-suggestion').fadeOut();
		}
		
	</script>
</html>