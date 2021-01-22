<?php
	$host = 'localhost';
	$user = 'anyte539';
	$pass = 'anytech.all';
	$banco = 'anyte539_anytech';

	$conexaoPrincipal = new Conexao();
	$conexaoPrincipal -> AbrirConexao($host, $user, $pass, $banco);
?>