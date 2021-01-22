<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	$cdUser = mysql_escape_string($_POST['Usuario']);
	
	$followers = $conexaoPrincipal -> Query("select count(*) as 'followersCount' from tb_seguidor where cd_usuario = '$cdUser'");
	$followers = mysqli_fetch_assoc($followers);
	
	$following = $conexaoPrincipal -> Query("select count(*) as 'followingCount' from tb_seguidor where cd_seguidor = '$cdUser'");
	$following = mysqli_fetch_assoc($following);
	
	echo $followers['followersCount'];
	echo ";";
	echo $following['followingCount'];
	
	$conexaoPrincipal -> FecharConexao();
?>