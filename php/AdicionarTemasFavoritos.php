<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']) || !isset($_POST['codigosTemas']))
	{
		exit;
	}
	
	$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
	$codigosTemas = mysql_escape_string($_POST['codigosTemas']);
	
	$codigoTema = explode(';', $codigosTemas);
	$values = '';
	
	if (count($codigoTema) == 0)
	{
		for ($cont = 0; $cont <= count($codigoTema) - 1; $cont = $cont + 1)
		{
			if ($cont == count($codigoTema) - 1)
			{
				$values = $values."('$codigoUsuario', '$codigoTema[$cont]')";
			}
			else
			{
				$values = $values."('$codigoUsuario', '$codigoTema[$cont]'), ";
			}
		}
		
		$result = $conexaoPrincipal -> Query("insert into usuario_tema_favorito(cd_usuario, cd_tema) values $values");
		
		if ($result)
		{
			echo '1;-;Temas adicionados com sucesso!';
		}
		else
		{
			echo '0;-;'.mysqli_error($conexaoPrincipal -> getConexao());
		}
	}
	else
	{
		echo '1;-;Temas adicionados com sucesso!';
	}
?>