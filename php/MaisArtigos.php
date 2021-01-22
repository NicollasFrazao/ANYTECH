<?php
	define('VOLTAR', '../');
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_GET['limite']) || !isset($_GET['deslocamento']) || !isset($_GET['timeAtual']))
	{
		exit;
	}
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;
	}
	else
	{
		$logado = 1;
	}
	
	$limite = mysql_escape_string($_GET['limite']);
	$deslocamento = mysql_escape_string($_GET['deslocamento']);
	$timeAtual = mysql_escape_string($_GET['timeAtual']);
	
	$deslocamento = $deslocamento + $limite;
?>

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
														order by qt_visita desc , qt_comentario desc, qt_favorito desc, qt_leitura limit $deslocamento,$limite");
	$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
	$total_Artigos = mysqli_num_rows($result_Artigos);
	
	echo '<!--Deslocamento-->'.$deslocamento.'<!--Deslocamento-->';
	
	if ($total_Artigos > 0)
	{
		echo '<!--Coluna01-->';
		
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
		
		echo '<!--Coluna01-->';
	}
?>

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
		echo '<!--Coluna02-->';
		
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
		
		echo '<!--Coluna02-->';
	}
?>

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
		echo '<!--Coluna03-->';
		
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
		
		echo '<!--Coluna03-->';
	}
?>