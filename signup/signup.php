<?php
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$nomeCompleto = $_SESSION['AnyTech']['nomeUsuario'];
	$primeiroNome = explode(' ', $nomeCompleto);
	$primeiroNome = $primeiroNome[0];
	
	$result_Usuario = $conexaoPrincipal -> Query("select cd_nivel_cadastro from tb_usuario where cd_usuario = '$codigoUsuario'");
	$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
	
	$nivelCadastro = $linha_Usuario['cd_nivel_cadastro'];
	
	if ($nivelCadastro >= 4)
	{
		header('Location: ../');
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<?php
			include VOLTAR.'php/CoresGoogle.php';
		?>
		
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png"/>
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-signup.css">
		<title>ANYTECH - Complete seu cadastro</title>
	</head>
	<body>
		<div class="anytech-bar">
			<img src="<?php echo VOLTAR; ?>images/logohome.png" id="anytech_logo_image">
			<label class="signup-label-topbar">Olá, <?php echo $primeiroNome; ?>!</label>
		</div>
		
		<?php
			if ($nivelCadastro < 2)
			{
		?>
				<form id="Frm_Localizacao" method="POST" action="<?php echo VOLTAR; ?>php/AdicionarLocalizacao.php">
					<div class="signup-body" id="signup_location">
						<div class="signup-data" align="left" id="data_location">			
							<label id="signup_label_title">PRECISAMOS DE MAIS ALGUMAS INFORMAÇÕES</label><br>
							<label class="signup-label">Nós da <b>ANYTECH</b>, prestamos serviços em todo o território nacional.</label><br>
							
							<label class="signup-label" id="select_label">Informe seu estado</label><br>
							<select id="cmb_estado" class="signup-select-state" required>
								<option value="">Selecione...</option>
								<?php
									$result_Estados = $conexaoPrincipal -> Query("select cd_estado, nm_estado, sg_estado from tb_estado order by nm_estado");
									$linha_Estados = mysqli_fetch_assoc($result_Estados);
									$total_Estados = mysqli_num_rows($result_Estados);
									
									if ($total_Estados > 0)
									{
										do
										{
								?>
											<option value="<?php echo $linha_Estados['cd_estado']; ?>"><?php echo $linha_Estados['nm_estado']; ?></option>
								<?php
										}
										while ($linha_Estados = mysqli_fetch_assoc($result_Estados));
									}
								?>
							</select>
							<br>
							
							<label class="signup-label" id="select_label">Informe sua cidade</label><br>
							<select id="cmb_cidade" class="signup-select-city" required>
								<option value="">Selecione...</option>
							</select>
							<div class="signup-buttons-group" align="left">
								<input type="button" value="Pular" class="anytech-cancel" id="body_location_skip">
								<input type="submit" value="Avançar" class="anytech-next" id="body_location_next">
							</div>
						</div>
					</div>
					<input type="hidden" name="codigoCidade" id="txt_cidade" value="" required/>
				</form>
				
				<form id="Frm_Estado" method="POST" action="<?php echo VOLTAR; ?>php/BuscarCidades.php">
					<input type="hidden" id="txt_estado" name="codigoEstado" value="" required/>
					<input type="submit" id="btn_estado"/>
				</form>
					
				<script>
					function AvancarLocalizacao()
					{
						Ajax("GET", "<?php echo VOLTAR; ?>php/AvancarNivelCadastro.php", "", "$('#signup_location').fadeOut('slide'); $('#signup_photo').fadeIn('slide');");
					}
					
					cmb_estado.onchange = function()
					{
						if (this.value != "")
						{
							txt_estado.value = cmb_estado.value;
							btn_estado.click();
						}
						else
						{
							cmb_cidade.disabled = true;
						}
					}
					
					Frm_Estado.onsubmit = function()
					{
						try
						{
							AjaxForm(this, "document.body.style.cursor = 'progress'; cmb_estado.disabled = true; cmb_cidade.disabled = true; body_location_skip.disabled = true; body_location_next.disabled = true;", "document.body.style.cursor = 'auto'; cmb_estado.disabled = false; cmb_cidade.disabled = false; body_location_skip.disabled = false; body_location_next.disabled = false; var retorno = this.responseText; cmb_cidade.innerHTML = retorno;");
						}
						catch (exe)
						{
							console.log(exe.message);
						}
						
						return false;
					}
					
					body_location_skip.onclick = function()
					{
						AvancarLocalizacao();
					}
					
					body_location_next.onclick = function()
					{
						
					}
					
					Frm_Localizacao.onsubmit = function()
					{
						try
						{
							AjaxForm(this, "txt_cidade.value = cmb_cidade.value; document.body.style.cursor = 'progress'; cmb_estado.disabled = true; cmb_cidade.disabled = true; body_location_skip.disabled = true; body_location_next.disabled = true;", "document.body.style.cursor = 'auto'; cmb_estado.disabled = false; cmb_cidade.disabled = false; body_location_skip.disabled = false; body_location_next.disabled = false; var retorno = this.responseText; var aux = retorno.split(';-;'); var enviou = aux[0]; var aviso = aux[1]; if (enviou == 1) {AvancarLocalizacao();} else {alert(aviso);}");
						}
						catch (exe)
						{
							console.log(exe.message);
						}
						
						return false;
					}
				</script>
		<?php
			}
		?>
		
		<?php
			if ($nivelCadastro < 3)
			{
		?>
				<form id="Frm_Foto" method="POST" action="<?php echo VOLTAR; ?>php/AdicionarFoto.php"  enctype="multipart/form-data">
					<div class="signup-body" id="signup_photo" <?php if ($nivelCadastro == 2) { ?> style="display: inline-block;" <?php } ?>>
						<div class="signup-data" align="left" id="data_image">
							<label id="signup_label_title">FALTA POUCO!</label><br>
							<label class="signup-label">Escolha uma foto bem bonita sua para seu perfil no <b>ANYTECH</b></label><br>
							<img src="<?php echo VOLTAR; ?>images/perfil.png" id="signup_img" class="signup-image"><br>
							<input type="button" id="signup_select_img" class="signup-image-button" value="Selecionar">
							<input type="file" name="foto" id="im_usuario" accept="image/*" style="display: none;" required>
							<div class="signup-buttons-group" align="left">
								<input type="button" value="Pular" class="anytech-cancel" id="body_photo_skip">
								<input type="submit" value="Avançar" class="anytech-next" id="body_photo_next">
							</div>
						</div>
					</div>
				</form>
				
				<script>
					signup_select_img.onclick = function()
					{
						im_usuario.value = "";
						im_usuario.click();
					}
					
					im_usuario.onchange = function()
					{
						if (this.value != "")
						{
							if (this.files && this.files[0]) 
							{
								var reader = new FileReader();

								reader.onload = function (e) 
								{
									signup_img.src = e.target.result;
								}

								reader.readAsDataURL(this.files[0]);
							}
						}
						else
						{
							signup_img.src = '<?php echo VOLTAR; ?>images/perfil.png';
						}
					}
					
					Frm_Foto.onsubmit = function()
					{
						try
						{
							if (im_usuario.value != "")
							{
								AjaxForm(this, "document.body.style.cursor = 'progress'; body_photo_next.disabled = true; body_photo_skip.disabled = true", "document.body.style.cursor = 'auto'; body_photo_next.disabled = false; body_photo_skip.disabled = false; var retorno = this.responseText; var aux = retorno.split(';-;'); var enviou = aux[0]; var aviso = aux[1]; if (enviou == 1) {AvancarFoto();} else {alert(aviso)};");
							}
						}
						catch (exe)
						{
							console.log(exe.message);
						}
						
						return false;
					}
					
					function AvancarFoto()
					{
						Ajax("GET", "<?php echo VOLTAR; ?>php/AvancarNivelCadastro.php", "", "$('#signup_photo').fadeOut('slide'); $('#signup_favorites').fadeIn('slide');	");
					}
					
					signup_img.onmouseover = function()
					{
						signup_select_img.style.display = "inline-block";
						indexover = 1;
					}
					
					signup_img.onmouseout = function()
					{
						signup_select_img.style.display = "none";
						indexover = 0;
					}
					
					signup_select_img.onmouseover = function()
					{
						signup_select_img.style.display = "inline-block";
						indexover = 1;
					}
					
					signup_select_img.onmouseout = function()
					{
						if(indexover == 1)
						{
							signup_select_img.style.display = "none";
							indexover = 0;
						}
						
					}
					
					body_photo_skip.onclick = function()
					{
						AvancarFoto();		
					}
				</script>
		<?php
			}
		?>
		
		<?php
			if ($nivelCadastro < 4)
			{
		?>
				<style>
					.anytech-favorite-button.ativo
					{
						background-color: White;
						color: black;
						font-weight: bold;
					}
				</style>
				<form id="Frm_Favoritos" method="POST" action="<?php echo VOLTAR; ?>php/AdicionarTemasFavoritos.php">
					<div class="signup-body" id="signup_favorites" <?php if ($nivelCadastro == 3) { ?> style="display: inline-block;" <?php } ?>>			
						<div class="signup-data" align="left" id="data_location">			
							<label id="signup_label_title">AGORA VEM A PARTE LEGAL</label><br>
							<label class="signup-label">Selecione seus temas favoritos dentro do <b>ANYTECH</b></label><br>
							<br>
							<input type="hidden" name="codigosTemas" id="txt_codigosFavoritos" value="" required/>
							<div class="into-fav">
								<?php
									$result_Temas = $conexaoPrincipal -> Query("select cd_tema, nm_tema from tb_tema where ic_linguagem_programacao = 1");
									$linha_Temas = mysqli_fetch_assoc($result_Temas);
									$total_Temas = mysqli_num_rows($result_Temas);
									
									if ($total_Temas > 0)
									{
										do
										{
								?>
											<input type="button" value="<?php echo $linha_Temas['nm_tema']; ?>" codigoTema="<?php echo $linha_Temas['cd_tema']; ?>" class="anytech-favorite-button" onclick="if (this.classList.contains('ativo') == false) {$(this).addClass('ativo');} else {$(this).removeClass('ativo');}"/>
								<?php
										}
										while ($linha_Temas = mysqli_fetch_assoc($result_Temas));
									}
								?>
							</div>
							<div class="signup-buttons-group" align="left">
								<input type="button" value="Pular" class="anytech-cancel" id="body_favorites_skip">
								<input type="submit" value="Avançar" class="anytech-next" id="body_favorites_next">
							</div>
						</div>			
					</div>
				</form>
				
				<script>
					function AvancarFavoritos()
					{
						Ajax("GET", "<?php echo VOLTAR; ?>php/AvancarNivelCadastro.php", "", "window.location.reload();");
					}
					
					function Mapear()
					{
						var botoes = document.getElementsByClassName('ativo');
						
						txt_codigosFavoritos.value = '';
						
						for (cont = 0; cont <= botoes.length - 1; cont = cont + 1)
						{
							if (cont == botoes.length - 1)
							{
								txt_codigosFavoritos.value = txt_codigosFavoritos.value + botoes[cont].getAttribute('codigoTema');
							}
							else
							{
								txt_codigosFavoritos.value = txt_codigosFavoritos.value + botoes[cont].getAttribute('codigoTema') + ';';
							}
						}
					}
					
					Frm_Favoritos.onsubmit = function()
					{
						try
						{
							AjaxForm(this, "document.body.style.cursor = 'progress'; body_favorites_next.disabled = true; body_favorites_skip.disabled = true", "document.body.style.cursor = 'auto'; var retorno = this.responseText; var aux = retorno.split(';-;'); var enviou = aux[0]; var aviso = aux[1]; if (enviou == 1) {AvancarFavoritos();} else {alert(aviso); body_favorites_next.disabled = false; body_favorites_skip.disabled = false;}");
						}
						catch (exe)
						{
							console.log(exe.message);
						}
						
						return false;
					}
				
					body_favorites_next.onclick = function()
					{
						Mapear();
					}
					
					body_favorites_skip.onclick = function()
					{
						
					}
				</script>
		<?php
			}
		?>
	</body>
	<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>
	<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
	<script>
		window.onload = function()
		{
			indexover = 0;
		}
	</script>
</html>