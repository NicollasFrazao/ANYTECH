function showShareBox(codigo, titulo, autor, link)
		{
			lbl_share_title.textContent = titulo;
			lbl_share_author.textContent = autor;
			txt_share_link.value = link;
			txt_share_code.value = codigo;
			
			$('.maincover').fadeIn();
			$('#box_share_cover').toggle('slide');
		}
		
		function EsconderValores()
		{
			var aux = document.getElementsByClassName('value-btn');
			
			for (cont = 0; cont <= aux.length - 1; cont = cont + 1)
			{
				aux[cont].style.display = 'none';
			}
		}