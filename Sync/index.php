<?php
	$endereco = $_SERVER ['REQUEST_URI'];
	$sep = explode("?",$endereco);	
?>
<html>
	<body>
		<label><b>Acesse em seu celular:</b></br></label>
		<h1>www.anytech.com.br/Sync/Mob/?<?php echo $sep[1]; ?></h1><br>
		<label id="at_text"></label>
	</body>
	<script src="../js/jquery.min.js"></script>	
	<script src="../js/ajax.js"></script>
	<script>
		window.onload = function()
		{
			q = <?php echo $sep[1]; ?>;
			if(q == "")
			{
			
			}
			else
			{
				loader();
			}
		}
		
		function loader()
		{
		
			//alert('<?php echo $sep[1]; ?>');
			Ajax("GET", "php/SyncMob.php", "codigo="+ <?php echo $sep[1]; ?>, "var retorno = this.responseText; at_text.innerHTML = retorno; setTimeout(loader(), 3000);");
			
		}
	</script>
</html>