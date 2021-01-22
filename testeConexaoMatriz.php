<?php

	$servername77 = "18.228.34.255";
	$dbname77 = "blackhawk";
	$username77 = "sites_recepcao";
	$password77 = "BB@sites_2018";

	/////////////**************************************** conexao sistema

    $conn_externosis = new mysqli($servername77, $username77, $password77, $dbname77);

   // print_r($conn_externosis);


    // Check connection
	if ($conn_externosis->connect_error) {
	    die("Connection failed: " . $conn_externosis->connect_error);
	} 
	echo "Connected successfully";
?>