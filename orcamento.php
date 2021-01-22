<?php
	session_start();
	define('VOLTAR', '');
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;
		$cod_usuario = "null";
		$linha_Usuario['nm_usuario_completo'] = "";
		$linha_Usuario['nm_email'] = "";
	}
	else
	{
		$logado = 1;
		
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
			
		$result_Usuario = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, im_perfil, cd_nivel_cadastro from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
		
		$nomeUsuario = $linha_Usuario['nm_usuario_completo'];
		$imagemUsuario = $linha_Usuario['im_perfil'];
		$nivelCadastro = $linha_Usuario['cd_nivel_cadastro'];

		if ($nivelCadastro < 4)
		{
			header('Location: '.VOLTAR.'signup/');
		}
	}
	
	if (isset($_COOKIE['AnyTech']['codigoOrcamento']))
	{
		$cookie = 1;
		$codigoOrcamento = $_COOKIE['AnyTech']['codigoOrcamento'];
		$etapaOrcamento = $_COOKIE['AnyTech']['etapaOrcamento'];
		
		$result_Orcamento = $conexaoPrincipal -> Query("select cd_orcamento, nm_usuario, nm_projeto_empresa, ds_orcamento,nm_email from tb_orcamento where cd_orcamento = '$codigoOrcamento'");
		$linha_Orcamento = mysqli_fetch_assoc($result_Orcamento);
	}
	else
	{
		$cookie = 0;
	}
	
	$etapa = 1;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta name="description" content="A Anytech desenvolve sistemas e soluções inteligentes para o você. O melhor em criação de websites, softwares e muitos outros serviços. Conheça a Biblioteca Anytech, que lhe fornece diversos materiais de pesquisa e estudo sobre programação de computadores.">
		<meta name="keywords" content="biblioteca, programação, site, website, software, criar, comprar, template, desenvolvimento, pesquisa, linguagens de programação, estudo, anytech, eletrontech, santos, são paulo, sp, baixada santista"/>
		<meta name="robots" content="index, follow">
		<meta name="googlebot" content="index, follow">
		<meta name="author" content="AnyTech">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" type="image/png" href="images/logoico.png" alt="ANYTECH"/>
		<link rel="stylesheet" type="text/css" href="css/anytech-style-index.css">
		<link rel="stylesheet" type="text/css" href="css/anytech-style-topbar.css">
		<link rel="stylesheet" type="text/css" href="css/anytech-style-orc.css">
		<title>ANYTECH - Vamos fazer o orçamento do seu site agora mesmo!</title>
	</head>
	<body>
		<?php
			if ($logado == 1)
			{
				include 'topbar-on.php';
				include 'menu.php';
			}
			else
			{
				include 'topbar-index.php';
			}			
		?>
		<div class="anytech-background-index">			
			<div class="cover-image" id="at_bx1" style="background-image: url('images/orc/t1.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Vamos fazer o orçamento do<br> seu site agora mesmo!</label>
							<?php
								if ($cookie == 1)
								{
							?>
									<input type="text" tipo="NomeCompleto" placeholder="Digite seu nome" name="nomeUsuario" class="anytech-orc-input at-valida" value="<?php echo $linha_Orcamento['nm_usuario']; ?>" required/>
							<?php
								}
								else
								{
							?>
									<input type="text" tipo="NomeCompleto" placeholder="Digite seu nome" name="nomeUsuario" class="anytech-orc-input at-valida" required/>
							<?php
								}
							?>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>		
			
			<div class="cover-image" id="at_bx2" style="background-image: url('images/orc/t2.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Você já possui um site?</label>
							
							<table width="50%" id="table_bx2">
								<?php
									if ($cookie == 0)
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico, ds_servico from tb_servico where cd_etapa = 2");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="radio" class="anytech-orc-checkbox" name="opcaoEtapa" value="<?php echo $linha_Etapas['cd_servico']; ?>" required/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
									else
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico,
																						   ds_servico,
																						   (select 1 from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = tb_servico.cd_servico) as ic_optou
																					  from tb_servico
																						where cd_etapa = 2");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="radio" class="anytech-orc-checkbox" name="opcaoEtapa" value="<?php echo $linha_Etapas['cd_servico']; ?>" <?php if ($linha_Etapas['ic_optou'] == 1) {echo 'checked=true';} ?> required/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
								?>
							</table>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>	
			
			<div class="cover-image" id="at_bx3" style="background-image: url('images/orc/t3.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Você ou sua empresa <br>já possui uma logomarca?</label>
							<table width="50%" id="table_bx2">
								<?php
									if ($cookie == 0)
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico, ds_servico from tb_servico where cd_etapa = 3");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="radio" class="anytech-orc-checkbox" name="opcaoEtapa" value="<?php echo $linha_Etapas['cd_servico']; ?>" required/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
									else
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico,
																						   ds_servico,
																						   (select 1 from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = tb_servico.cd_servico) as ic_optou
																					  from tb_servico
																						where cd_etapa = 3");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="radio" class="anytech-orc-checkbox" name="opcaoEtapa" value="<?php echo $linha_Etapas['cd_servico']; ?>" <?php if ($linha_Etapas['ic_optou'] == 1) {echo 'checked=true';} ?> required/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
								?>
							</table>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>	
			
			<div class="cover-image" id="at_bx4" style="background-image: url('images/orc/t4.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Qual será o ramo de negócio <br>abrangido no seu site?</label>
							<select class="anytech-orc-input" name="opcaoEtapa" required>
								<option value="">Selecione um ramo</option>
								<?php
									if ($cookie == 0)
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico, ds_servico from tb_servico where cd_etapa = 4");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<option value="<?php echo $linha_Etapas['cd_servico']; ?>"><?php echo $linha_Etapas['ds_servico']; ?></option>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
									else
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico,
																						   ds_servico,
																						   (select 1 from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = tb_servico.cd_servico) as ic_optou
																					  from tb_servico
																						where cd_etapa = 4");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<option value="<?php echo $linha_Etapas['cd_servico']; ?>" <?php if ($linha_Etapas['ic_optou'] == 1) {echo 'selected=true';} ?>><?php echo $linha_Etapas['ds_servico']; ?></option>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
								?>
							</select>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>	
			
			<div class="cover-image" id="at_bx5" style="background-image: url('images/orc/t5.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Qual dessas categorias se <br> encaixa melhor ao seu projeto?</label>
							<select class="anytech-orc-input" name="opcaoEtapa" required>
								<option value="">Selecione uma categoria</option>
								<?php
									if ($cookie == 0)
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico, ds_servico from tb_servico where cd_etapa = 5");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<option value="<?php echo $linha_Etapas['cd_servico']; ?>"><?php echo $linha_Etapas['ds_servico']; ?></option>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
									else
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico,
																						   ds_servico,
																						   (select 1 from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = tb_servico.cd_servico) as ic_optou
																					  from tb_servico
																						where cd_etapa = 5");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<option value="<?php echo $linha_Etapas['cd_servico']; ?>" <?php if ($linha_Etapas['ic_optou'] == 1) {echo 'selected=true';} ?>><?php echo $linha_Etapas['ds_servico']; ?></option>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
								?>
							</select>							
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>	
			
			<div class="cover-image" id="at_bx6" style="background-image: url('images/orc/t6.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Qual o nome do seu projeto ou empresa?</label>
							<?php
								if ($cookie == 0)
								{
							?>
									<input type="text" tipo="Nome"name="nomeProjetoEmpresa" placeholder="Digite o nome do seu projeto ou empresa" class="anytech-orc-input at-valida" required/>
							<?php
								}
								else
								{
							?>
									<input type="text" tipo="NomeCompleto" name="nomeProjetoEmpresa" placeholder="Digite o nome do seu projeto ou empresa" class="anytech-orc-input at-valida" value="<?php echo $linha_Orcamento['nm_projeto_empresa']; ?>" required/>
							<?php
								}
							?>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>	
			
			<div class="cover-image" id="at_bx7" style="background-image: url('images/orc/t7.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win at-rec-20" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Você deseja que o seu site seja responsivo, ou seja, que se adapta a computadores, tablets e smartphones automaticamente?</label>
							<table width="50%" id="table_bx2">
								<?php
									if ($cookie == 0)
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico, ds_servico from tb_servico where cd_etapa = 7");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="radio" class="anytech-orc-checkbox" name="opcaoEtapa" value="<?php echo $linha_Etapas['cd_servico']; ?>" required/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
									else
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico,
																						   ds_servico,
																						   (select 1 from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = tb_servico.cd_servico) as ic_optou
																					  from tb_servico
																						where cd_etapa = 7");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="radio" class="anytech-orc-checkbox" name="opcaoEtapa" value="<?php echo $linha_Etapas['cd_servico']; ?>" <?php if ($linha_Etapas['ic_optou'] == 1) {echo 'checked=true';} ?> required/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
								?>
							</table>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>
			
			<div class="cover-image" id="at_bx8" style="background-image: url('images/orc/t8.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win at-rec-20" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Quais dessas ferramentas você deseja incluir no seu site?</label>
							<table width="50%" id="table_bx2">
								<?php
									if ($cookie == 0)
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico, ds_servico from tb_servico where cd_etapa = 8");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="checkbox" class="anytech-orc-checkbox" name="opcaoEtapa[]" value="<?php echo $linha_Etapas['cd_servico']; ?>"/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
									else
									{
										$result_Etapas = $conexaoPrincipal -> Query("select cd_servico,
																						   ds_servico,
																						   (select 1 from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = tb_servico.cd_servico) as ic_optou
																					  from tb_servico
																						where cd_etapa = 8");
										$linha_Etapas = mysqli_fetch_assoc($result_Etapas);
										$total_Etapas = mysqli_num_rows($result_Etapas);
										
										if ($total_Etapas > 0)
										{
											do
											{
								?>
												<tr>
													<td valign="center" width="auto">
														<input type="checkbox" class="anytech-orc-checkbox" name="opcaoEtapa[]" value="<?php echo $linha_Etapas['cd_servico']; ?>" <?php if ($linha_Etapas['ic_optou'] == 1) {echo 'checked=true';} ?>/>
													</td>
													<td valign="center" width="100%">
														<label class="anytech-orc-label"><?php echo $linha_Etapas['ds_servico']; ?></label>
													</td>
												</tr>
								<?php
											}
											while ($linha_Etapas = mysqli_fetch_assoc($result_Etapas));
										}
									}
								?>
							</table>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>	
			
			<div class="cover-image" id="at_bx9" style="background-image: url('images/orc/t9.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win at-rec-20" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Descreva em suas palavras como você deseja que seja o seu site.</label><br><br>
							<?php
								if ($cookie == 1)
								{
							?>
									<textarea id="txt_descricaoProjeto" placeholder="Opcional" name="descricaoProjeto" class="anytech-orc-textarea" data-autoresize rows="3" maxLength="500"><?php echo trim(htmlentities($linha_Orcamento['ds_orcamento'], ENT_QUOTES, 'UTF-8')); ?></textarea>
							<?php
								}
								else
								{
							?>
									<textarea id="txt_descricaoProjeto" placeholder="Opcional" name="descricaoProjeto" class="anytech-orc-textarea" data-autoresize rows="3" maxLength="500"></textarea>
							<?php
								}
							?>
							<input id="lbl_caracteresRestantes" class="anytech-count" value="500 caracteres restantes" readonly>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
						<script>
							function CaracteresRestantes(valorCampo, limite)
							{
								var aux = limite - valorCampo.length;
								
								aux = aux + " caractere" + ((aux != 1 || aux != -1) ? 's' : '') + " restante" + ((aux != 1 || aux != -1) ? 's' : '');
								
								return aux;
							}
							
							txt_descricaoProjeto.onkeypress = function()
							{
								this.maxLength = 500;
								
								lbl_caracteresRestantes.value = CaracteresRestantes(this.value, this.maxLength);
							}
							
							txt_descricaoProjeto.onkeyup = function()
							{
								this.maxLength = 500;
								
								lbl_caracteresRestantes.value = CaracteresRestantes(this.value, this.maxLength);
							}
							
							lbl_caracteresRestantes.value = CaracteresRestantes(txt_descricaoProjeto.value, txt_descricaoProjeto.maxLength);
						</script>
					</div>
				</div>
			</div>
			
			<div class="cover-image" id="at_bx10" style="background-image: url('images/orc/t10.jpg');">
				<div class="orc-cover">
					<div class="anytech-orc-win at-rec-20" align="center">
						<form id="Frm_Etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" method="POST" action="php/EtapaOrcamento.php">
							<label class="anytech-index-message-label">Desejamos muito poder ajudar você<br>no desenvolvimento do seu site.</label><br><br>
							
							<label class="anytech-index-message-label at-legend-pre">Para finalizar o seu orçamento, insira seu e-mail, para que possamos entrar em contato com você.</label>
							<?php
								if ($cookie == 1)
								{
							?>
									<input type="text" tipo="E-mail"placeholder="Digite seu e-mail" name="email" class="anytech-orc-input at-valida" value="<?php echo $linha_Orcamento['nm_email']; ?>" required/>
							<?php
								}
								else
								{
							?>
									<input type="text" tipo="E-mail"placeholder="Digite seu e-mail" name="email" class="anytech-orc-input at-valida" required/>
							<?php
								}
							?>
							<input type="submit" id="btn_etapa<?php echo (($etapa < 10) ? '0' : '').$etapa; ?>" style="display: none;"/>
							<input type="hidden" name="etapaOrcamento" value="<?php echo $etapa; ?>"/>
							<?php $etapa = $etapa + 1; ?>
						</form>
					</div>
				</div>
			</div>
			
		</div>
		<div class="anytech-bottom-div">
			<table width="100%">
				<tr  align="center">
					<td width="33%"  valign="center">
						<input type="button" id="btn_voltar" value="Voltar" class="anytech-control-button-orc" style="display: none;" onclick="Voltar(VerificarEtapa());"/>
					</td>	
					<td width="33%">
						<input type="button" id="btn_iniciar" value="Iniciar" class="anytech-control-button-orc" onclick="Iniciar();">
					</td>
					<td width="33%">
						<input type="button" id="btn_avancar" value="Avançar" class="anytech-control-button-orc" style="display: none;" onclick="Avancar(VerificarEtapa());"/>
					</td>
				</tr>
			</table>
		</div>
	</body>
	<script src="js/ajax.js"></script>
	<script src="js/AnyTech - Validação.js"></script>
	<script>
		window.onload = function()
		{
			MapearForms();
			
			<?php
				if (isset($_COOKIE['AnyTech']['codigoOrcamento']))
				{
			?>
					if (confirm("Existe um orçamento não finalizado, deseja continua-lo?"))
					{
						etapas = document.getElementsByClassName('cover-image');
			
						for (cont = 0; cont <= etapas.length - 1; cont = cont + 1)
						{
							etapas[cont].style.display = 'none';
						}
						
						etapas[<?php echo $_COOKIE['AnyTech']['etapaOrcamento']; ?> - 1].style.display = 'inline-block';
						
						btn_iniciar.style.display = 'none';
						btn_avancar.style.display = 'inline-block';
						btn_voltar.style.display = 'inline-block';
					}
					else
					{
						Ajax("GET", "<?php echo VOLTAR; ?>php/LimparOrcamento.php", "", "window.location.reload();");
					}
			<?php
				}
				else
				{
			?>
					etapas = document.getElementsByClassName('cover-image');

					for (cont = 0; cont <= etapas.length - 1; cont = cont + 1)
					{
						etapas[cont].style.display = 'none';
					}
					
					etapas[0].style.display = 'inline-block';
			<?php
				}
			?>
			
			var aux = VerificarEtapa();
			
			if (aux == etapas.length - 1)
			{
				btn_avancar.style.display = 'none';
				btn_iniciar.style.display = 'inline-block';
				btn_iniciar.value = 'Finalizar';
			}
		}
		
		function VerificarEtapa()
		{
			var etapa;
			etapas = document.getElementsByClassName('cover-image');
			
			for (cont = 0; cont <= etapas.length - 1; cont = cont + 1)
			{
				if (etapas[cont].style.display == 'inline-block')
				{
					etapa = cont;
					break;
				}
			}
			
			return etapa;
		}
		
		function Iniciar()
		{
			if (btn_iniciar.value == 'Iniciar')
			{
				btn_etapa01.click();
			}
			else if (btn_iniciar.value == 'Finalizar')
			{
				Avancar(VerificarEtapa());
			}
		}
		
		function Avancar(etapa)
		{
			<?php
				for ($cont = 1; $cont <= $etapa - 1; $cont = $cont + 1)
				{
					if ($cont == 1)
					{
			?>
						if (etapa + 1 == <?php echo $cont; ?>)
						{
							btn_etapa<?php echo (($cont < 10) ? '0' : '').$cont; ?>.click();
						}
			<?php
					}
					else
					{
			?>
						else if (etapa + 1 == <?php echo $cont; ?>)
						{
							btn_etapa<?php echo (($cont < 10) ? '0' : '').$cont; ?>.click();
						}
			<?php
					}
				}
			?>
		}
		
		function Voltar(etapa)
		{
			etapas[etapa].style.display = 'none';
			etapas[etapa - 1].style.display = 'inline-block';
			
			btn_iniciar.style.display = 'none';
			btn_avancar.style.display = 'inline-block';
			btn_voltar.style.display = 'inline-block';
			
			if (etapa - 1 == 0)
			{
				btn_voltar.style.display = 'none';
			}
		}
	</script>
	<script>
		<?php
			for ($cont = 1; $cont <= $etapa - 1; $cont = $cont + 1)
			{
				if ($cont == $etapa - 2)
				{
		?>
					Frm_Etapa<?php echo (($cont < 10) ? '0' : '').$cont; ?>.onsubmit = function()
					{
						AjaxForm(this, "btn_iniciar.disabled = true; btn_avancar.disabled = true; btn_voltar.disabled = true;", "btn_iniciar.disabled = false; btn_avancar.disabled = false; btn_voltar.disabled = false; var retorno = this.responseText; if (retorno.split(';-;')[0].trim() == 1) {btn_iniciar.style.display = 'none'; aux = VerificarEtapa(); etapas[aux].style.display = 'none'; etapas[aux + 1].style.display = 'inline-block'; btn_avancar.style.display = 'none'; btn_iniciar.style.display = 'inline-block'; btn_iniciar.value = 'Finalizar'; btn_voltar.style.display = 'inline-block';}");
						
						return false;
					}
		<?php
				}
				else if ($cont == $etapa - 1)
				{
		?>
					Frm_Etapa<?php echo (($cont < 10) ? '0' : '').$cont; ?>.onsubmit = function()
					{
						AjaxForm(this, "btn_iniciar.disabled = true; btn_avancar.disabled = true; btn_voltar.disabled = true;", "btn_iniciar.disabled = false; btn_avancar.disabled = false; btn_voltar.disabled = false; var retorno = this.responseText; var valor = retorno.split(';-;')[1].trim(); valor = parseFloat(valor); if (retorno.split(';-;')[0].trim() == 1) {alert('Orçamento finalizado com sucesso!\\n\\nValor do orçamento: R$ ' + valor.toFixed(2)); window.location.reload();}");
						
						return false;
					}
		<?php
				}
				else
				{
		?>
					Frm_Etapa<?php echo (($cont < 10) ? '0' : '').$cont; ?>.onsubmit = function()
					{
						AjaxForm(this, "btn_iniciar.disabled = true; btn_avancar.disabled = true; btn_voltar.disabled = true;", "btn_iniciar.disabled = false; btn_avancar.disabled = false; btn_voltar.disabled = false; var retorno = this.responseText; if (retorno.split(';-;')[0].trim() == 1) {btn_iniciar.style.display = 'none'; aux = VerificarEtapa(); etapas[aux].style.display = 'none'; etapas[aux + 1].style.display = 'inline-block'; btn_iniciar.style.display = 'none'; btn_avancar.style.display = 'inline-block'; btn_voltar.style.display = 'inline-block';}");
						
						return false;
					}

		<?php
				}
			}
		?>
	</script>
</html>

<?php
	$conexaoPrincipal -> FecharConexao();
?>