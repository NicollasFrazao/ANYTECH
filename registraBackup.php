<?php

	$conect = mysqli_connect('anytech.com.br','anyte539','anytech.all','anyte539_anytech');
	header("Content-type: text/html; charset=utf-8"); 

	$date = date('Y-m-d H:i:s');

	$insert = "insert into tb_backup values ('null','".$date."')";

	//$query = $conect->prepare($insert);
	//$query->execute();

	//$result = $conect -> Query($insert);

	mysqli_query($conect,$insert);

?>