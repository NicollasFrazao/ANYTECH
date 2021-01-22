<?php
	session_start();
	define('VOLTAR', '../');
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$_SESSION['AnyTech']['verifica'] = 0;
		$_SESSION['AnyTech']['statusBloqueado'] = "neutro";
		
		$logado = 0;
	}
	else
	{
		$logado = 1;
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
		<meta name="description" content="A Anytech desenvolve sistemas e soluções inteligentes para o você. O melhor em criação de websites, softwares e muitos outros serviços. Conheça a Biblioteca Anytech, que lhe fornece diversos materiais de pesquisa e estudo sobre programação de computadores.">
		<meta name="keywords" content="biblioteca, programação, site, website, software, criar, comprar, template, desenvolvimento, pesquisa, linguagens de programação, estudo, anytech, eletrontech, santos, são paulo, sp, baixada santista"/>
		<meta name="robots" content="index, follow">
		<meta name="googlebot" content="index, follow">
		<meta name="author" content="AnyTech">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" type="image/png" href="../images/logoico.png" alt="ANYTECH"/>
		<link rel="stylesheet" type="text/css" href="../css/anytech-style-index.css">
		<title>ANYTECH - Login</title>
	</head>
	<body>
		<div class="anytech-bar">
			<img src="../images/logohome.png" id="anytech_logo_image" alt="ANYTECH" onclick="window.location.href = '<?php echo VOLTAR; ?>';">
		</div>
		
		<div class="anytech-cover">
			<div class="anytech-popup-recover">
				<a class="anytech-titles" id="anytech_popup_title" align="center">POR QUE NÃO CONSEGUE ACESSAR SUA CONTA?</a>
				<table width="100%" id="anytech_table_recover">
					<tr width="100%" height="50px">
						<td valign="center">
							<input type="radio" name="recoveryAccount" class="anytech-checkbox" value="1">
						</td>
						<td width="100%" valign="center">
							<label id="anytech_recover_label">Esqueci meu e-mail.</label>
						</td>
					</tr>
					<tr width="100%" height="50px">
						<td valign="center">
							<input type="radio" name="recoveryAccount" class="anytech-checkbox" value="2">
						</td>
						<td width="100%" valign="center">
							<label id="anytech_recover_label">Esqueci minha senha.</label>
						</td>
					</tr>
					<tr width="100%" height="50px">
						<td valign="center">
							<input type="radio" name="recoveryAccount" class="anytech-checkbox" value="3">
						</td>
						<td width="100%" valign="center">
							<label id="anytech_recover_label">Não tenho mais acesso a minha conta de e-mail.</label>
						</td>
					</tr>
				</table>
				<div class="anytech-popup-buttons">
					<input type="button" value="Cancelar" class="anytech-cancel" onclick="anytech_recovery_off()">
					<input type="button" value="Avançar" class="anytech-next" onclick="verifyRec(2)">
				</div>
			</div>
			
			<div class="anytech-popup-password">
				<label class="anytech-titles" id="anytech_popup_title">Insira o seu e-mail de acesso</label>
				<div class="anytech-popup-buttons">
					<input type="text" class="anytech-input" id="anytech_input_access" placeholder="exemplo@anytech.com.br"><br><br>
					<input type="button" value="Voltar" class="anytech-cancel" onclick="recuperarSenhaOut()">
					<input type="button" value="Enviar" class="anytech-next" onclick="mailSender()">
					<script>
						function mailSender()
						{
							atSend = anytech_input_access.value;
							Ajax("POST", "../php/RecuperarSenha.php", "email=" + atSend, "var retorna = this.responseText; if(retorna == 0){mailSenderMessage.innerHTML = 'E-mail não encontrado!'; mailSenderMessage.style.color = 'red';}else{mailSenderMessage.innerHTML = 'E-mail para recuperação de conta enviado com sucesso!'; mailSenderMessage.style.color = '#05ff23';}");
							
						}
					</script>
					<label class="anytech-label-rec-red" id="mailSenderMessage"></label><br><br>
					<label id="anytech_recover_label" class="anytech-label-rec">Caso tenha outros problemas para acessar sua conta, entre em contato pelo e-mail <b>suporte@anytech.com.br</b></label><br>
				</div>
			</div>
			
			<div class="anytech-popup-mail-true">
				<label class="anytech-titles" id="anytech_popup_title">FALTA POUCO...</label>
				<div class="anytech-popup-buttons">
					<label id="anytech_recover_label" class="anytech-label-rec">Enviamos um link de recuperação de conta. Para retomar sua conta no <b>ANYTECH.COM.BR</b>, acesse seu e-mail e utilize o código de recuperação. O código de recuperação enviado é valido durante o período de duas horas. Caso não receba este e-mail, realize o processo de recuperação novamente.</label><br>
					<input type="button" value="Finalizar" class="anytech-next">
				</div>
			</div>
			
			<div class="anytech-popup-mailer" style="display: none">
				<label class="anytech-titles" id="anytech_popup_title">Insira o seu nickname</label>
				<div class="anytech-popup-buttons">
					<input type="text" class="anytech-input" id="anytech_input_accesss"><br><br>
					<input type="button" value="Voltar" class="anytech-cancel" onclick="anytech_mailer_off()">
					<input type="button" value="Enviar" class="anytech-next">					
					<label class="anytech-label-rec-red" id="mailValue"></label><br><br>
					<label id="anytech_recover_label" class="anytech-label-rec">Caso tenha outros problemas para acessar sua conta, entre em contato pelo e-mail <b>suporte@anytech.com.br</b></label><br>
				</div>
			</div>
		</div>
		
		<?php include 'form-login.php'; ?>
		
	<script>
		window.onload = function()
		{
			MapearForms();
		}
		
		function anytech_recovery_on()
		{
			$('.anytech-cover').fadeIn('slide');
			setTimeout("$('.anytech-popup-recover').fadeIn('slide');",500);
		}
		
		function anytech_recovery_off()
		{
			$('.anytech-popup-recover').fadeOut('slide');
			setTimeout("$('.anytech-cover').fadeOut('slide');",100);
		}
				
		function anytech_password_on()
		{
			$('.anytech-popup-recover').fadeOut('slide');
			setTimeout("$('.anytech-popup-password').fadeIn('slide');",500);
		}
		
		function anytech_password_off()
		{
			$('.anytech-popup-password').fadeOut('slide');
			setTimeout("$('.anytech-popup-recover').fadeIn('slide');",500);
		}
		
		function anytech_mailer_on()
		{
			$('.anytech-popup-recover').fadeOut('slide');
			setTimeout("$('.anytech-popup-mailer').fadeIn('slide');",500);
		}
		
		function anytech_mailer_off()
		{
			$('.anytech-popup-mailer').fadeOut('slide');
			setTimeout("$('.anytech-popup-recover').fadeIn('slide');",500);
		}
		
		function verifyRec()
		{
			
			valueRec = document.querySelector('input[name="recoveryAccount"]:checked').value;
			if(valueRec == 1)
			{
				anytech_mailer_on();
			}
			if(valueRec == 2)
			{
				anytech_password_on();
			}
		}
		
		function recuperarSenhaOn()
		{
			$('.anytech-cover').fadeIn('slide');
			setTimeout("$('.anytech-popup-password').fadeIn('slide');",500);
		}
		
		function recuperarSenhaOut()
		{
			$('.anytech-popup-password').fadeOut('slide');
			setTimeout("$('.anytech-cover').fadeOut('slide');",500);			
		}
	</script>
</html>