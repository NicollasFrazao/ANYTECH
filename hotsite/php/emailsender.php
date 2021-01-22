<?php
	include('../../php/Conexao.php');
	include('../../php/ConexaoPrincipal.php');
	$email = $_POST['email'];
	
	$resultSelect = $conexaoPrincipal -> Query("select nm_usuario_completo from tb_usuario where nm_email = '$email'") or die(mysql_error());
	$listSelect = mysqli_fetch_assoc($resultSelect);
	$countResult = mysqli_num_rows($resultSelect);
	
	if($countResult > 0){
		echo "1.".$listSelect['nm_usuario_completo'];
	}
	else{
		$result = $conexaoPrincipal -> Query("insert into tb_leads values (null,'$email');");
		echo "1.0";
	}
	
?>