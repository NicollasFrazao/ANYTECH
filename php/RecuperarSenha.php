<?php
	session_start();
	define('VOLTAR', '../');
	include '../php/Conexao.php';
	include '../php/ConexaoPrincipal.php';
	
	$emailS = mysql_escape_string($_POST['email']);
	
	$result = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, nm_nickname, cd_senha from tb_usuario where nm_email = '$emailS'");
	$linha = mysqli_fetch_assoc($result);
	
	if($linha > 0)
	{		
		$para = $linha['nm_email'];
		$assunto = "Recuperação de Conta";
		$nomeCompleto = $linha['nm_usuario_completo'];
		$nickname = $linha['nm_nickname'];
		$arrayNome = explode(' ',$nomeCompleto);
		$nomeUsuario = $arrayNome[0];
		$senhaUsuario = base64_decode($linha['cd_senha']);
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
				<img src="http://anytech.com.br/images/imagemail/email-topo-anytech.png" style="width:100%">
				<label class="at-saudacao" style="display: inline-block;width: 90%;color: #333;font-size: 1em;margin-top: 50px;padding-left: 5%;padding-right: 5%;">Olá, <b>'.$nomeUsuario.'!</b></label> 
				<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Recebemos sua solicitação de recuperação de conta. Seguem abaixo os dados cadastrais do seu perfil no ANYTECH.</label>
				
				<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Nome: </b>'.$nomeCompleto.'</label><br>
				<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Nickname: </b>'.$nickname.'</label><br>
				<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>E-mail: </b>'.$para.'</label><br>
				<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Senha: </b>'.$senhaUsuario.'</label><br>
				
				<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Caso continue tendo problemas para acessar sua conta, entre em contato pelo e-mail <b>suporte@anytech.com.br</b></label>
				<label class="at-signature" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;font-weight: bold;color: #333;">A equipe ANYTECH agradece!</label>
				<a style="text-decoration: none;" href="http://anytech.com.br"><img src="http://anytech.com.br/images/imagemail/emailbottom-anytech.png" style="width:100%; margin-top: 30px;"></a>
			</body>
		</html>
		';
		
		include("phpmailer/class.phpmailer.php");
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host     = "mail.anytech.com.br";
		$mail->SMTPAuth = true;
		$mail->Username = $deEmail;
		$mail->Password = $senha;
		$mail->From     = $deEmail;
		$mail->FromName = $deNome;		
		$mail->AddAddress($para);
		//$mail->AddCC('3dmaster@uol.com.br', 'Eu'); // Copia
		$mail->AddBCC('anytechoficial@gmail.com', 'ANYTECH'); // Cópia Oculta
		// Define os dados técnicos da Mensagem
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->Subject = $assunto; // Assunto da mensagem
		$mail->Body    = $mensagem;
		$mail->CharSet = 'utf-8';
		$mail->WordWrap = 23;
		$enviou = $mail->Send();	
		
		echo "1";
		
	}
	else
	{
		echo $linha['nm_email'];
	}
	
?>