<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_POST['anytech-email']))
	{
		exit;
	}
	
	$email = mysql_escape_string($_POST['anytech-email']);
	$senha = mysql_escape_string(base64_encode($_POST['anytech-senha']));
	
	date_default_timezone_set('Brazil/East');
	date_default_timezone_set('America/Sao_Paulo'); // atualizado em 19/08/2013
	
		
	$result_Login = $conexaoPrincipal -> Query("select cd_usuario, nm_usuario_completo, nm_nickname, nm_email, cd_senha, ic_bloqueado, dt_desbloqueio, cd_nivel, ic_conta_ativa from tb_usuario where nm_email = '$email' and cd_senha = '$senha'");
	$linha_Login = mysqli_fetch_assoc($result_Login);
	$total_Login = mysqli_num_rows($result_Login);
	
	$result_Bloqueio = $conexaoPrincipal -> Query("select cd_usuario, nm_email, cd_senha, ic_bloqueado, dt_desbloqueio from tb_usuario where nm_email = '$email'");
	$linha_Bloqueio = mysqli_fetch_assoc($result_Bloqueio);
	$total_Bloqueio = mysqli_num_rows($result_Bloqueio);

	if ($linha_Bloqueio['ic_bloqueado'] == 1)
	{
		//	verifico se ja passou o tempo de bloqueio, se passou mando ele para o criterio de login e tiro o ic e a data
		//de bloqueio
		// pesquisa para ver a dt de desbloqueio
		
		$dtbloqueio = $linha_Bloqueio['dt_desbloqueio'];
		$dataatual = date("Y/m/d H:i:s");
		
		if(strtotime($dataatual) > strtotime($dtbloqueio))
		{
			$result = $conexaoPrincipal -> Query("update tb_usuario set dt_desbloqueio = null, ic_bloqueado = 0 where nm_email = '$email'");
			
			$aux = 1;
		}
		else
		{
			$_SESSION['AnyTech']['status_bloqueado'] = "bloqueado";
			
			$logou = 0;
			echo $logou.';-;Número de tentativas extrapolados,espere por meia hora para tentar novamente.';
		}
	}
	else
	{
		$aux = 1;
		
		if ($aux == 1)
		{
			if ($total_Login > 0)
			{
				$codigoUsuario = $linha_Login['cd_usuario'];
				
				$_SESSION['AnyTech']['codigoUsuario'] = $linha_Login['cd_usuario'];
				$_SESSION['AnyTech']['nomeUsuario'] = $linha_Login['nm_usuario_completo'];
				$_SESSION['AnyTech']['nicknameUsuario'] = $linha_Login['nm_nickname'];
				$_SESSION['AnyTech']['emailUsuario'] = $linha_Login['nm_email'];
				$_SESSION['AnyTech']['nivelUsuario'] = $linha_Login['cd_nivel'];
				
				$result = $conexaoPrincipal -> Query("update tb_usuario set ic_logado = 1 where nm_email = '$email'");
				
				$nickname = $linha_Login['nm_nickname'];
				
				if(!file_exists('../@'.$nickname))
				{
					$pasta = mkdir('../@'.$nickname);
					$pasta = mkdir('../@'.$nickname.'/images');
				}
				
				if(!file_exists('../@'.$nickname.'/images'))
				{
					$pasta = mkdir('../@'.$nickname.'/images');
				}
				
				
				$conteudo = '<?php include \'../profile/index.php\'; ?>';
				
				$ponteiro = fopen('../@'.$nickname.'/index.php', 'w');
				fwrite($ponteiro, $conteudo);
				fclose($ponteiro);
				
				$logou = 1;
				echo $logou.';-;Login efetuado com sucesso! Aguarde o carregamento da página...';
			}
			else
			{
				$logou = 0;
				$_SESSION['AnyTech']['verifica'] += 1;
				
				if($_SESSION['AnyTech']['verifica'] > 3)
				{
					//muda status de bloqueio para 1
					//set a data e horario de bloqueio
					
					$dataDesbloqueio = date("Y/m/d H:i:s", strtotime('+30 minute', strtotime(date("Y/m/d H:i:s"))));
					
					$result = $conexaoPrincipal -> Query("update tb_usuario set ic_bloqueado = 1, dt_desbloqueio = '$dataDesbloqueio' where nm_email = '$email'");
					
					echo $logou.';-;Número de tentativas extrapolados,espere por meia hora para tentar novamente.';
				}
				else
				{
					echo $logou.';-;Email e(ou) senha digitado(s) incorretamente.';
				}
			}
		}
	}
?>

<?php
	if ($logou == 1)
	{
		$key = base64_encode($codigoUsuario);
		
		$resultMail = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, ic_bloqueado, ic_conta_ativa from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha = mysqli_fetch_assoc($resultMail);
		
		if($linha['ic_bloqueado'] != 1)
		{
			if ($linha['ic_conta_ativa'] != 1)
			{
				//DEFINIÇÃO DE DADOS DO EMAIL
				$para = $linha['nm_email'];
				$assunto = "Confirmação de cadastro";
				$nomeCompleto = $linha['nm_usuario_completo'];
				$arrayNome = explode(' ',$nomeCompleto);
				$nomeUsuario = $arrayNome[0];
				//echo $nomecompleto;
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
						<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Obrigado por se cadastrar em nosso site. Para começar a aproveitar todos os conteúdos e serviços da ANYTECH, você só precisa clicar no link abaixo para confirmação de acesso.</label>
						<a href="http://anytech.com.br/php/ConfirmacarEmail.php?key='.$key.'" class="at-button" style="display: inline-block;width: auto;margin-left: 5%;padding: 10px;margin-top: 25px;background-color: rgb(13,180,255);color: white;border: 0px;font-weight: bold; text-decoration: none;" type="button">Confirmar meu  cadastro no ANYTECH</a>
						<br><br>
						<label class="at-mensagem" style="display: inline-block;width: 90%;padding-left: 5%;padding-right: 5%;margin-top: 30px;font-size: 1em;color: #333;text-align: justify;line-height: 170%;">Caso você não tenha se cadastrado no <b>www.anytech.com.br</b>, por favor, desconsidere este e-mail.</label>
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

				$result = $conexaoPrincipal -> Query("update tb_usuario set ic_conta_ativa = 0 where cd_usuario = '$codigoUsuario'");			
			}
		}
	}
?>