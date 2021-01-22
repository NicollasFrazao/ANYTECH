<?php
	if (!isset($logado))
	{
		exit;
	}
	
	if (!isset($_GET['view']))
	{
		$limite = 5;
		$view = '';
	}
	else
	{
		$view = mysql_escape_string($_GET['view']);
	}
	
	$deslocamento = 0;
	$timeAtual = date('Y/m/d H:i:s');
	
	function FormatarTags($tagsBanco)
	{
		global $tags;
		
		$tags = $tagsBanco;
		$tags = explode(',', $tags);
		
		$aux = $tags;
		$tags = '';
		
		for ($cont = 0; $cont <= count($aux) - 1; $cont = $cont + 1)
		{
			if ($cont == count($aux))
			{
				$tags = $tags.$aux[$cont];
			}
			else
			{
				$tags = $tags.$aux[$cont].', ';
			}
		}
	}
	
	if (!isset($_GET['categoria']) || $_GET['categoria'] == '')
	{
		$query_ArtigosRecentes = "select tb_artigo.cd_artigo,
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
									from tb_artigo
										where tb_artigo.ic_artigo_pendente = 0 and tb_artigo.dt_criacao <= '$timeAtual'
											order by tb_artigo.dt_criacao desc".((isset($limite)) ? " limit $deslocamento,$limite" : '');
		
		/*$query_ArtigosDestaquesSemana = "select tb_artigo.cd_artigo,
											   tb_artigo.nm_titulo,
											   tb_artigo.ds_artigo,
											   tb_artigo.dt_criacao,
											   year(tb_artigo.dt_criacao) as aa_criacao,
											   (select week(tb_visita.dt_visita) from tb_artigo as tb_artigo_visita inner join tb_visita  on tb_artigo_visita.cd_artigo = tb_visita.cd_artigo where tb_visita.cd_artigo = tb_artigo.cd_artigo order by tb_visita.dt_visita desc limit 1) as ss_criacao,
											   tb_artigo.ds_texto,
											   tb_artigo.ds_url,
											   tb_artigo.im_artigo,
											   tb_artigo.im_thumbnail,
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
										  from tb_artigo
											where tb_artigo.dt_criacao <= '$timeAtual'
											  order by ds_techrank desc, tb_artigo.dt_criacao desc limit $deslocamento,".((isset($limite)) ? $limite : 5);*/

		$query_ArtigosLidosSemana = "select tb_artigo.cd_artigo,
										   tb_artigo.nm_titulo,
										   tb_artigo.ds_artigo,
										   tb_artigo.dt_criacao,
										   tb_artigo.ic_autor_oculto,
										   year(tb_artigo.dt_criacao) as aa_criacao,
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
									  from tb_artigo
											where tb_artigo.ic_artigo_pendente = 0 and tb_artigo.dt_criacao <= '$timeAtual'
											  order by qt_visita_rank desc, tb_artigo.dt_criacao desc".((isset($limite)) ? " limit $deslocamento,$limite" : '');
	}
	else
	{
		$categoria = mysql_escape_string($_GET['categoria']);
		
		$result_Tema = $conexaoPrincipal -> Query("select nm_tema from tb_tema where cd_tema = '$categoria'");
		$linha_Tema = mysqli_fetch_assoc($result_Tema);
		
		$nomeCategoria = $linha_Tema['nm_tema'];
		
		$query_ArtigosRecentes = "select tb_artigo.cd_artigo,
										   tb_artigo.nm_titulo,
										   tb_artigo.ds_artigo,
										   tb_artigo.dt_criacao,
										   tb_artigo.ic_autor_oculto,
										   year(tb_artigo.dt_criacao) as aa_criacao,
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
										   (select count(tb_visita.cd_visita) from tb_visita where tb_artigo.ic_artigo_pendente = 0 and tb_visita.cd_artigo = tb_artigo.cd_artigo and year(tb_visita.dt_visita) = year(now()) and week(tb_visita.dt_visita) = week(now())) as qt_visita_rank,
										   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo  and year(tb_comentario_artigo.dt_comentario_artigo) = year(now()) and week(tb_comentario_artigo.dt_comentario_artigo) = week(now())) as qt_comentario_rank,
										   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_favorito.dt_favorito) = year(now()) and week(usuario_artigo_favorito.dt_favorito) = week(now())) as qt_favorito_rank,
										   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_leitura.dt_leitura) = year(now()) and week(usuario_artigo_leitura.dt_leitura) = week(now())) as qt_leitura_rank,
										   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_compartilhar.dt_compartilhar) = year(now()) and week(usuario_artigo_compartilhar.dt_compartilhar) = week(now())) as qt_compartilhar_rank,
										   (select (qt_favorito_rank*13) + (qt_compartilhar_rank*8) + (qt_comentario_rank*3) + (qt_leitura_rank*2) + qt_visita_rank) as ds_techrank
									from tb_artigo inner join artigo_tema_tag
										on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
										  inner join tb_tema
											on artigo_tema_tag.cd_tema = tb_tema.cd_tema
										where tb_artigo.dt_criacao <= '$timeAtual' and tb_tema.cd_tema = '$categoria'
											order by tb_artigo.dt_criacao desc".((isset($limite)) ? " limit $deslocamento,$limite" : '');
		
		/*$query_ArtigosDestaquesSemana = "select tb_artigo.cd_artigo,
												   tb_artigo.nm_titulo,
												   tb_artigo.ds_artigo,
												   tb_artigo.dt_criacao,
												   year(tb_artigo.dt_criacao) as aa_criacao,
												   (select week(tb_visita.dt_visita) from tb_artigo as tb_artigo_visita inner join tb_visita  on tb_artigo_visita.cd_artigo = tb_visita.cd_artigo where tb_visita.cd_artigo = tb_artigo.cd_artigo order by tb_visita.dt_visita desc limit 1) as ss_criacao,
												   tb_artigo.ds_texto,
												   tb_artigo.ds_url,
												   tb_artigo.im_artigo,
												   tb_artigo.im_thumbnail,
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
										  from tb_artigo inner join artigo_tema_tag
												on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
												  inner join tb_tema
													on artigo_tema_tag.cd_tema = tb_tema.cd_tema
											where tb_artigo.dt_criacao <= '$timeAtual' and tb_tema.cd_tema = '$categoria'
											  order by ds_techrank desc, tb_artigo.dt_criacao desc limit $deslocamento,".((isset($limite)) ? $limite : 5);*/

		$query_ArtigosLidosSemana = "select tb_artigo.cd_artigo,
											   tb_artigo.nm_titulo,
											   tb_artigo.ds_artigo,
											   tb_artigo.dt_criacao,
											   tb_artigo.ic_autor_oculto,
											   year(tb_artigo.dt_criacao) as aa_criacao,
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
										  from tb_artigo inner join artigo_tema_tag
												on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
												  inner join tb_tema
													on artigo_tema_tag.cd_tema = tb_tema.cd_tema
											where tb_artigo.ic_artigo_pendente = 0 and tb_artigo.dt_criacao <= '$timeAtual' and tb_tema.cd_tema = '$categoria'
											  order by qt_visita_rank desc, tb_artigo.dt_criacao desc".((isset($limite)) ? " limit $deslocamento,$limite" : '');
	}
	
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
	<head>
		<?php
			include VOLTAR.'php/CoresGoogle.php';
		?>
		
		<meta charset="utf-8">
		<meta name="google-site-verification" content="LHwdJcSUU1ZulIu-GK3tqGfkliNNViDbzvZWIB6ZwUo" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ANYTECH - <?php echo ((isset($nomeCategoria)) ? 'Categoria '.$nomeCategoria : 'Newsletter'); ?></title>
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png" alt="ANYTECH"/>
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed-media-query-sizeone.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed-media-query-sizetwo.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-feed-media-query-sizethree.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-article.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-banners.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-footer.css">
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/searchmenu.css">
		
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
				
		<style>
			input.anytech-post-button
			{
				display: inline-block;
				width: 22px;
				margin-right: 5px;
				border-radius: 50%;
				padding: 0.5%;
				height: auto;
				margin-top: 0px;
				font-size: 0.7em;
				vertical-align: middle;
				box-shadow: 0px 2px 4px #ddd;
				transition: box-shadow 1s;
			}
			
			input.anytech-post-button + label
			{
				vertical-align: middle;
			}
			
			.at-bloco-artigo-titulo
			{
				padding-top: 0px;
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
			
			#st1, #st2, #st3, #st4, #st5
			{
				transition: color 2s;
			}
		</style>
	</head>
	<body style="padding:0px; margin:0px;font-family:Arial, sans-serif; background-color: #f2f2f2;">

		<!-- #region Jssor Slider Begin -->

		<!-- Generated by Jssor Slider Maker Online. -->
		<!-- This demo works without jquery library. -->

		<script type="text/javascript" src="<?php echo VOLTAR; ?>js/jssor.slider.min.js"></script>
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
				background: url('<?php echo VOLTAR; ?>images/slider/a22.png') center center no-repeat;
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
			
			html
			{
				height: auto;
				background-color: #fff;
			}	

			body
			{
				height: auto;
				background-color: #fff;
				overflow-x: hidden;
			}				
		</style>
		<!--
		.at-body-art
			{
				display: inline-block;
				position: relative;
				width: 1024px;
				margin-left: -512px;
				left: 50%;
				background-color: #e7e7e7;
				border-left: 0.5px solid #f2f2f2;
				border-right: 0.5px solid #f2f2f2;
			}-->
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
					<div class="info-share mhand">
						<a id="at_shr_art" class="mhand" href="" target="_blank" style="height: 10px; text-align: left; color: black;">
						<b><label class="cover-label mhand" id="lbl_share_title"></label></b>
						<label class="cover-author mhand" id="lbl_share_author"></label>
						</a>
					</div>
					<input type="submit" class="mhand" id="btn_compartilhar" style="display: none;"/>
				</form>
			</div>
			
			<div class="anytech-option-post-cover-bottom">
				<?php if($logado != 0){?><input type="button" value="Compartilhar" class="cover-button mhand" id="cover_share_ok"/><?php }?>

				<script>
					cover_share_ok.onclick = function()
					{
						setShares();
					}
					
					function setShares()
					{
						if (txt_sobre_share_s.value != "" && <?php echo $logado; ?> == 1)
						{
							cover_share_ok.disabled = true;
							
							msgShare = txt_sobre_share_s.value;
							cdartShare = txt_share_code.value;
							
							Ajax("GET", "<?php echo VOLTAR; ?>php/CompartilharArtigo.php", "sobreCompartilhar=" + msgShare + "&codigoArtigo=" + cdartShare, "var retorno = this.responseText; if (retorno == 1) {botaoCompartilhar.onmouseover(); alert('Artigo compartilhado com sucesso!'); hideShareBox(); txt_sobre_share_s.value = '';} else {alert('Não foi possível compartilhar o artigo!');} cover_share_ok.disabled = false;"); 
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
				<div class="info-share mhand">
					<a id="at_com_art" class="mhand" href="" target="_blank" style="height: 10px; text-align: left; color: black;">
					<b><label class="cover-label mhand" id="lbl_comment_title"></label></b>
					<label class="cover-author mhand" id="lbl_comment_author"></label>
					</a>
				</div>
				<input type="hidden" name="codigoArtigo" id="txt_comment_code" value="" readonly/>			
				<input type="hidden" id="txt_comment_link" value="" readonly/>
				<textarea id="txt_sobre_comm" style="height: 60px;" name="sobreCompartilhar" class="cover-textarea" placeholder="<?php echo (($logado != 0) ? 'Escreva algo sobre este artigo...' : 'Efetue o login para comentar na ANYTECH!'); ?>" <?php echo (($logado == 0) ? 'disabled' : ''); ?>></textarea>
				<a id="commentATx" href="" target="_blank" style="border: 0px; margin-left: 2.5%; margin-right:2.5%; font-size: 0.9em; background-color: transparent;  text-decoration: none; background-color: #3B5998; color:#fff; padding:3px; padding-right: 10px; padding-left: 10px;">Comentar via Facebook</a>
			</div>
			<div class="anytech-option-post-cover-bottom">
				<?php if($logado != 0){?><input type="button" value="Comentar" class="cover-button mhand"  id="cover-comment-ok" onclick="setCommentBox()"><?php }?>						
				<input type="button" value="Cancelar" class="cover-button mhand"  id="cover-comment-cancel" onclick="hideCommentBox()">		
			</div>
		</div>
		<script>
			function setCommentBox()
			{
				if(txt_sobre_comm.value != "")
				{
					Ajax("POST", "<?php echo VOLTAR; ?>artigo/php/EnviarComentario.php", "codigoArtigo=" + txt_comment_code.value + "&comentarioArtigo=" + txt_sobre_comm.value, "");
				}
			}
		</script>

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
					<a id="at_ref_art" class="mhand" href="" target="_blank" style="height: 10px; text-align: left; color: black;">
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
					<td valign="center" align="center">
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
					<td valign="center" align="center">
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
			?>
		
		<div class="at-body-art">		
			<?php			
				if ($logado == 1)
				{
					
				}
				else
				{
									
			?>
					<!--<div class="search-itens" style="top: 0px;" id="atsearchbox">
						<div id="intosearchbox" style="overflow: auto;"></div>
					</div>-->
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
					<?php
						if (isset($codigoUsuario))
						{
							$result_Categorias = $conexaoPrincipal -> Query("select tb_tema.cd_tema
																		  from tb_usuario inner join usuario_tema_favorito
																			on tb_usuario.cd_usuario = usuario_tema_favorito.cd_usuario
																			  inner join tb_tema
																				on usuario_tema_favorito.cd_tema = tb_tema.cd_tema
																			where tb_usuario.cd_usuario = '$codigoUsuario'");
							$linha_Categorias = mysqli_fetch_assoc($result_Categorias);
							$total_Categorias = mysqli_num_rows($result_Categorias);
							
							if ($total_Categorias > 0)
							{
								$cont = 0;
								$categorias = '';
								
								do
								{
									$cont = $cont + 1;
									
									if ($cont == 1)
									{
										$categorias = "tb_tema.cd_tema = '".$linha_Categorias['cd_tema']."'";
									}
									else
									{
										$categorias = $categorias." or tb_tema.cd_tema = '".$linha_Categorias['cd_tema']."'";
									}
								}
								while ($linha_Categorias = mysqli_fetch_assoc($result_Categorias));
							}
							else
							{
								$aux = 0;
							}
						}
						else
						{
							$aux = 0;
						}
						
						//$result_Artigos = $conexaoPrincipal -> Query($query_ArtigosDestaquesSemana);
						
						$result_Categorias = $conexaoPrincipal -> Query("select tb_tema.cd_tema,
		   tb_tema.nm_tema,
		   count(artigo_tema_tag.cd_artigo) as qt_artigos,
		   (select sum(usuario_artigo_avaliar.qt_estrelas) / count(usuario_artigo_avaliar.cd_artigo) from usuario_artigo_avaliar where usuario_artigo_avaliar.cd_artigo = tb_artigo.cd_artigo) as qt_estrelas,
		   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo and year(tb_visita.dt_visita) = year(now()) and week(tb_visita.dt_visita) = week(now())) as qt_visita_rank,
		   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo  and year(tb_comentario_artigo.dt_comentario_artigo) = year(now()) and week(tb_comentario_artigo.dt_comentario_artigo) = week(now())) as qt_comentario_rank,
		   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_favorito.dt_favorito) = year(now()) and week(usuario_artigo_favorito.dt_favorito) = week(now())) as qt_favorito_rank,
		   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_leitura.dt_leitura) = year(now()) and week(usuario_artigo_leitura.dt_leitura) = week(now())) as qt_leitura_rank,
		   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_compartilhar.dt_compartilhar) = year(now()) and week(usuario_artigo_compartilhar.dt_compartilhar) = week(now())) as qt_compartilhar_rank,
		   (select (qt_favorito_rank*13) + (qt_compartilhar_rank*8) + (qt_comentario_rank*3) + (qt_leitura_rank*2) + qt_visita_rank) as ds_techrank
	  from tb_tema inner join artigo_tema_tag
		on tb_tema.cd_tema = artigo_tema_tag.cd_tema
		  inner join tb_artigo
			on artigo_tema_tag.cd_artigo = tb_artigo.cd_artigo
		".(($aux == 1) ? "where $categorias" : '')."
	  group by tb_tema.nm_tema order by ds_techrank desc, tb_tema.nm_tema asc limit 5");	
						$linha_Categorias = mysqli_fetch_assoc($result_Categorias);
						$total_Categorias = mysqli_num_rows($result_Categorias);
						//$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
						//$total_Artigos = mysqli_num_rows($result_Artigos);
						
						if ($total_Categorias > 0)
						{
							$cont = 0;
							$artigos = '';
							$restricao = '';
							
							do
							{
								$aux = $linha_Categorias['cd_tema'];
								
								$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
													   tb_artigo.nm_titulo,
													   tb_artigo.ds_artigo,
													   tb_artigo.dt_criacao,
													   tb_artigo.ic_autor_oculto,
													   year(tb_artigo.dt_criacao) as aa_criacao,
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
											  from tb_artigo inner join artigo_tema_tag
													on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
													  inner join tb_tema
														on artigo_tema_tag.cd_tema = tb_tema.cd_tema
												where tb_artigo.dt_criacao <= '$timeAtual' and tb_tema.cd_tema = '$aux'".(($restricao != '') ? " and ($restricao)" : '')."
												  order by ds_techrank desc, tb_artigo.dt_criacao desc limit 1");
								$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
								$total_Artigos = mysqli_num_rows($result_Artigos);

								if ($total_Artigos > 0)
								{
									$cont = $cont + 1;
									
									do
									{
										$aux = $linha_Artigos['cd_artigo'];
										
										if ($cont == 1)
										{
											$artigos = "tb_artigo.cd_artigo = '$aux'";
											$restricao = "tb_artigo.cd_artigo != '$aux'";
										}
										else
										{
											$artigos = $artigos." or tb_artigo.cd_artigo = '$aux'";
											$restricao = $restricao." and tb_artigo.cd_artigo != '$aux'";
										}
									}
									while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
								}
							}
							while ($linha_Categorias = mysqli_fetch_assoc($result_Categorias));
							
							$result_Artigos = $conexaoPrincipal -> Query("select distinct tb_artigo.cd_artigo,
													   tb_artigo.nm_titulo,
													   tb_artigo.ds_artigo,
													   tb_artigo.dt_criacao,
													   tb_artigo.ic_autor_oculto,
													   year(tb_artigo.dt_criacao) as aa_criacao,
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
											  from tb_artigo inner join artigo_tema_tag
													on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
													  inner join tb_tema
														on artigo_tema_tag.cd_tema = tb_tema.cd_tema
												where tb_artigo.dt_criacao <= '$timeAtual'".(($artigos != '') ? "and ($artigos) " : ' ')."
												  order by ds_techrank desc, tb_artigo.dt_criacao desc");
							$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
							$total_Artigos = mysqli_num_rows($result_Artigos);
							
							if ($total_Artigos > 0)
							{
								do
								{
					?>
									<div data-p="225.00" style="display: none;">
										<a style="display: inline;" href="<?php echo VOLTAR; ?>artigo/<?php echo urlencode($linha_Artigos['ds_url']); ?>" target="_blank" title="Ler artigo">
											<img class="at-imagem-artigo" style=""alt="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" src="<?php echo VOLTAR.(($linha_Artigos['im_thumbnail'] == '') ? 'images/feed/thumbnail.jpg' : $linha_Artigos['im_thumbnail']); ?>" />
											<h2 class="at-titulo-artigo" style="font-size: 100px; line-height: 100px; bottom: 600px; text-align: left; text-shadow: 2px 2px 20px rgba(0,0,0,1), -2px -2px 20px rgba(0,0,0,1);"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></h2>
										</a>
									</div>
					<?php
								}
								while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
							}
						}
					?>
				</div>
				<div data-u="navigator" class="jssorb05" style="bottom:0px;right:0px;" data-autocenter="1">          
					<div data-u="prototype" style="width:0px;height:0px;"></div>
				</div>
				<span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
				<span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
			 
			</div>
			<?php
				}
				else
				{
					
			?>
			<div id="jssor_1" style="position: relative; margin: 0 auto; left: 0px; width: 1300px; height:650px; overflow: hidden; visibility: hidden;">
			   
				<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
					<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
					<div style="position:absolute;display:block;background:url('<?php echo VOLTAR; ?>images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
				</div>
				<div data-u="slides" class="at-slider-artigo" style="display: inline-block; cursor: default; position: absolute; top: 0px; left: 0px; width: 1300px; height: 650px; overflow: hidden;">
					<?php
						if (isset($codigoUsuario))
						{
							$result_Categorias = $conexaoPrincipal -> Query("select tb_tema.cd_tema
																		  from tb_usuario inner join usuario_tema_favorito
																			on tb_usuario.cd_usuario = usuario_tema_favorito.cd_usuario
																			  inner join tb_tema
																				on usuario_tema_favorito.cd_tema = tb_tema.cd_tema
																			where tb_usuario.cd_usuario = '$codigoUsuario'");
							$linha_Categorias = mysqli_fetch_assoc($result_Categorias);
							$total_Categorias = mysqli_num_rows($result_Categorias);
							
							if ($total_Categorias > 0)
							{
								$cont = 0;
								$categorias = '';
								
								do
								{
									$cont = $cont + 1;
									
									if ($cont == 1)
									{
										$categorias = "tb_tema.cd_tema = '".$linha_Categorias['cd_tema']."'";
									}
									else
									{
										$categorias = $categorias." or tb_tema.cd_tema = '".$linha_Categorias['cd_tema']."'";
									}
								}
								while ($linha_Categorias = mysqli_fetch_assoc($result_Categorias));
							}
							else
							{
								$aux = 0;
							}
						}
						else
						{
							$aux = 0;
						}
						
						//$result_Artigos = $conexaoPrincipal -> Query($query_ArtigosDestaquesSemana);
						
						$result_Categorias = $conexaoPrincipal -> Query("select tb_tema.cd_tema,
		   tb_tema.nm_tema,
		   count(artigo_tema_tag.cd_artigo) as qt_artigos,
		   (select sum(usuario_artigo_avaliar.qt_estrelas) / count(usuario_artigo_avaliar.cd_artigo) from usuario_artigo_avaliar where usuario_artigo_avaliar.cd_artigo = tb_artigo.cd_artigo) as qt_estrelas,
		   (select count(tb_visita.cd_visita) from tb_visita where tb_visita.cd_artigo = tb_artigo.cd_artigo and year(tb_visita.dt_visita) = year(now()) and week(tb_visita.dt_visita) = week(now())) as qt_visita_rank,
		   (select count(tb_comentario_artigo.cd_comentario_artigo) from tb_comentario_artigo where tb_comentario_artigo.cd_artigo = tb_artigo.cd_artigo  and year(tb_comentario_artigo.dt_comentario_artigo) = year(now()) and week(tb_comentario_artigo.dt_comentario_artigo) = week(now())) as qt_comentario_rank,
		   (select count(usuario_artigo_favorito.cd_artigo) from usuario_artigo_favorito where usuario_artigo_favorito.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_favorito.dt_favorito) = year(now()) and week(usuario_artigo_favorito.dt_favorito) = week(now())) as qt_favorito_rank,
		   (select count(usuario_artigo_leitura.cd_artigo) from usuario_artigo_leitura where usuario_artigo_leitura.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_leitura.dt_leitura) = year(now()) and week(usuario_artigo_leitura.dt_leitura) = week(now())) as qt_leitura_rank,
		   (select count(usuario_artigo_compartilhar.cd_artigo) from usuario_artigo_compartilhar where usuario_artigo_compartilhar.cd_artigo = tb_artigo.cd_artigo and year(usuario_artigo_compartilhar.dt_compartilhar) = year(now()) and week(usuario_artigo_compartilhar.dt_compartilhar) = week(now())) as qt_compartilhar_rank,
		   (select (qt_favorito_rank*13) + (qt_compartilhar_rank*8) + (qt_comentario_rank*3) + (qt_leitura_rank*2) + qt_visita_rank) as ds_techrank
	  from tb_tema inner join artigo_tema_tag
		on tb_tema.cd_tema = artigo_tema_tag.cd_tema
		  inner join tb_artigo
			on artigo_tema_tag.cd_artigo = tb_artigo.cd_artigo
		".(($aux == 1) ? "where $categorias" : '')."
	  group by tb_tema.nm_tema order by ds_techrank desc, tb_tema.nm_tema asc limit 5");	
						$linha_Categorias = mysqli_fetch_assoc($result_Categorias);
						$total_Categorias = mysqli_num_rows($result_Categorias);
						//$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
						//$total_Artigos = mysqli_num_rows($result_Artigos);
						
						if ($total_Categorias > 0)
						{
							$cont = 0;
							$artigos = '';
							$restricao = '';
							
							do
							{
								$aux = $linha_Categorias['cd_tema'];
								
								$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
													   tb_artigo.nm_titulo,
													   tb_artigo.ds_artigo,
													   tb_artigo.dt_criacao,
													   tb_artigo.ic_autor_oculto,
													   year(tb_artigo.dt_criacao) as aa_criacao,
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
											  from tb_artigo inner join artigo_tema_tag
													on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
													  inner join tb_tema
														on artigo_tema_tag.cd_tema = tb_tema.cd_tema
												where tb_artigo.dt_criacao <= '$timeAtual' and tb_tema.cd_tema = '$aux'".(($restricao != '') ? " and ($restricao)" : '')."
												  order by ds_techrank desc, tb_artigo.dt_criacao desc limit 1");
								$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
								$total_Artigos = mysqli_num_rows($result_Artigos);

								if ($total_Artigos > 0)
								{
									$cont = $cont + 1;
									
									do
									{
										$aux = $linha_Artigos['cd_artigo'];
										
										if ($cont == 1)
										{
											$artigos = "tb_artigo.cd_artigo = '$aux'";
											$restricao = "tb_artigo.cd_artigo != '$aux'";
										}
										else
										{
											$artigos = $artigos." or tb_artigo.cd_artigo = '$aux'";
											$restricao = $restricao." and tb_artigo.cd_artigo != '$aux'";
										}
									}
									while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
								}
							}
							while ($linha_Categorias = mysqli_fetch_assoc($result_Categorias));
							
							$result_Artigos = $conexaoPrincipal -> Query("select tb_artigo.cd_artigo,
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
									from tb_artigo
										where tb_artigo.ic_artigo_pendente = 0 and tb_artigo.dt_criacao <= '$timeAtual'
											order by tb_artigo.dt_criacao desc limit 7");
							$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
							$total_Artigos = mysqli_num_rows($result_Artigos);
							
							if ($total_Artigos > 0)
							{
								do
								{
					?>
									<div data-p="225.00" style="display: none;">
										<a style="display: inline;" href="<?php echo VOLTAR; ?>artigo/<?php echo urlencode($linha_Artigos['ds_url']); ?>" target="_blank" title="Ler artigo">
											<img class="at-imagem-artigo" alt="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagemArtigo)) {$tr = str_replace('artigo/imagens/','',$imagemArtigo); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" src="<?php echo VOLTAR.(($linha_Artigos['im_artigo'] == '') ? 'images/feed/12.jpg' : $linha_Artigos['im_artigo']); ?>" />
											<div style="display: inline-block; background-image: linear-gradient(to top, rgba(0,0,0,0.2), rgba(0,0,0,0)); bottom: 0px; width: 60%; padding-left: 20%; padding-right: 20%; position: absolute; height: auto; padding-top: 300px;">
												<H1 class="at-titulo-artigo" style="position: relative; vertical-align: bottom; height: auto; left: 0px; text-align: left; width:100%; font-size: 3em; margin-bottom: 20px; bottom: 0px; word-spacing: 0px; line-height: 120%;"><?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?></H2>
												<H2 class="at-descricao-artigo" style="position: relative; margin-bottom: 50px; vertical-align: bottom; bottom: 0px; font-size: 1.2em; left: 0px; width:100%; height: auto;"><?php if ($linha_Artigos['ds_artigo'] != '') {echo $linha_Artigos['ds_artigo'];} else {echo 'Informação indisponível';} ?></H2>
											</div>
										</a>
									</div>
					<?php
								}
								while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
							}
						}
					?>
				</div>
				<div data-u="navigator" class="jssorb05" style="bottom:0px;right:0px;" data-autocenter="1">          
					<div data-u="prototype" style="width:0px;height:0px;"></div>
				</div>
				<span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
				<span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
			 
			</div>
			<?php
				}
			?>
			<div id="at_corp" style="max-width: 1024px; margin-left: auto; margin-right: auto;">
				<div class="internal" style="display: inline-block; width: 100%; height: auto;">
					<div class="at-main">
						<?php
							if ($view == '' || $view == 'ultimos')
							{
						?>
								<?php
									$result_Artigos = $conexaoPrincipal -> Query($query_ArtigosRecentes);
									$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
									$total_Artigos = mysqli_num_rows($result_Artigos);
								?>
								<h2 class="at-bloco-titulo" style="color: #444; border-bottom: 2px solid #E6E7E8; line-height: 150%">ÚLTIMOS ARTIGOS <?php if (!isset($_GET['view'])) { ?>  <?php } else {echo "- TOTAL ($total_Artigos)";} ?></h2>			
								<?php
									if ($total_Artigos > 0)
									{
										do
										{
											FormatarTags($linha_Artigos['ds_tags']);
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
																	<input type="image" id="col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="ratingExec('<?php echo $linha_Artigos['cd_artigo']; ?>')">
																	<input type="image" id="col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png" onclick="showCommentBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
																	<input type="image" id="col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="botaoCompartilhar = this; showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
																	<input type="image" id="col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png"/>
																	<input type="image" id="col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png"/>
																	<!--<label>Avaliações: <label id="col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>">-</label></label><br/>-->
																</td>
															</tr>
														</table>
														<h2 class="at-bloco-artigo-desc-result" id="view1<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_visita']; ?> visualizaç<?php echo (($linha_Artigos['qt_visita'] == 1) ? 'ão' : 'ões'); ?></h2>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:blue; background-color: transparent" id="col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>"><?php $stars = number_format($linha_Artigos['qt_estrelas'], 1, '.',','); if($linha_Artigos['qt_estrelas'] > 0) { if ($linha_Artigos['qt_estrelas'] == 1){echo $stars." estrela";} else {echo $stars.' estrelas';}} else {echo '5.0 estrelas';}?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:red; background-color: transparent;" id="col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_favorito'].' favoritadas'; ?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:gold; background-color: transparent;" id="col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_comentario'].' comentários'; ?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:green; background-color: transparent;" id="col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_compartilhar'].' compartilhamentos'; ?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:#333; background-color: transparent;" id="col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_leitura'].' marcações'; ?></label>
														<!--<table>
															<tr>
																<td align="left">
																	
																	<label>Comentários: <label id="col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_comentario']; ?></label></label>
																</td>
																<td align="left">
																	
																	
																	<label>Compartilhamentos: <label id="col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_compartilhar']; ?></label></label><br/>
																</td>
															</tr>
															<tr>
																<td align="left">
																	
																	<label>Favoritos: <label id="col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_favorito']; ?></label></label>
																</td>
																<td align="left">
																	
																	
																	<label>Ler depois: <label id="col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_leitura']; ?></label></label><br/>
																</td>
															</tr>
														</table>-->
													</h2>
													<script>
														col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															EsconderValores();
															col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
															col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
															col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
															col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
															col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = true;
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); at_avalreader.innerHTML = retorno; showRatingBox(spt[1],spt[2], '<?php echo $linha_Artigos['nm_titulo']; ?>','por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '')  {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>','<?php echo VOLTAR."artigo/".$linha_Artigos['ds_url']; ?>','<?php echo $linha_Artigos['cd_artigo']; ?>'); col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false; col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;");
															
														}
														
														col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															if (<?php echo $logado ?> == 1)
															{
																Ajax("GET", "<?php echo VOLTAR; ?>php/FavoritarArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showFavoriteBox('Artigo favoritado!');} else if (retorno == 0) {showFavoriteBox('Artigo desfavoritado!');} col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover();");
															}
															else
															{
																alert('Efetue login para executar essa ação!');
															}
														}
														
														col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onclick = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															if (<?php echo $logado ?> == 1)
															{
																Ajax("GET", "<?php echo VOLTAR; ?>php/MarcarLeituraArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; if (retorno == 1) {showReadBox('Marcado para leitura!');} else if (retorno == 0) {showReadBox('Desmarcado para leitura!');} col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover();");
															}
															else
															{
																alert('Efetue login para executar essa ação!');
															}
														}
														
														col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															
															col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
																													
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); if(retorno > 0){ if(retorno == 1){col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = retorno+' estrela'}else{col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = retorno+' estrelas';}} else {col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = '5.0 estrela';}");

														}
														
														col_one_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_one_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';															
															
														}
														
														col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															//Tirei isso aqui de dentro da função abaixo
															
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															
															col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + '  comentários'; ");
														}
														
														col_one_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															
															col_one_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															EsconderValores();
															
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' compartilhamento' + ((retorno == 1) ? '' : 's');");
														}
														
														col_one_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_one_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
																														
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';

															col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															if (<?php echo $logado ?> == 1)
															{
																Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; var aux = retorno.split(';-;')[0]; var qnt = retorno.split(';-;')[1]; var conteudo = ''; if (aux == 1) {if (qnt > 1) {if (qnt - 1 > 1) {conteudo = 'Você e outras ' + (qnt - 1) + ' pessoas favoritaram';} else {conteudo = 'Você e outra pessoa favoritaram';}} else {conteudo = 'Você favoritou';}} else {conteudo = qnt + ((qnt == 1) ? ' pessoa favoritou' : ' pessoas favoritaram');} col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = conteudo;");
															}
															else
															{
																Ajax("GET", "<?php echo VOLTAR; ?>php/ContarFavoritosArtigoOff.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' favoritada' + ((retorno == 1) ? '' : 's');");
															}
														}
														
														col_one_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_one_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															if (<?php echo $logado ?> == 1)
															{
																Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; var aux = retorno.split(';-;')[0]; var qnt = retorno.split(';-;')[1]; var conteudo = ''; if (aux == 1) {if (qnt > 1) {if (qnt - 1 > 1) {conteudo = 'Você e outras ' + (qnt - 1) + ' pessoas marcaram';} else {conteudo = 'Você e outra pessoa marcaram';}} else {conteudo = 'Você marcou';}} else {conteudo = qnt + ((qnt == 1) ? ' pessoa marcou' : ' pessoas marcaram');} col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = conteudo;");
															}
															else
															{
																Ajax("GET", "<?php echo VOLTAR; ?>php/ContarLeiturasArtigoOff.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' marcaç' + ((retorno == 1) ? 'ão' : 'ões');");
															}
														}
														
														col_one_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_one_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view1<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
													
													
													</script>
													
													
													
													<!--<input class="at-bloco-artigo-btn" style="background-color: purple;" type="button" value="Ler Artigo">-->
												</div>
											</div>
											
											<span class="line"></span>	
											
											
								<?php
										}
										while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
									}
								?>
								
								<?php 
									if (!isset($_GET['view'])) 
									{ 
								?> 
										<input type="button" class="at-more-articles" value="Ver mais" onclick=" window.location.href = '?<?php echo ((isset($categoria)) ? 'categoria='.$categoria.'&' : ''); ?>view=ultimos';" title='Ver mais de "ÚLTIMOS ARTIGOS"' style="cursor: pointer;"/>
								<?php 
									}
								?>
						<?php
							}
							
							if ($view == '' || $view == 'lidos')
							{
						?>
								<?php
									$result_Artigos = $conexaoPrincipal -> Query($query_ArtigosLidosSemana);
									$linha_Artigos = mysqli_fetch_assoc($result_Artigos);
									$total_Artigos = mysqli_num_rows($result_Artigos);
								?>
								<h2 class="at-bloco-titulo" style="color: #444; border-bottom: 2px solid #E6E7E8; line-height: 150%">OS MAIS LIDOS DA SEMANA <?php if (!isset($_GET['view'])) { ?>  <?php } else {echo "- TOTAL ($total_Artigos)";} ?></h2>			
								<?php
									if ($total_Artigos > 0)
									{
										do
										{
											FormatarTags($linha_Artigos['ds_tags']);
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
																	<input type="image" id="col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-rating" src="<?php echo VOLTAR; ?>images/star.png" onclick="showRatingBox();">
																	<input type="image" id="col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-comment" src="<?php echo VOLTAR; ?>images/comment.png" onclick="showCommentBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
																	<input type="image" id="col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-share" src="<?php echo VOLTAR; ?>images/share.png" onclick="botaoCompartilhar = this; showShareBox('<?php echo $linha_Artigos['cd_artigo']; ?>', '<?php if ($linha_Artigos['nm_titulo'] == '') {echo 'Informação indisponível';} else {echo $linha_Artigos['nm_titulo'];} ?>', 'por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '') {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>', '<?php echo $_SERVER['HTTP_HOST'].'/artigo/'.$linha_Artigos['ds_url']; ?>');">
																	<input type="image" id="col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-favorite" src="<?php echo VOLTAR; ?>images/favorite.png"/>															
																	<input type="image" id="col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>" class="anytech-post-button anytech-post-time" src="<?php echo VOLTAR; ?>images/time.png"/>
																	
																</td>
															</tr>
														</table>
														<h2 class="at-bloco-artigo-desc-result" id="view2<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_visita']; ?> visualizaç<?php echo (($linha_Artigos['qt_visita'] == 1) ? 'ão' : 'ões'); ?></h2>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:blue; background-color: transparent;" id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>">5.0 estrelas</label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:red; background-color: transparent;" id="col_two_value_btn_favorite<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_favorito'].' favoritadas'; ?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:gold; background-color: transparent;" id="col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_comentario'].' comentários'; ?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:green; background-color: transparent;" id="col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>" ><?php echo $linha_Artigos['qt_compartilhar'].' compartilhamentos'; ?></label>
														<label class="at-bloco-artigo-desc-result" style="display: none; color:#333; background-color: transparent;" id="col_two_value_btn_time<?php echo $linha_Artigos['cd_artigo']; ?>"><?php echo $linha_Artigos['qt_leitura'].' marcações'; ?></label>
															
														<!--<tr>
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
																	
																	<label>Avaliações: <label id="col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>">-</label></label><br/>
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
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); at_avalreader.innerHTML = retorno; showRatingBox(spt[1],spt[2], '<?php echo $linha_Artigos['nm_titulo']; ?>','por <?php if ($linha_Artigos['ic_autor_oculto'] == 1) {echo 'ANYTECH';} else if ($linha_Artigos['nm_usuario'] == '')  {echo 'Autor desconhecido';} else {echo $linha_Artigos['nm_usuario'];} ?>','<?php echo VOLTAR."artigo/".$linha_Artigos['ds_url']; ?>','<?php echo $linha_Artigos['cd_artigo']; ?>'); col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.disabled = false;");
															
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
															
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															
															col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarAvaliacaoArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; spt = retorno.split('&'); retorno = parseFloat(spt[0]); retorno = retorno.toFixed(1); if(retorno > 0){ if(retorno == 1){col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = retorno+' estrela'}else{col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = retorno+' estrelas';}} else {col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.innerHTML = '5.0 estrela';}");

														}
														
														col_two_anytech_post_rating<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															EsconderValores();
															col_two_value_btn_rating<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
														}
														
																											
														col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															//Tirei isso aqui de dentro da função abaixo
															
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															
															col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarComentariosArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' comentário' + ((retorno == 1) ? '' : 's');");
														}
														
														col_two_anytech_post_comment<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															
															col_two_value_btn_comment<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															EsconderValores();
															
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
															
															Ajax("GET", "<?php echo VOLTAR; ?>php/ContarCompartilharArtigo.php", "codigoArtigo=" + codigo, "var retorno = this.responseText; col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.textContent = retorno + ' compartilhamento' + ((retorno == 1) ? '' : 's');");
														}
														
														col_two_anytech_post_share<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseout = function()
														{
															col_two_value_btn_share<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_two_anytech_post_favorite<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';

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
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
														
														col_two_anytech_post_time<?php echo $linha_Artigos['cd_artigo']; ?>.onmouseover = function()
														{
															EsconderValores();
															
															
															var codigo = <?php echo $linha_Artigos['cd_artigo']; ?>;
															
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'none';
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
															view2<?php echo $linha_Artigos['cd_artigo']; ?>.style.display = 'inline-block';
														}
													</script>
													<!--<input class="at-bloco-artigo-btn" style="background-color: purple;" type="button" value="Ler Artigo">-->
												</div>
											</div>
											
											<span class="line"></span>	
								<?php
										}
										while ($linha_Artigos = mysqli_fetch_assoc($result_Artigos));
									}
									
								?>
								
								<?php 
									if (!isset($_GET['view'])) 
									{ 
								?> 
										<input type="button" class="at-more-articles" value="Ver mais" onclick="window.location.href = '?<?php echo ((isset($categoria)) ? 'categoria='.$categoria.'&' : ''); ?>view=lidos';" title='Ver mais de "ÚLTIMOS ARTIGOS"' style="cursor: pointer;"/>
								<?php 
									}
								?>
						<?php
							}
						?>
					</div>
					
					<div class="at-lateral">
					<?php
						$counterProp = $total_Artigos;
						$lateral_sugestao = $conexaoPrincipal -> Query("SELECT * FROM tb_artigo inner join artigo_tema_tag
																		on tb_artigo.cd_artigo = artigo_tema_tag.cd_artigo
																		inner join tb_tema
																		on tb_tema.cd_tema = artigo_tema_tag.cd_tema order by rand() desc limit $counterProp") or die("Mensagem Não Enviada");
								
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
									<a href="<?php echo $url_ls; ?>" class="at-standard-image" target="_blank" alt="<?php if (isset($imagem_ls)) {$tr = str_replace('artigo/imagens/','',$imagem_ls); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>" title="<?php if (isset($imagem_ls)) {$tr = str_replace('artigo/imagens/','',$imagem_ls); $tr = str_replace('-',' ',$tr); echo str_replace('.jpg','',$tr);} else {echo 'ANYTECH';} ?>"  style="cursor: pointer; background-image: url('<?php if(isset($imagem_ls)){echo VOLTAR.$imagem_ls;} else { echo VOLTAR.'images/feed/thumbnail.jpg';} ?>');"></a>
									
								</div>
								
							<?php
							
							}
							while ($linha_ls = mysqli_fetch_assoc($lateral_sugestao));
							
						}
					?>
					</div>
				</div>
			</div>
			<?php include(VOLTAR.'footer.php'); ?>			
		</div>
		<script>
			jssor_1_slider_init();
		</script>
		<script>
		/*window.onload = function()
		{
			getWW = window.innerWidth;
			aIMGS = document.getElementsByClassName('at-imagem-artigo');
			for(io = 0; io <= aIMGS.length; io++)
			{
				jssor_1.style.width = getWW+"px";
				jssor_1.style.height = getWW+"px";
				frmsld.style.width = getWW+"px";
				frmsld.style.height = getWW+"px";
				aIMGS[io].style.width = getWW+"px";
				aIMGS[io].style.height = getWW+"px";
			}
		}*/
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
				at_shr_art.href = "https://"+link;
				$('.maincover').fadeIn();
				$('#box_share_cover').toggle('slide');
			}
			
			function hideShareBox()
			{
				document.body.style.overflow = "visible";
				$('#box_share_cover').toggle('slide');
				$('.maincover').fadeOut();
			}
			
			
			
			function showCommentBox(codigo, titulo, autor, link)
			{
				document.body.style.overflow = "hidden";
				
				lbl_comment_title.textContent = titulo;
				lbl_comment_author.textContent = autor;
				txt_comment_link.value = link;
				txt_comment_code.value = codigo;
				at_com_art.href = "https://"+link;
				commentATx.href = "https://"+link+"?fb";
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
	</body>
</html>

<?php
	$conexaoPrincipal -> FecharConexao();
?>