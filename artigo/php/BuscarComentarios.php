<?php
	define('VOLTAR', '../../');
	session_start();
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	if (isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	}
	
	$codigoArtigo = mysql_escape_string($_GET['codigoArtigo']);
	$codigosComentarios = mysql_escape_string($_GET['codigosComentarios']);
	$codigosComentarios = explode(';', $codigosComentarios);
	
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
?>

<?php
	echo $total_Comentarios.'<--;-;-->';
	
	if ($total_Comentarios > 0)
	{
		do
		{
			//echo ' '.array_search($linha_Comentarios['cd_comentario_artigo'], $codigosComentarios).'-'.$linha_Comentarios['cd_comentario_artigo'];
			if (array_search($linha_Comentarios['cd_comentario_artigo'], $codigosComentarios) === false)
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