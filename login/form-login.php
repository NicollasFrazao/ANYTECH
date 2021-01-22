<script src="<?php echo VOLTAR; ?>js/AnyTech - Validação.js"></script>
<script src="<?php echo VOLTAR; ?>js/ajax.js"></script>
<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>

<div class="anytech-sections" id="anytech_login">				
	<form id="Frm_Login" method="POST" action="<?php echo VOLTAR; ?>php/Login.php"  onkeypress="if (event.keyCode == 13) {btn_login.click();}">
		<div id="anytech_login_form" align="center">
			<label class="anytech-titles">ACESSE SUA CONTA</label>
			<div id="coverlog">
				<label class="anytech-notify" id="notificacao_login" style="display: none;">Email e(ou) Senha digitado(s) incorretamente.</label>
			</div>
			<input type="text" name="anytech-email" placeholder="E-mail" class="anytech-input at-valida" tipo="E-mail" required/>
			<input type="password"  name="anytech-senha" placeholder="Senha" class="anytech-input at-valida" tipo="Senha" required/>
			<input type="submit" id="btn_login" class="anytech-login-button" value="ACESSAR"/><br>
			<label id="anytech_access_label" onclick="recuperarSenhaOn()">NÃO CONSIGO ACESSAR MINHA CONTA</label><br>
			<a id="anytech_signup_label" href="<?php echo VOLTAR; ?>signup">CADASTRE-SE!</label>
		</div>
		<input type="hidden" id="ic_redireciona" value="0"/>
	</form>
	
	<script>
		url = '<?php echo ((isset($_GET['url'])) ? urldecode($_GET['url']) : ''); ?>';
		
		Frm_Login.onsubmit = function()
		{
			AjaxForm(this, "document.body.style.cursor = 'progress'; btn_login.disabled = true", "var retorno = this.responseText; var aux = retorno.split(';-;'); var logou = aux[0]; var aviso = aux[1]; notificacao_login.textContent = aviso; $(coverlog).fadeIn(); $(notificacao_login).toggle(); if (logou != 1) {btn_login.disabled = false; document.body.style.cursor = 'auto'; setTimeout('errorLogin()',3000);} else {ic_redireciona.value = 1; Login(); }");
			
			return false;
		}
		
		function errorLogin()
		{
			$('#notificacao_login').toggle();
			$('#coverlog').fadeOut();
		}
		
		function Login()
		{
			try
			{
				if (ic_redireciona.value == 1)
				{
					window.location.href = ((url == '') ? '<?php echo VOLTAR; ?>signup' : url);					
					//Ajax("GET", "userpage.php", "", "var retorno = this.responseText; var head = retorno.split('<!--HEAD--\>')[1]; var body = retorno.split('<!--BODY--\>')[1]; document.head.innerHTML = head; setTimeout(\"var aux = document.getElementsByTagName('script'); var cont; for (cont = 0; cont <= aux.length -1; cont = cont + 1) {eval(aux[cont].innerHTML);}\", 1000); document.body.innerHTML = body;");
				}
			}
			catch (exe)
			{
				console.log(exe.message);
			}
		}
	</script>
</div>