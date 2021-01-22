<?php
	session_start();
	
	if (isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>