<style>
	/*#editado at-imagem img
	{
		width: 100%;
		display: inherit;
	}
	
	#editado at-imagem > center > div
	{
		max-width: 50%;
		cursor: pointer;
	}*/
	
	#editado pre
	{
		width: 100%;
		white-space: pre-wrap;
		white-space: moz-pre-wrap;
		white-space: -pre-wrap;
		white-space: -o-pre-wrap;
		word-wrap: break-word;
	}
</style>

<div id="editado" class="artc">
	<?php echo $texto; ?>
</div>

<script>
	aux = editado.getElementsByTagName('at-highlighter');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		var conteudo = aux[cont].innerHTML;
		conteudo = conteudo.split("##");
		var linguagem = conteudo[0];
		var codigoBloco = conteudo[1];
		
		aux[cont].innerHTML = '<pre class="brush: ' + linguagem + ';">' + codigoBloco + '</pre>';
	}
	
	aux = editado.getElementsByTagName('at-hiperlink');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		var conteudo = aux[cont].innerHTML;
		conteudo = conteudo.split("##");
		var texto = conteudo[0];
		var link = conteudo[1];
		
		if (link == "")
		{
			link = "#";
		}
		
		aux[cont].innerHTML = '<a href="' + link + '" target="_blank" class="post-link">' + texto + '</a>';
	}
	
	aux = editado.getElementsByTagName('at-subtitulo');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		aux[cont].setAttribute("class", "post-topic");
	}
	
	aux = editado.getElementsByTagName('at-citacao');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		aux[cont].setAttribute("class", "post-quote");
	}
	
	aux = editado.getElementsByTagName('at-negrito');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		aux[cont].innerHTML = '<b>' + aux[cont].innerHTML + '</b>';
	}
	
	aux = editado.getElementsByTagName('at-sublinhado');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		aux[cont].innerHTML = '<u>' + aux[cont].innerHTML + '</u>';
	}
	
	aux = editado.getElementsByTagName('at-italico');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		aux[cont].innerHTML = '<i>' + aux[cont].innerHTML + '</i>';
	}
	
	aux = editado.getElementsByTagName('at-imagem');
	
	for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
	{
		aux[cont].innerHTML = '<img src="' + aux[cont].textContent + '" class="post-image" onclick="ChamaModal(this.src);"/>';
	}
	
	function ChamaModal(caminho)
	{
		/*var img = document.getElementById('pct_foto'); 
		img.src = caminho;
		
		$('#myModal').modal('show');*/
	}
</script>