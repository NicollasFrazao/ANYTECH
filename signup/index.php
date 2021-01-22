<?php
	session_start();
	define('VOLTAR', '../');
	include '../php/Conexao.php';
	include '../php/ConexaoPrincipal.php';
?>
<?php
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{	
	
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
				<meta name="author" content="Anytech">
				<meta name="google" content="notranslate" />
				<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png" alt="ANYTECH"/>
				<link rel="stylesheet" type="text/css" href="../css/anytech-style-index.css">
				<title>ANYTECH - Cadastro</title>
			</head>
			<body>
				<div class="anytech-bar">
					<img src="../images/logohome.png" id="anytech_logo_image" alt="ANYTECH">
					<input type="button" id="anytech_login_button" value="ENTRAR"  onclick="window.location='../login';">
				</div>
				
				<div class="anytech-cover">
					<div class="anytech-popup-access-code">
						<label class="anytech-titles" id="anytech_popup_title">ENTÃO QUER DIZER QUE VOCÊ TEM UM CÓDIGO DE ACESSO...</label>
						
						<div class="anytech-popup-buttons">
							<label id="anytech_recover_label" class="anytech-label-rec">Insira seu código de acesso</label><br>
							<input type="text" class="anytech-input" id="anytech_input_access"><br><br>
							<input type="button" value="Cancelar" class="anytech-cancel" onclick="anytech_access_code_off()">
							<input type="button" value="Avançar" class="anytech-next">
						</div>
					</div>
				</div>
				
				<?php include 'form-signup.php'; ?>
				
			</body>
			<script src="../js/jquery.min.js"></script>
			<script>
				window.onload = function()
				{
					MapearForms();
				}
			
				function anytech_access_code_on()
				{
					$('.anytech-cover').fadeIn('slide');
					setTimeout("$('.anytech-popup-access-code').fadeIn('slide');",500);
				}
				
				function anytech_access_code_off()
				{
					$('.anytech-popup-access-code').fadeOut('slide');
					setTimeout("$('.anytech-cover').fadeOut('slide');",100);
				}
				
			</script>
		</html>
<?php
	}
	else
	{
		include 'signup.php';
	}
	
	$conexaoPrincipal -> FecharConexao();
?>