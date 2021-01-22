<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$nome = mysql_escape_string($_POST['nome']);
	$email = mysql_escape_string($_POST['email']);
	$senha = mysql_escape_string($_POST['senha']);
	$datanas = mysql_escape_string($_POST['datanas']);
	$sexo = mysql_escape_string($_POST['sexo']);
	$nickname = mysql_escape_string($_POST['nickname']);
	
	$senha = base64_encode($senha);
	
	$aux = explode('/', $datanas);
	$datanas = $aux[2].'-'.$aux[1].'-'.$aux[0];
	
	/*echo 'Nome Completo: '.$nome.'<br/>';
	echo 'E-mail: '.$email.'<br/>';
	echo 'Senha: '.$senha.'<br/>';
	echo 'Data de Nascimento: '.$datanas.'<br/>';
	echo 'Sexo: '.$sexo.'<br/>';*/
	
	$result = $conexaoPrincipal -> Query("insert into tb_usuario(nm_usuario_completo, nm_email, cd_senha, dt_nascimento, nm_sexo, cd_nivel_cadastro, nm_nickname, dt_cadastro) values('$nome', '$email', '$senha', '$datanas', '$sexo', 1, '$nickname', now())");
	
	if ($result == 1)
	{
		echo '1;-;Cadastrado realizado com sucesso! Enviamos um e-mail de confirmação para sua caixa de entrada, confirme-o para acesso aos demais serviços.';
		
		$result_Login = $conexaoPrincipal -> Query("select cd_usuario, nm_usuario_completo, nm_nickname, nm_email, cd_senha, ic_bloqueado, dt_desbloqueio from tb_usuario where nm_email = '$email' and cd_senha = '$senha'");
		$linha_Login = mysqli_fetch_assoc($result_Login);
		$total_Login = mysqli_num_rows($result_Login);
		
		$_SESSION['AnyTech']['codigoUsuario'] = $linha_Login['cd_usuario'];
		$_SESSION['AnyTech']['nomeUsuario'] = $linha_Login['nm_usuario_completo'];
		$_SESSION['AnyTech']['nicknameUsuario'] = $linha_Login['nm_nickname'];
		$_SESSION['AnyTech']['emailUsuario'] = $linha_Login['nm_email'];
		
		$pasta = mkdir('../@'.$nickname);
		$pasta = mkdir('../@'.$nickname."/images");
		
		$conteudo = '<?php include \'../profile/index.php\'; ?>';
		
		$ponteiro = fopen('../@'.$nickname.'/index.php', 'w');
		fwrite($ponteiro, $conteudo);
		fclose($ponteiro);
	}
	else
	{
		echo '0;-;Não foi possível realizar o cadastro! Já existe um usuário que contém o mesmo e-mail digitado, utilize outro e tente novamente.';
		//echo mysqli_error($conexaoPrincipal -> getConexao());
	}
	
	$conexaoPrincipal -> FecharConexao();
?>