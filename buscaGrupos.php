<?php
	
	$conect = mysqli_connect("anytech.com.br","anyte539","anytech.all","anyte539_ramad");

	$select = 'select distinct codigo_grupo from credline_grupo';

	$query = $conect->query($select);
	$row = mysqli_fetch_assoc($query);
	$count = mysqli_num_rows($query);

	
	$texto = '';

	$ct = 0;

	if($count > 0){

		do{

			$ct++;

			if($ct == 1){

				$texto = $row['codigo_grupo'];

			}
			else{

				$texto = $texto."|".$row['codigo_grupo'];

			}

			

		}
		while($row = mysqli_fetch_assoc($query));


	}

	echo $texto;

?>