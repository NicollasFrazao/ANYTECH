<?php
	//busca de informações da conta
	$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];
	
		$buscaDados = $conexaoPrincipal->query("select nm_estado,nm_cidade from tb_usuario
			inner join tb_endereco on tb_usuario.cd_usuario = tb_endereco.cd_usuario
				inner join tb_cidade on tb_endereco.cd_cidade = tb_cidade.cd_cidade
					inner join tb_estado on tb_cidade.cd_estado = tb_estado.cd_estado
						where tb_usuario.cd_usuario = '$cod_usuario' ");

	$buscaDados = mysqli_fetch_array($buscaDados);
	$cidadeUsuario = $buscaDados['nm_cidade'];
	$estadoUsuario = $buscaDados['nm_estado'];
	$imagemPerfil = $conexaoPrincipal->query("select im_perfil from tb_usuario where cd_usuario = '$cod_usuario' ");
	$imagemPerfil =  mysqli_fetch_assoc($imagemPerfil);
	$searchColor = $conexaoPrincipal->query("select ds_cor_background, ds_cor_menu, ds_cor_barra from tb_usuario where cd_usuario = '$cod_usuario' ");
	$searchColor = mysqli_fetch_assoc($searchColor);
	$colorMenu = $searchColor['ds_cor_menu'];
	$colorBarra = $searchColor['ds_cor_barra'];
	$colorBackground = $searchColor['ds_cor_background'];
?>

<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-menu.css">
<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-menu-media-query-sizetwo.css">
<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-menu-media-query-sizeone.css">

<div class="anytech-menu-body" id="anytech_menu_body">	
	<div class="anytech-menu-search">
		<table width="100%" cellspacing="0">
			<tr>
				<td width="100%">
					<input type="text" class="anytech-menu-search-input" id="search_text" placeholder="O que você procura?">
				</td>
				<td width="30px">
					<input type="image" class="anytech-menu-search-button" id="search_img" src="<?php echo VOLTAR; ?>images/search.png" onclick="search()">
				</td>
			</tr>
		</table>
	</div>	
	
	<div id="setSearch" style="overflow: auto; display: none; margin-top: 10px;">
		<div id="intosearchbox" style="background-color: transparent; height: 100%;"></div>
	</div>
	
	<div class="anytech-submenu" id="anytech_main_menu" style="overflow: auto;">			
		<div class="anytech-menu-option" align="center" onclick="profileMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/icologo.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Perfil</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="notifyMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/notificacao.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Notificações</label>
		</div>
		
		<div class="anytech-menu-option" align="center"  onclick="favoriteMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Favoritos</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="readMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/time.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Ler Depois</label>
		</div>
		
		<div class="anytech-menu-option" align="center"  onclick="interestsMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/interesses.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Interesses</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="productsMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/tools.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Produtos</label>
		</div>
		
		
		<div class="anytech-menu-option" align="center" onclick="accountMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/user.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Conta</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="historyMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/historico.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Histórico</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="infoMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/info.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Informações</label>
		</div>
		
		<div class="anytech-menu-option" align="center">
			<input type="image" src="<?php echo VOLTAR; ?>images/call.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label" >Fale Conosco</label>
		</div>
		
		
		<div class="anytech-menu-option" align="center" onclick="termsMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/rule.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Termos de Uso</label>
		</div>
		
		
		<div class="anytech-menu-option" align="center" onclick="configMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/config.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Configurações</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="this.onclick = ''; Logout();">
			<input type="image" src="<?php echo VOLTAR; ?>images/out.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Sair</label>
		</div>
	</div>
	
	
	<!--PERFIL-->
	<div class="anytech-submenu" id="anytech_profile_menu" align="center">	
		<input type="image" src="<?php echo VOLTAR; ?>images/foto.png" class="image-profile-cover" id="menu_profile_image_cover">
		<img src="<?php echo VOLTAR; ?><?php if ($imagemPerfil['im_perfil'] != '') {echo $imagemPerfil['im_perfil'];} else {echo '../images/user.png';} ?>" class="anytech-menu-profile-image" id="menu_profile_image">		
		<label class="anytech-profile-username"><?php echo $_SESSION['AnyTech']['nicknameUsuario']; ?></label>
		<label class="anytech-profile-location"><?php echo $estadoUsuario; ?>, <?php echo $cidadeUsuario; ?></label>
		<table width="80%;" cellspacing="5">
			<tr>
				<td width="50%">
					<div class="anytech-followers"  align="center">
						<label class="followers-count" id="followers_count">530.000</label>
						<label class="followers-legend">Seguidores</label>
					</div>
				</td>
				<td width="50%">
					<div class="anytech-followings"  align="center">
						<label class="followings-count" id="following_count">50.450</label>
						<label class="followings-legend">Seguindo</label>
					</div>
				</td>
			</tr>
		</table>
		<label class="anytech-profile-profile-full" onclick="window.location.href = '<?php echo VOLTAR; ?>profile';" style="cursor: pointer;">Visualize sua página de perfil completa</label>
	</div>
	
	<!--Ler Depois-->
	<div class="anytech-submenu" id="anytech_read_menu">		
		<div class="into-menu">
			<div class="anytech-menu-option-list" align="center">
				<table width="100%">
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/time.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngularJS - Aula 03 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-read">
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%">
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/time.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngularJS - Aula 03 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-read">
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%">
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/time.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngulgularJS - AulagularJS - AulagularJS - AulaarJS - Aula 03 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-read">
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%">
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/time.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngularJS - Aula 03 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-read">
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="form-buttons-group" align="right">
			<input type="button" value="Remover" class="anytech-form-button" id="delete-read">
			<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="readMenu()">
			<input type="button" value="Salvar" class="anytech-form-button">
		</div>
	</div>
	
	
	<!--Termos de Uso-->
	<div class="anytech-submenu" id="anytech_terms_menu">
		<div class="into-menu">
			
		</div>
	</div>
	
	<!--Favoritos-->
	<div class="anytech-submenu" id="anytech_favorite_menu">
		<div class="into-menu" id="carne">
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngularJS - Aula 01 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-favorite">
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngularJS - Aula 01 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-favorite">
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">Angular elar erer JS lar erer lar erer JS lar erer rer JS lar erer JS lar erer JS - Aula 01 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-favorite">
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-menu-option-image-list">
						</td>
						<td width="92%">
							<label class="anytech-menu-option-label-list">AngularJS - Aula 01 - <b>por Gustavo Alves</b></label>
						</td>
						<td width="7%">
							<input type="checkbox" class="check-item-favorite">
						</td>
					</tr>
				</table>
			</div>
			
		</div>
		<div class="form-buttons-group" align="right">
			<input type="button" value="Remover" class="anytech-form-button" id="delete-fav">
			<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="favoriteMenu()">
			<input type="button" value="Salvar" class="anytech-form-button">
		</div>
	</div>
	
	<!--Histórico-->
	<div class="anytech-submenu" id="anytech_history_menu">
		<label class="anytech-menu-option-label-list-history">Você avaliou o artigo <a class="anytech-link">"Java é horrível"</a> em 23/10/2015 às 15:55</label>
		<label class="anytech-menu-option-label-list-history">Você avaliou o artigo <a class="anytech-link">"Java é horrível"</a> em 23/10/2015 às 15:55</label>
	</div>
	
	<!--Notificações-->
	<div class="anytech-submenu" id="anytech_notify_menu">
		<div class="into-menu-two">
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/favorite.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Gustavo Alves</b> favoritou seu artigo <b>Aula 01 - AngularJS</b></label>
						</td>
					</tr>
				</table>
			</div>	
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/time.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>João Vasconcelos</b> marcou seu artigo <b>P.O.P. - Programação Orientada à Potássio</b> para ler depois</label>
						</td>
					</tr>
				</table>
			</div>	
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/comment.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Lucas Denhei</b> comentou seu artigo <b>P.O.P. - Programação Orientada à Potássio</b></label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/share.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Luiz Carlos</b> compartilhou seu artigo <b>Tudo sobre Selects</b></label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Lucas Denhei</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>João Vasconcelos </b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Luiz Carlos</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/add.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list"><b>Nicollas Leite</b> seguiu você</label>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="anytech-menu-option-list" align="center">
				<table width="100%" >
					<tr>
						<td width="1%">
							<img src="<?php echo VOLTAR; ?>images/lixeira.png" class="anytech-menu-option-image-list">
						</td>
						<td>
							<label class="anytech-menu-option-label-list">Seu artigo <b>Popopopopoints</b> foi removido pelos administradores</label>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<!--Configurações-->
	<div class="anytech-submenu" id="anytech_config_menu">		
		<div class="anytech-menu-option" align="center">
			<input type="image" src="<?php echo VOLTAR; ?>images/security.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Segurança</label>
		</div>
		
		<div class="anytech-menu-option" align="center"  onclick="configColor()" id="anytech_style_button">
			<input type="image" src="<?php echo VOLTAR; ?>images/color.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Estilo</label>
		</div>
	</div>
	
	<!--Produtos-->
	<div class="anytech-submenu" id="anytech_products_menu">		
		<div class="anytech-menu-option" align="center" onclick="productsLogin()">
			<input type="image" src="<?php echo VOLTAR; ?>images/products/eletrontech.png" class="anytech-menu-option-image" id="anytech-menu-option-image-products">
			<label class="anytech-menu-option-label">Eletrontech</label>
		</div>
		
		<div class="anytech-menu-option" align="center">
			<input type="image" src="<?php echo VOLTAR; ?>images/products/mappie.png" class="anytech-menu-option-image" id="anytech-menu-option-image-products">
			<label class="anytech-menu-option-label">Mappie</label>
		</div>
		
		<div class="anytech-menu-option" align="center">
			<input type="image" src="<?php echo VOLTAR; ?>images/products/biotech.png" class="anytech-menu-option-image" id="anytech-menu-option-image-products">
			<label class="anytech-menu-option-label">Biotech</label>
		</div>
	</div>
	
	<!--Produtos Login-->
	<div class="anytech-submenu" id="anytech_products_login_menu" align="center">		
		<img src="<?php echo VOLTAR; ?>images/products/eletrontech.png" class="anytech-menu-profile-image">
		<label class="anytech-profile-username">Eletrontech</label>
		<input type="text" class="anytech-input-login" placeholder="Email">
		<input type="text" class="anytech-input-login" placeholder="Senha"><br>			
		<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="productsLoginOut()">
		<input type="button" value="Acessar" class="anytech-form-button">
		<label class="anytech-profile-profile-full">Não consigo acessar minha conta</label>		
	</div>
	
	<!--Produtos Login-->
	<div class="anytech-submenu" id="anytech_info_menu" align="center">		
		<img src="<?php echo VOLTAR; ?>images/logoico.png" class="anytech-menu-profile-image">
		<label class="anytech-profile-username">ANYTECH</label>
		<label class="anytech-info-desc">DESENVOLVIMENTO DE SISTEMAS</label>		
	</div>
	
	<!--Interesses-->
	<div class="anytech-submenu" id="anytech_interests_menu">
		<div class="into-menu">
			<input type="button" value="Javascript" class="interest-buttons-selected">
			<input type="button" value="HTML" class="interest-buttons-selected">
			<input type="button" value="CSS" class="interest-buttons-selected">
			<input type="button" value="C#" class="interest-buttons-selected">
			<input type="button" value="MySQL" class="interest-buttons-selected">
			<input type="button" value="JQuery" class="interest-buttons-selected">
			<input type="button" value="Java" class="interest-buttons">
			<input type="button" value="Python" class="interest-buttons">
			<input type="button" value="Pascal" class="interest-buttons">
			<input type="button" value="Delphi" class="interest-buttons">
			<input type="button" value="Visual Basic" class="interest-buttons">
			<input type="button" value="C" class="interest-buttons">
			<input type="button" value="C++" class="interest-buttons">
			<input type="button" value="Javascript" class="interest-buttons">
			<input type="button" value="Javascript" class="interest-buttons">
			<input type="button" value="Javascript" class="interest-buttons">
			<input type="button" value="Javascript" class="interest-buttons">
			<input type="button" value="Javascript" class="interest-buttons">
			<input type="button" value="Javascript" class="interest-buttons">			
		</div>
		<div class="form-buttons-group" align="right">
			<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="interestsMenu()">
			<input type="button" value="Salvar" class="anytech-form-button">
		</div>
	</div>
	
	
	<!--Conta-->
	<div class="anytech-submenu" id="anytech_account_menu">				
		<div class="anytech-menu-option" align="center" onclick="passwordMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/password.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Alterar Senha</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="dataMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/identidade.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Dados Gerais</label>
		</div>
		
		<div class="anytech-menu-option" align="center" onclick="leaveMenu()">
			<input type="image" src="<?php echo VOLTAR; ?>images/delete.png" class="anytech-menu-option-image">
			<label class="anytech-menu-option-label">Desativar Conta</label>
		</div>
	</div>
	
	<!--Conta Alterar Senha-->
	<div class="anytech-submenu" id="anytech_account_menu_password">
		<div class="into-menu">
			<label class="anytech-label-data">Senha Atual</label>
			<input type="password" class="anytech-input-data" id="senhaAtual">
			<label class="anytech-label-data">Nova Senha</label>
			<input type="password" class="anytech-input-data" id="senhaNova">
			<label class="anytech-label-data">Confirmar Nova Senha</label>
			<input type="password" class="anytech-input-data" id="senhaNovaConfirmacao">
		</div>
		<div class="form-buttons-group" align="right">
			<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="passwordMenu()">
			<input type="button" value="Salvar" class="anytech-form-button" onclick="alterPassword()">
		</div>
	</div>
	
	<!--Conta Alterar Dados Gerais-->
	<form>
		<div class="anytech-submenu" id="anytech_account_data">
			<div class="into-menu-three">		
				<label class="anytech-label-data">Nome completo</label>
				<input type="text" class="anytech-input-data at-valida" id="nome_completo" tipo="NomeCompleto">
				
				<label class="anytech-label-data">E-mail</label>
				<input type="text" class="anytech-input-data at-valida" id="email" tipo="E-mail">
				
				<label class="anytech-label-data">CPF</label>
				<input type="text" class="anytech-input-data" id="cpf">
				
				<table width="98%" cellspacing="0" style="margin-left: 1%;">
					<tr>
						<td width="50%">
							<label class="anytech-label-data">Data de Nascimento</label>
							<input type="text" class="anytech-input-data-table at-valida" tipo="Datanas" id="dtnascimento">
						</td>
						<td width="50%">
							<label class="anytech-label-data">Telefone</label>
							<input type="text" class="anytech-input-data-table at-valida" id="telefone" tipo="Telefone">
						</td>
					</tr>
				</table>
				<label class="anytech-label-data">Estado</label>
				<!---------------------------------BUSCA DE ESTADOS----------------------------------->
			<?php
				$buscaEstado = $conexaoPrincipal -> Query("SELECT cd_estado, nm_estado FROM tb_estado");
				$buscaEstadoQtd = mysqli_num_rows($buscaEstado);
				$estados = mysqli_fetch_assoc($buscaEstado);
			?>
			
			
			<select type="text" class="anytech-input-data-select" id="estado" onchange="buscaCidade()">
				<?php 
					if ($buscaEstadoQtd > 0)
					{
						do
						{
				?>
							<option id="valor_estado" value="<?php echo $estados['cd_estado']; ?>"><?php echo  $estados['nm_estado']; ?></option>
				<?php
						}
						while ($estados = mysqli_fetch_assoc($buscaEstado));
					}
				?>
			</select>
							
				<!----------------------------------------------------------------------------------------------------------->
				
				<label class="anytech-label-data">Cidade</label>
				<select type="text" class="anytech-input-data-select" id="cidade">
					<?php
						$result_Cidades = $conexaoPrincipal -> Query("select tb_cidade.cd_cidade, tb_cidade.nm_cidade
																		  from tb_cidade
																			where tb_cidade.cd_estado = (select tb_estado.cd_estado
																		  from tb_estado inner join tb_cidade
																			on tb_estado.cd_estado = tb_cidade.cd_estado
																			  inner join tb_endereco
																				on tb_cidade.cd_cidade = tb_endereco.cd_cidade
																				  inner join tb_usuario
																					on tb_endereco.cd_usuario = tb_usuario.cd_usuario
																			where tb_usuario.cd_usuario = '$cod_usuario')");
						$linha_Cidades = mysqli_fetch_assoc($result_Cidades);
						$total_Cidades = mysqli_num_rows($result_Cidades);
						
						if ($total_Cidades > 0)
						{
							do
							{
					?>
								<option value="<?php echo $linha_Cidades['cd_cidade']; ?>" ><?php echo $linha_Cidades['nm_cidade']; ?></option>
					<?php
							}
							while ($linha_Cidades = mysqli_fetch_assoc($result_Cidades));
						}
					?>
				</select>
				
			</div>
			<br>
			<div class="form-buttons-group" align="right">
				<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="dataMenu()">
				<input type="button" value="Salvar" class="anytech-form-button" onclick="alteraDadosGerais()">
			</div>
		</div>
	</form>
	
	<!--Conta Alterar Dados Gerais-->
	<div class="anytech-submenu" id="anytech_account_leave">
		<div class="into-menu">	
			<label class="anytech-label-data">Por que deseja desativar sua conta?</label>
			<select type="text" class="anytech-input-data-select" id="motivoConfirm()">
				<option>Algum Motivo</option>
			</select>
			
			<label class="anytech-label-data">Digite sua senha</label>
			<input type="password" class="anytech-input-data" id="passwordConfirm">
		</div>
		<div class="form-buttons-group" align="right">
			<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="leaveMenu()">
			<input type="button" value="Desativar" class="anytech-form-button" onclick="desativaConta()">
		</div>
	</div>
	
	<!--Configuração Estilo-->
	<div class="anytech-submenu" id="anytech_config_color">
		<div class="into-menu">
			<label class="anytech-label">Header</label>
			<div class="anytech-colors">
				<input type="button" class="anytech-color-button" name="#000000" style="background-color:#000000;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#3a1f16" style="background-color:#3a1f16;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#041c5c" style="background-color:#041c5c;" onclick="primaryColor(this.name)">
				
				<input type="button" class="anytech-color-button" name="#2457c5" style="background-color:#2457c5;" onclick="primaryColor(this.name)">				
				<input type="button" class="anytech-color-button" name="#00b8ff" style="background-color:#00b8ff;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#fb8105" style="background-color:#fb8105;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#c10404" style="background-color:#c10404;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#540383" style="background-color:#540383;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#a400a5" style="background-color:#a400a5;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#007a21" style="background-color:#007a21;" onclick="primaryColor(this.name)">
				
				<input type="button" class="anytech-color-button" name="#174500" style="background-color:#174500;" onclick="primaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#777777" style="background-color:#777777;" onclick="primaryColor(this.name)">
			</div>
			
			<label class="anytech-label">Menu</label>
			<div class="anytech-colors">
				<input type="button" class="anytech-color-button" name="#000000" style="background-color:#000000;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#222222" style="background-color:#222222;" onclick="secundaryColor(this.name)">				
				<input type="button" class="anytech-color-button" name="#3a1f16" style="background-color:#3a1f16;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#041c5c" style="background-color:#041c5c;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#2457c5" style="background-color:#2457c5;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#5f8aff" style="background-color:#5f8aff;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#00b8ff" style="background-color:#00b8ff;" onclick="secundaryColor(this.name)">	
				<input type="button" class="anytech-color-button" name="#fdb200" style="background-color:#fdb200;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#dd0808" style="background-color:#dd0808;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#68099f" style="background-color:#68099f;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#c801c9" style="background-color:#c801c9;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#139f39" style="background-color:#139f39;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#564e4c" style="background-color:#564e4c;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#888888" style="background-color:#888888;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#fb8105" style="background-color:#fb8105;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#c10404" style="background-color:#c10404;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#540383" style="background-color:#540383;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#a400a5" style="background-color:#a400a5;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#007a21" style="background-color:#007a21;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#777777" style="background-color:#777777;" onclick="secundaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#174500" style="background-color:#174500;" onclick="secundaryColor(this.name)">
			</div>
			
			<label class="anytech-label">Background</label>
			<div class="anytech-colors">
				<input type="button" class="anytech-color-button" name="#333333" style="background-color:#333333;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#ffe29e" style="background-color:#ffe29e;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#9ecbff" style="background-color:#9ecbff;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#ffbcbc" style="background-color:#ffbcbc;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#dda0ff" style="background-color:#dda0ff;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#feafff" style="background-color:#feafff;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#d1ffdd" style="background-color:#d1ffdd;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#90827d" style="background-color:#90827d;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#eeeeee" style="background-color:#eeeeee;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#222222" style="background-color:#222222;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#000000" style="background-color:#000000;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#fdb200" style="background-color:#fdb200;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#5f8aff" style="background-color:#5f8aff;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#dd0808" style="background-color:#dd0808;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#68099f" style="background-color:#68099f;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#c801c9" style="background-color:#c801c9;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#139f39" style="background-color:#139f39;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#564e4c" style="background-color:#564e4c;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#888888" style="background-color:#888888;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#fb8105" style="background-color:#fb8105;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#2457c5" style="background-color:#2457c5;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#c10404" style="background-color:#c10404;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#540383" style="background-color:#540383;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#a400a5" style="background-color:#a400a5;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#007a21" style="background-color:#007a21;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#3a1f16" style="background-color:#3a1f16;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#00b8ff" style="background-color:#00b8ff;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#041c5c" style="background-color:#041c5c;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#777777" style="background-color:#777777;" onclick="tertiaryColor(this.name)">
				<input type="button" class="anytech-color-button" name="#174500" style="background-color:#174500;" onclick="tertiaryColor(this.name)">
				
			</div>
		</div>
		<br>
		<div class="form-buttons-group" align="right" id="button-colors-cont">
			<input type="button" value="Voltar" class="anytech-form-button" id="anytech_menu_back_button" onclick="configColor()">
			<input type="button" value="Salvar" class="anytech-form-button" onclick="alterColor()">
		</div>
	</div>	
</div>
<div class="anytech-cover-notify" id="anytech_cover_notify" align="center">
	<label class="legend-notify" id="notify_req_ajx"></label>
</div>

<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
<script src="<?php echo VOLTAR; ?>js/menu.js"></script>
<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>

<script src="<?php echo VOLTAR; ?>js/AnyTech - Validação.js"></script>
<script> MapearForms(); </script>

<script>
	anytech_menu_button.onclick = function()
	{
		
		$("#anytech_menu_body").toggle('slide');
		getFollowers();
		applyFavoriteArticles();
		
	}
	
	function search()
	{
		if(subMenuIndex == 1)
		{
			mainMenu();
		}
	}
	
	function mainMenu()
	{
		subMenuIndex = 0;
		search_text.value="";
		search_text.disabled = false;
		search_img.src = "<?php echo VOLTAR; ?>images/search.png";
		$(".anytech-submenu").css( "display", "none" );
		$("#anytech_main_menu").toggle('slide');		
	}
	
	function enterSubMenu()
	{
		subMenuIndex = 1;
		search_text.disabled = true;
		search_img.src = "<?php echo VOLTAR; ?>images/close.png";
		$("#anytech_main_menu").toggle('slide');
	}
	
	function dataMenu()
	{
		search_text.value="@DadosGerais";
		$("#anytech_account_menu").toggle('slide');
		exibeDadosGerais();
		$("#anytech_account_data").toggle('slide');
	}	
	
	// Função de verificação de login
	function VerificarLogado()
	{
		Ajax("GET", "<?php echo VOLTAR; ?>php/VerificarLogado.php", "", "var retorno = this.responseText; if (retorno == 0) {alert('Você foi desconectado! Esperamos ver você em breve novamente.'); Recarregar();}");
		
		setTimeout("VerificarLogado();", 7000);
	}
	
	function Recarregar()
	{
		window.location.reload();
	}
	
	//função para lofout
	function Logout()
	{
		document.body.style.cursor = 'progress'; 
		Ajax("GET", "<?php echo VOLTAR; ?>php/Logout.php", "", "document.body.style.cursor = 'auto'; window.location.reload();");
	}
	
	//Função para alterar senha	
		function alterPassword(){
		var atual = document.getElementById('senhaAtual').value;
		var nova = document.getElementById('senhaNova').value;
		var novaconfirmacao = document.getElementById('senhaNovaConfirmacao').value;
		
			$.ajax({
				url: '<?php echo VOLTAR; ?>php/AlterarSenha.php',
				data: {senhaAtual: atual, senhaNova: nova, senhaNovaConfirmacao: novaconfirmacao},
				type: 'POST',
				success:function(retorno){
					notify_req_ajx.innerHTML = retorno;
					showReturnAjax();
					//$(".anytech-input-data").val('');
				}
			})		
		}
		
		//Função para salvar cor no banco
		function alterColor(){
			$.ajax({
				url: '<?php echo VOLTAR; ?>php/AlterarCor.php',
				data: {cor_Menu: corMenu, cor_Background: corBackground, cor_Header: corHeader},
				type: 'POST',
				success:function(retorno){
					notify_req_ajx.innerHTML = retorno;
					showReturnAjax();
				}
			})
		}
		
		//Função para exibir dados e alterar dados gerais		
		function exibeDadosGerais(){
			$.ajax({
				url:'<?php echo VOLTAR; ?>php/ExibeDadosGerais.php',
				success: function(retorno){		
					//alert(retorno);
					var resultado = retorno;					
					resultado = resultado.split("//");
					document.getElementById('nome_completo').value = resultado[0];
					document.getElementById('email').value = resultado[1];
					document.getElementById('cpf').value = resultado[5];
					document.getElementById('dtnascimento').value = resultado[2];
					document.getElementById('telefone').value = '';
					document.getElementById('estado').value = resultado[4];
					document.getElementById('cidade').value = resultado[3];
					$("#cpf").prop('disabled', true);
				}
			})
		}
		
		function alteraDadosGerais(){
			var nm = document.getElementById('nome_completo').value;
			var em =  document.getElementById('email').value;
			var cp = document.getElementById('cpf').value;
			var dt = document.getElementById('dtnascimento').value;
			var tel = document.getElementById('telefone').value;
			var cid = $('#cidade').val();
			var est = $("#estado").val();				
			//alert(est);
			$.ajax({
				url: '<?php echo VOLTAR; ?>php/AlteraDadosGerais.php',
				data: {nome:nm, email:em,cpf:cp,datanas: dt,telefone:tel,cidade:cid,estado:est},
				type: 'POST',
				success: function(retorno){
					notify_req_ajx.innerHTML = retorno;
					showReturnAjax();			
				}
			})
		}
		
		//Função para desativar conta
		function desativaConta(){
			var senha = document.getElementById('passwordConfirm').value;
			//var motivo = document.getElementById('motivoConfirm').value;
			
			$.ajax({
				url:'<?php echo VOLTAR; ?>php/DesativarConta.php',	
				data: {passwordConfirm: senha, },
				type: 'POST',				
				success: function(retorno){
					notify_req_ajx.innerHTML = retorno;
					showReturnAjax();	
				}
			})
		}

	//Buscar cidade
	function buscaCidade(){
		
		var estado = $("#estado").val();
		
		$.ajax({
			url: '<?php echo VOLTAR; ?>php/PopulaCidade.php',
			data:{Estado: estado},
			type: 'POST',
			success:function(retorno){
				$("#cidade").children().remove();
				var cidades = retorno.split("|");
				var posicoes = cidades.length - 1;
				for(i=0;i < posicoes;i++){
					var codigo = cidades[i].split("/")
					$('#cidade').append('<option value=" '+ codigo[0] +' " >'+codigo[1]+'</option>');
				}
			}
		})
		
	}
	function refreshColor(){
	var colorMenu = "<?php echo $colorMenu;?>";
	var colorBarra = "<?php echo $colorBarra; ?>";
	var colorBackground = "<?php echo $colorBackground; ?>";
	$(".anytech-menu-body").css('background-color',colorMenu);
	$(".anytech-bar").css('background-color',colorBarra);
	$("body").css('background-color',colorBackground);
	$(".anytech-follow-button").css('background-color',colorBarra);
	$(".button-comment-submit").css('background-color',colorBarra);
	$(".anytech-profile-name").css('color',colorBarra);
	$(".anytech-info-label-count").css('color',colorBarra);
	$(".anytech-box-title").css('background-color',colorBarra);
	$(".anytech-info-label-follow").css('color',colorBarra);
	}
	 refreshColor();
	 
	 function showReturnAjax()
	{
		$('#anytech_cover_notify').fadeIn();
		setTimeout('hideReturnAjax();',2000);
	}
	
	function hideReturnAjax()
	{
		$('#anytech_cover_notify').fadeOut();
	}
	
	search_text.onkeyup = function()
	{
		if(search_text.value == "")
		{
			anytech_main_menu.style.display = "inline-block";
			$("#setSearch").fadeOut("slow");
		}
		else
		{
			anytech_main_menu.style.display = "none";
			$("#setSearch").fadeIn("slow");
			altPg = parseInt(window.innerHeight);
			altPg = altPg - 150;
			setSearch.style.height = altPg + "px";				
			altPg = parseInt(window.innerHeight);
			altPg = altPg;
			intosearchbox.style.height = altPg + "px";	
			selSearch();
		}
	}
	
	subMenuIndex = 0;
	VerificarLogado();
	
	
	function selSearch()
	{	
		mensagem = search_text.value;			
		$.ajax({
				url:'<?php echo VOLTAR; ?>/php/PesquisaSugestaoNews.php',
				type:'POST',
				data:{
						Mensagem:mensagem},
				success:function(retorno){
					
					//itensSugestao = retorno.split(';');	
					intosearchbox.innerHTML = "";
					intosearchbox.innerHTML = retorno;
				}
			})
	}
	
	
	function applyFavoriteArticles()
	{		
		$.ajax({
				url:'<?php echo VOLTAR; ?>/php/BuscaArtigosFavoritos.php',
				type:'POST',
				success:function(retorno){
					
					//itensSugestao = retorno.split(';');	
					carne.innerHTML = "";
					carne.innerHTML = retorno;
				}
			})
	}
	
	window.onresize = function()
	{
		altPg = parseInt(window.innerHeight);
		altPg = altPg - 150;
		setSearch.style.height = altPg + "px";	
		anytech_main_menu.style.height = altPg + "px";
	}
</script>