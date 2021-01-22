<?php
	session_start();
	define('VOLTAR', '../');
	include '../php/Conexao.php';
	include '../php/ConexaoPrincipal.php';
	
	//$emailS = mysql_escape_string($_GET['email']);
	
	$result = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, nm_nickname, ic_conta_ativa, ic_bloqueado, ic_logado from tb_usuario where cd_usuario = 26 or cd_usuario = 27;")or die(mysqli_error());
	$linha = mysqli_fetch_assoc($result);
	
	if($linha > 0)
	{		
			
			$assunto = "EletronTech - Você já pode fazer o download!";
			//$nomeCompleto = $linha['nm_usuario_completo'];
			//$nickname = $linha['nm_nickname'];
			//$arrayNome = explode(' ',$nomeCompleto);
			//$nomeUsuario = $arrayNome[0];
			//$senhaUsuario = base64_decode($linha['cd_senha']);
			//echo $nomecompleto;
			$deNome = "ANYTECH";
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
					<img src="http://anytech.com.br/email/imagens/email-topo-eletrontech.png" style="width:100%">
					<label class="at-saudacao" style="display: inline-block;width: 90%;color: #333;font-size: 1em;margin-top: 50px;padding-left: 5%;padding-right: 5%;">Olá, <b>'.$nomeUsuario.'!</b></label> 
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Estamos muito felizes com o lançamento do nosso mais novo projeto. O aplicativo EletronTech, que realiza diversos cálculos de diferentes áreas de exatas em poucos instantes.</label><br>
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Convidamos você a realizar o download no link abaixo. Relembramos também o seu e-mail e senha para o acesso.</label><br>
					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Nome: </b>'.$nomeCompleto.'</label><br>					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>E-mail: </b>'.$para.'</label><br>					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Senha: </b>'.$senhaUsuario.'</label><br>

					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Para mais informações ou resolução de problemas de acesso em sua conta, entre em contato pelo e-mail <b>suporte@anytech.com.br</b></label><br>
					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Agradecemos a você pela colaboração!</label><br>
					<label class="at-signature" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;font-weight: bold;color: #333;">A equipe ANYTECH agradece!</label>
					<img onclick="window.open(\'http://anytech.com.br\');" src="http://anytech.com.br/email/imagens/emailbottom-eletrontech.png" style="width:100%; margin-top: 30px;">
				</body>
			</html>
			';
			
			include("phpmailer/class.phpmailer.php");
			
			do{
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host     = "mail.anytech.com.br";
			$mail->SMTPAuth = true;
			$mail->Username = $deEmail;
			$mail->Password = $senha;
			$mail->From     = $deEmail;
			$mail->FromName = $deNome;	

			echo $linha['nm_lead']."<BR>";
			$para = $linha['nm_email'];	
			$nomeCompleto = $linha['nm_usuario_completo'];
			$arrayNome = explode(' ',$nomeCompleto);
			$nomeUsuario = $arrayNome[0];
			$senhaUsuario = base64_decode($linha['cd_senha']);
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
			}while ($linha = mysqli_fetch_assoc($result));
		
	}
	else
	{
		echo "0";
	}
	
?>