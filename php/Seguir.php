<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$cdUser = mysql_escape_string($_POST['Usuario']);
	$cdFollower = mysql_escape_string($_POST['Seguidor']);
	
	$result = $conexaoPrincipal -> Query("select * from tb_seguidor
											where cd_usuario = '$cdUser' and cd_seguidor = '$cdFollower'");
	
	$total = mysqli_num_rows($result);
	
	if ($total == 0)	
	{							
		$result = $conexaoPrincipal -> Query("insert into tb_seguidor(cd_usuario,cd_seguidor) values('$cdUser', '$cdFollower')");
		echo "1";
	}
	else
	{
		$result = $conexaoPrincipal -> Query("delete from tb_seguidor where cd_usuario = '$cdUser' and cd_seguidor = '$cdFollower'");
		echo "0";
	}
	
	$conexaoPrincipal -> FecharConexao();
?>