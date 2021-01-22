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
	
	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png"/>
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-signup.css">
		<title>ANYTECH</title>
		<style>
		
			body
			{
				background-color: #222;
			}
			
			iframe
			{
				display: inline-block;				
				position: absolute;
				top:50%;
				left: 50%;
				margin-left: -280px;
				margin-top: -180px;
				box-shadow: 0px 1px 3px rgba(0,0,0,0.3);
			}
			
			#legend
			{
				position: absolute;
				width: 100%;
				top: 100px;
				text-align: center;
				margin: 0px;
				padding: 0px;
				color: white;
			}
			
			#tablered
			{
				position: absolute;
				width: 100%;
				bottom: 35px;
			}
			
			.anytech-index-button
			{
				display: inline-block;
				height: 40px;
				margin: 5px;
				padding: 10px;
				padding-left:25px;
				padding-right:25px;
				font-size: 0.8em;
				box-shadow: 0px 1px 3px rgba(0,0,0,0.3);
			}

			
			#button-inst
			{
				display: inline-block;
				background-color: blue;
				color: #fff;
			}

			#button-inst:hover
			{
				background-color: #086fff;
				cursor: pointer;
			}

			#button-feed
			{
				display: inline-block;
				background-color: #fff;
				color: #d42203;
			}

			#button-feed:hover
			{
				background-color: #d42203;
				cursor: pointer;
				color: white;
			}

		</style>
	</head>
	<body>
		<div class="anytech-bar">
			<img src="<?php echo VOLTAR; ?>images/logohome.png" id="anytech_logo_image">
			<label class="signup-label-topbar">Olá, <?php echo $primeiroNome; ?>!</label>
		</div>
		<label class="signup-label-topbar" id="legend">Veja o que <b>você</b> terá em breve aqui no <b>ANYTECH</b>!</label>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/c2ivaxlmKxw" frameborder="0" allowfullscreen></iframe>	
	
		<table align="center" id="tablered">
			<tr  align="center">
				<td width="50%" align="center">
					<input type="button" value="Saiba Mais Sobre Nós" class="anytech-index-button" id="button-inst" onclick="location.href='../institucional.php';">
				
					<input type="button" value="Sair" class="anytech-index-button" id="button-feed" onclick="location.href='../php/Logout.php';">
				</td>
			</tr>
		</table>
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