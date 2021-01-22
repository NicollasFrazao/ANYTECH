<?php
	if ($logado == 1)
	{
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
		
		$result = $conexaoPrincipal -> Query("select nm_email from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha = mysqli_fetch_assoc($result);
		
		$emailUsuario = $linha['nm_email'];
	}
	else
	{
		$emailUsuario = '';
	}
	
	$result_TemasLinguagens = $conexaoPrincipal -> Query("select cd_tema, nm_tema from tb_tema where ic_linguagem_programacao = 1 order by nm_tema");
	$linha_TemasLinguagens = mysqli_fetch_assoc($result_TemasLinguagens);
	$total_TemasLinguagens = mysqli_num_rows($result_TemasLinguagens);
	
	$result_TemasOutros = $conexaoPrincipal -> Query("select cd_tema, nm_tema from tb_tema where ic_linguagem_programacao != 1 order by nm_tema");
	$linha_TemasOutros = mysqli_fetch_assoc($result_TemasOutros);
	$total_TemasOutros = mysqli_num_rows($result_TemasOutros);
?>

<div class="at-newsletter" style="background-image: url('<?php echo VOLTAR; ?>images/news.jpg')" align="center">
	<h2 class="nl-title">Receba nossos conteúdos por e-mail</h2>
	<h2 class="nl-desc">Inscreva-se para receber todas as novidades da ANYTECH direto no seu e-mail!</h2><br>	
	<input type="text" class="nl-input" placeholder="Seu e-mail" value="<?php echo $emailUsuario; ?>" <?php if ($logado == 1) {echo 'readonly';} ?>>			
	<input type="button" class="nl-btn" value="Assinar" style="cursor: pointer" <?php if ($logado == 1) {echo 'disabled';} ?>>		
</div>
<div class="anytech-map">
	<table id="anytech_map_table" >
		<tr>
			<td width="38%" class="ftdk">							
				<b><label class="anytech-map-label" id="home-map">LINGUAGENS DE PROGRAMAÇÃO</label></b>
				<?php
					if ($total_TemasLinguagens > 0)
					{
						do
						{
				?>
							<a href="<?php echo VOLTAR.'news?categoria='.$linha_TemasLinguagens['cd_tema']; ?>" style="cursor: pointer; text-decoration: none;" class="anytech-map-label" id="about-map"><?php echo $linha_TemasLinguagens['nm_tema']; ?></a>
				<?php
						}
						while ($linha_TemasLinguagens = mysqli_fetch_assoc($result_TemasLinguagens));
					}
				?>
			</td>
			<td width="38%" valign="top" class="ftdki">
				<b><label class="anytech-map-label" id="home-map">OUTRAS CATEGORIAS</label></b>
				<?php
					if ($total_TemasOutros > 0)
					{
						do
						{
				?>
							<a href="<?php echo VOLTAR.'news?categoria='.$linha_TemasOutros['cd_tema']; ?>" style="cursor: pointer; text-decoration: none;" class="anytech-map-label" id="about-map"><?php echo $linha_TemasOutros['nm_tema']; ?></a>
				<?php
						}
						while ($linha_TemasOutros = mysqli_fetch_assoc($result_TemasOutros));
					}
				?>
			</td>
			<td width="23%" valign="top" class="ftdki">
				<b><label class="anytech-map-label" id="contact-map">NOSSAS PÁGINAS</label></b>
				<a href="<?php echo VOLTAR; ?>institucional" style="cursor: pointer; text-decoration: none;" class="anytech-map-label" title="Ir para a nossa página institucional">Institucional</a>
				<a href="<?php echo VOLTAR; ?>news" style="cursor: pointer; text-decoration: none;" class="anytech-map-label" title="Ir para a nossa página de artigos e notícias">News</a>
				<a href="https://www.facebook.com/anytechOficial/" target="_blank" style="cursor: pointer; text-decoration: none;" class="anytech-map-label" title="Ir para a nossa página no Facebook">Facebook</a>
				<a style="cursor: pointer" class="anytech-map-label">Twitter</a>
				<a style="cursor: pointer" class="anytech-map-label">Youtube</a>
			</td>
		</tr>
	</table>
	<label id="anytech_footer_label">ANYTECH - 2016</label>
</div>