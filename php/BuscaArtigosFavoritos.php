<?php
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	session_start();
	define('VOLTAR', '../');
	
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];
	
	//dados da mensagem	
	$result_Pesquisa = $conexaoPrincipal -> Query("select distinct nm_titulo, ds_url
													from tb_artigo
													inner join usuario_artigo_favorito
													on tb_artigo.cd_artigo = usuario_artigo_favorito.cd_artigo
													inner join tb_usuario
													on tb_usuario.cd_usuario = usuario_artigo_favorito.cd_usuario
													where tb_usuario.cd_usuario = '$cod_usuario';") or die("Mensagem Não Enviada") ;
			
	$linha_Pesquisa = mysqli_fetch_assoc($result_Pesquisa);
	$total_Pesquisa = mysqli_num_rows($result_Pesquisa);
	
	$cont = 0;
	
	if ($total_Pesquisa > 0)
	{
		do
		{	
			$nmArtigo = $linha_Pesquisa['nm_titulo'];
			$url = VOLTAR."artigo/".$linha_Pesquisa['ds_url'];
			echo 
			'<a href="'.$url.'" style="width: 100%; margin: 5px; margin-left: 0px; margin-right: 0px;">
				<div class="anytech-menu-option-list" align="center">
					<table width="100%" >
						<tr>
							<td width="1%">
								<img src="'.VOLTAR.'images/favorite.png" class="anytech-menu-option-image-list">
							</td>
							<td width="92%">
								<label class="anytech-menu-option-label-list">'.$nmArtigo.'<b> por Gustavo Alves</b></label>
							</td>
							<td width="7%">
								<input type="checkbox" class="check-item-favorite">
							</td>
						</tr>
					</table>
				</div>
			</a>';
		}
		while ($linha_Pesquisa = mysqli_fetch_assoc($result_Pesquisa));
		
	}
?>