<?php
	$endereco = $_SERVER ['REQUEST_URI'];
	$sep = explode("?",$endereco);	
?>
<html>
	<body>
		<label><b>Código da Sessão:</b> <?php echo $sep[1]; ?></label><br>
		<input type="button" value="1" onclick="seta(this.value)"><br><br>
		<input type="button" value="3" onclick="seta(this.value)"><br><br>
		<input type="button" value="4" onclick="seta(this.value)"><br><br>
		<input type="button" value="10" onclick="seta(this.value)"><br><br>
		<input type="button" value="11" onclick="seta(this.value)"><br><br>
		<input type="button" value="50" onclick="seta(this.value)"><br><br>
	</body>
	<script src="../../js/jquery.min.js"></script>	
	<script src="../../js/ajax.js"></script>
	<script>
		
		function seta(coder)
		{
			Ajax("GET", "php/SyncSet.php", "seta="+ coder + "&codigo=<?php echo $sep[1]; ?>", "");
		}
	</script>
</html>