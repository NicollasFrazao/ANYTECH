<?php

	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';

	$mensagem = $_POST['mensagem'];
	$assunto = $_POST['assunto'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$android = $_POST['android'];
	$ios = $_POST['ios'];
	$wp = $_POST['windowsphone'];
	$webapp = $_POST['webapp'];

	$insert = "insert into tb_orcamento values(null,'".$nome."','".$email."','".$mensagem."','".date('Y-m-d H:i:s')."',0,'".$assunto."','".$android."','".$ios."','".$wp."','".$webapp."',0)";
	$result = $conexaoPrincipal -> Query($insert);


	$detalhes = "";
	$countDetalhes = 0;

	if($android == 1){

		$detalhes = $detalhes." - Android";
		$countDetalhes++;

	}

	if($ios == 1){

		$detalhes = $detalhes." - iOS";
		$countDetalhes++;
		
	}

	if($wp == 1){

		$detalhes = $detalhes." - Windows Phone";
		$countDetalhes++;
		
	}

	if($webapp == 1){

		$detalhes = $detalhes." - WebApp";
		$countDetalhes++;
		
	}

	if($countDetalhes > 0){

		$detalhes = substr($detalhes, 2);

		$detalhes = " (".$detalhes.")";
	
	}
	else{

		$detalhes = "";
	}


	if($result == 1){

		$para = $email;
		$assuntomail = "Mensagem Recebida";
		$nomeCompleto = $nome;
		$arrayNome = explode(' ',$nomeCompleto);
		$nomeUsuario = $arrayNome[0];
		$senhaUsuario = base64_decode($senha);
		//echo $nomecompleto;
		$deNome = "ANYTECH - Contato";
		$deEmail = "contato@anytech.com.br";
		$senha = "Con.Com.All";
		$reply = "contato@anytech.com.br";
		
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
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Sua mensagem foi recebida com sucesso pela nossa equipe!</label>
					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Nome: </b>'.$nomeCompleto.'</label><br>					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>E-mail: </b>'.$email.'</label><br>
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Assunto: </b>'.$assunto.$detalhes.'</label><br>							
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 5px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;"><b>Mensagem: </b>'.$mensagem.'</label><br>							
					
					<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: left;line-height: 170%;">Em breve nossa equipe entrará em contato com você. Para mais informações, nos envie uma mensagem pelo e-mail <b>contato@anytech.com.br</b></label>
					<label class="at-signature" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;font-weight: bold;color: #333;">A equipe ANYTECH agradece!</label>
					<img onclick="window.open(\'http://anytech.com.br\');" src="http://anytech.com.br/images/imagemail/emailbottom-anytech.png" style="width:100%; margin-top: 30px;">
				</body>
			</html>
		';
		
		include 'phpmailer/class.phpmailer.php';
		
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
		$mail->Subject = $assuntomail; // Assunto da mensagem
		$mail->Body    = $mensagem;
		$mail->CharSet = 'utf-8';
		$mail->WordWrap = 23;
		$enviou = $mail->Send();	
		

		echo "1";



	}
	else{

		echo "0";

	}

	$conexaoPrincipal -> FecharConexao();

	
?>
