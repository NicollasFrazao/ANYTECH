<?php
	if (isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$cod_usuario = $_SESSION['AnyTech']['codigoUsuario'];
		
		$searchColor = $conexaoPrincipal->query("select ds_cor_background, ds_cor_menu, ds_cor_barra from tb_usuario where cd_usuario = '$cod_usuario' ");
		$searchColor = mysqli_fetch_assoc($searchColor);
		$colorMenu = $searchColor['ds_cor_menu'];
		$colorBarra = $searchColor['ds_cor_barra'];
		$colorBackground = $searchColor['ds_cor_background'];
	}
	else
	{
		$colorBarra = '';
	}
?>

<meta name="theme-color" content="<?php echo (($colorBarra != '') ? $colorBarra : '#000000'); ?>"> 