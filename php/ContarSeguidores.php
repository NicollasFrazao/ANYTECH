<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$usercode = $_SESSION['AnyTech']['codigoUsuario'];
	
	$result = $conexaoPrincipal -> Query("select count(*) as fr from tb_seguidor where cd_usuario = '$usercode';");
	$linha = mysqli_fetch_assoc($result);
	
	if($linha == 0)
	{
		echo "0";
	}	
	else
	{
		echo $linha['fr'];
	}
	
	$result2 = $conexaoPrincipal -> Query("select count(*) as fw from tb_seguidor where cd_seguidor = '$usercode';");
	$linha2 = mysqli_fetch_assoc($result2);
	
	if($linha2 == 0)
	{
		echo ";0";
	}	
	else
	{
		echo ";".$linha2['fw'];
	}
?>	