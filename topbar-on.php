<div class="anytech-bar" style="position: fixed; top: 0px;">
	<img src="<?php echo VOLTAR; ?>images/logo.png" id="anytech_logo_image" style="cursor: pointer" alt="ANYTECH" onclick="window.location.href = '<?php echo VOLTAR; ?>index.php';">
	<div class="anytech-user-profile">
		<table>
			<tr>
				<td>
					<label class="anytech-username"><?php echo $nomeUsuario; ?></label>
				</td>	
				<td>
					<input type="image" src="<?php echo VOLTAR; ?><?php if ($imagemUsuario == '') {echo 'images/user.png';} else {echo $imagemUsuario;} ?>" class="anytech-user-image" id="anytech_menu_button">					
				</td>						
			</tr>
		</table>
	</div>
	<script>
		function getFollowers()
		{
			Ajax("GET", "<?php echo VOLTAR; ?>php/ContarSeguidores.php", "", "var retorno = this.responseText; skp = retorno.split(';'); followers_count.innerHTML = skp[0]; following_count.innerHTML = skp[1];"); 			
		}
	</script>
</div>