<script src="<?php echo VOLTAR; ?>js/AnyTech - Validação.js"></script>
<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>

<div class="anytech-sections" id="anytech_signup">
	<form id="Frm_Cadastro" method="POST" action="<?php echo VOLTAR; ?>php/Cadastro.php" onkeypress="if (event.keyCode == 13) {btn_cadastrar.click();}">
		<div id="anytech_signup_form" align="center">
			<label class="anytech-titles" id="wtnin" align="center">CADASTRE-SE JÁ</label>
			<div id="coverlog">
				<label class="anytech-notify" id="notificacao_cadastro">Cadastro efetuado com sucesso!</label>
			</div>
			<table width="100%">
				<tr>
					<td colspan="2"> 
						<input type="text" name="nome" placeholder="Nome Completo" class="anytech-signup-input at-valida" tipo="NomeCompleto" required/>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input type="text" name="email" placeholder="E-mail" class="anytech-signup-input at-valida" tipo="E-mail" required/>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="text" name="datanas" placeholder="Data de Nascimento" class="anytech-signup-input-doub at-valida" tipo="Datanas" required>
					</td>
					
					<td>
						<select name="sexo" type="text" placeholder="Sexo" class="anytech-signup-input-select at-valida" tipo="ComboBox" required>
							<option class="option-standard" value="">Selecione Seu Sexo</option>
							<option value="Feminino">Feminino</option>
							<option value="Masculino">Masculino</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"> 
						<input type="text"  name="nickname" placeholder="Nickname" class="anytech-signup-input at-valida" tipo="Nickname">
					</td>
				</tr>
				
				<tr>
					<td>
						<input type="password" name="senha" placeholder="Senha" class="anytech-signup-input-doub at-valida" tipo="Senha" required />
					</td>
					
					<td>
						<input type="password" placeholder="Confirmação de Senha" class="anytech-signup-input-doub-sec at-valida" tipo="ConfirmarSenha" required />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" id="btn_cadastrar" value="CADASTRAR" style="cursor: pointer;" class="anytech-signup-button">
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">
						<!--<label id="anytech_access_label" onclick="anytech_access_code_on()">Cadastrar por código de acesso</label>-->
					</td>
				</tr>
			</table>
		</div>
	</form>
	
	<script>
		// Frm_Cadastro
		
		function compSignup()
		{
			Frm_Cadastro.reset();
			window.location.reload();
		}
		
		function errorSignup()
		{
			$('#notificacao_cadastro').toggle();
			$('#coverlog').fadeOut();
		}
		
		Frm_Cadastro.onsubmit = function()
		{
			try
			{
				if (VerificarForm(this))
				{
					AjaxForm(this, "document.body.style.cursor = 'progress'; btn_cadastrar.disabled = true; Frm_Cadastro.style.cursor = 'progress';", "document.body.style.cursor = 'auto'; btn_cadastrar.disabled = false; Frm_Cadastro.style.cursor = 'auto'; var retorno = this.responseText; var aux = retorno.split(';-;'); var cadastrou = aux[0]; var aviso = aux[1]; notificacao_cadastro.textContent = aviso;  $(coverlog).fadeIn();$(notificacao_cadastro).toggle(); if (cadastrou == 1) {setTimeout('compSignup()',5000);}");
				}
				else
				{
					notificacao_cadastro.textContent = "Alguns campos estão inválidos, verifique e tente novamente!"; 
					
					
					$('#coverlog').fadeIn();
					$('#notificacao_cadastro').toggle();
					setTimeout('errorSignup()',3000);
					
				}
			}
			catch (exe)
			{
				console.log(exe.message);
			}
			
			return false;
		}
	</script>
</div>