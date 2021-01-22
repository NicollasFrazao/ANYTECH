<?php
	session_start();
	define('VOLTAR', '../');
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_GET['key']))
	{
		header('Location: '.VOLTAR);
		exit;
	}
	
	$codigo = mysql_escape_string(base64_decode($_GET['key']));
	//echo $codigo;
	
	$resultSelect = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, nm_nickname, ic_conta_ativa, ic_bloqueado, ic_logado from tb_usuario where cd_usuario = '$codigo'");
	$linha = mysqli_fetch_assoc($resultSelect);
	
	if($linha['ic_bloqueado'] != 1)
	{
		if($linha['ic_conta_ativa'] != 1)
		{
			$result = $conexaoPrincipal -> Query("update tb_usuario set ic_conta_ativa = '1' where cd_usuario = '$codigo'");
			
			$para = $linha['nm_email'];
			$assunto = "Confirmação de cadastro";
			$nomeCompleto = $linha['nm_usuario_completo'];
			$nickname = $linha['nm_nickname'];
			$arrayNome = explode(' ',$nomeCompleto);
			$nomeUsuario = $arrayNome[0];
			echo $nomecompleto;
			$deNome = "ANYTECH - Suporte";
			$deEmail = "suporte@anytech.com.br";
			$senha = "Com.Sup.All";
			$reply = "suporte@anytech.com.br";
			
			//CORPO DO E-MAIL
			$mensagem = '<!doctype HTML>
			<html>
				</head>
					<meta charset="utf-8">
					<style>
						*
						{
							margin: 0px;
							padding: 0px;
							font-family: century gothic;
						}				
					</style>
				</head>
				<body style="background-color: #fafafa;">
					<img src="http://anytech.com.br/email/imagens/emailtopo.png" style="width:100%">
					<label class="at-saudacao" style="display: inline-block;width: 90%;color: #333;font-size: 1em;margin-top: 50px;padding-left: 5%;padding-right: 5%;">Olá, <b>'.$nomeUsuario.'!</b></label> 
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Parabéns! Sua conta no ANTECH foi ativada com sucesso! Agora você pode aproveitar todos os nossos conteúdos, serviços e outros recursos. Abaixo estão os dados do seu perfil.</label>
					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Nome: </b>'.$nomeCompleto.'</label><br>
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Nickname: </b>'.$nickname.'</label><br>
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>E-mail: </b>'.$para.'</label><br>
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Senha: </b>**********</label><br>
					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Para mais informações ou resolução de problemas de acesso em sua conta, entre em contato pelo e-mail <b>suporte@anytech.com.br</b></label>
					<label class="at-signature" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;font-weight: bold;color: #333;">A equipe ANYTECH agradece!</label>
					<img onclick="window.open(\'http://anytech.com.br\');" src="http://anytech.com.br/email/imagens/emailbottom.png" style="width:100%; margin-top: 30px;">
				</body>
			</html>
			';
			
			include 'phpmailer/class.phpmailer.php';
			
			$mail = new PHPMailer();
			$mail -> IsSMTP();
			$mail -> Host     = "mail.anytech.com.br";
			$mail -> SMTPAuth = true;
			$mail -> Username = $deEmail;
			$mail -> Password = $senha;
			$mail -> From     = $deEmail;
			$mail -> FromName = $deNome;		
			$mail -> AddAddress($para);
			//$mail->AddCC('3dmaster@uol.com.br', 'Eu'); // Copia
			$mail -> AddBCC('anytechoficial@gmail.com', 'ANYTECH'); // Cópia Oculta
			// Define os dados técnicos da Mensagem
			$mail -> IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail -> Subject = $assunto; // Assunto da mensagem
			$mail -> Body    = $mensagem;
			$mail -> CharSet = 'utf-8';
			$mail -> WordWrap = 23;
			$enviou = $mail -> Send();	
		}
	}

	if($linha['ic_logado'] == 1)
	{	
		header('location: '.VOLTAR);
	}
	else
	{
		header('location: '.VOLTAR.'login');
	}
?>