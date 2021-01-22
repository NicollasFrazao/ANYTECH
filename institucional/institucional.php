<?php
	if (!isset($logado))
	{
		exit;
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<?php
			include VOLTAR.'php/CoresGoogle.php';
		?>
		
		<!-- GOOGLE ANALYTICS-->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-80717206-1', 'auto');
		  ga('send', 'pageview');

		</script>
		<!-- GOOGLE ANALYTICS-->
		
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta name="description" content="A Anytech desenvolve sistemas e soluções inteligentes para o você. O melhor em criação de websites, softwares e muitos outros serviços. Conheça a Biblioteca Anytech, que lhe fornece diversos materiais de pesquisa e estudo sobre programação de computadores.">
		<meta name="keywords" content="biblioteca, programação, site, website, software, criar, comprar, template, desenvolvimento, pesquisa, linguagens de programação, estudo, anytech, eletrontech, santos, são paulo, sp, baixada santista"/>
		<meta name="robots" content="index, follow">
		<meta name="googlebot" content="index, follow">
		<meta name="author" content="AnyTech">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" type="image/png" href="<?php echo VOLTAR; ?>images/logoico.png" alt="ANYTECH"/>
		<link rel="stylesheet" type="text/css" href="<?php echo VOLTAR; ?>css/anytech-style-index.css">
		<title>ANYTECH - Levando a tecnologia até você</title>
	</head>
	<body>
		<?php
			if ($logado == 1)
			{
				include VOLTAR.'topbar-on.php';
				include VOLTAR.'menu.php';
			}
			else
			{
				include VOLTAR.'topbar-off.php';
			}
		?>
		
		<div class="anytech-page">
			
			<div class="anytech-sections" id="anytech_home">
				<div id="slideshow">
					<div id="covers">
					
						<div class="slider-cover">
							<h1 class="slider-cover-title"><b>Crie</b> seu <b>Site</b> com a ANYTECH!</h1>
							<h2 class="slider-cover-legend">+ Sites adaptáveis para todos os tipos de dispositivos</h2>
							<h2 class="slider-cover-legend">+ Modelos de sites exclusivos para o seu negócio</h2>
							<h2 class="slider-cover-legend">+ Estruturas dinâmicas proporcionando melhor experiência</h2>
							
						</div>	
					</div>
					
					<div id="slides">
						<img src="<?php echo VOLTAR; ?>images\slider\1.png">
					</div>									
				</div>					
			</div>
			
			
			<div class="anytech-line-div">
				<div class="anytech-box-index">
					<table width="100%">
						<tr>
							<td width="45%" valign="center">
								<img src="<?php echo VOLTAR; ?>images/services.jpg" class="anytech-box-image" id="box-image-out-table">
								<h1 class="anyetch-box-title">Você pode ter um website com a cara do seu empreendimento</h1>
								<p class="anyetch-box-desc">A Anytech desenvolve diversos sistemas e soluções inteligentes para você. O melhor em criação de websites, softwares e muitos outros serviços. Conheça a Biblioteca ANYTECH, que lhe fornece materiais de pesquisa e estudo sobre programação de computadores.</p>									
							</td>
							<td width="55%" align="center" valign="top" class="box-image-on-table">
								<img src="<?php echo VOLTAR; ?>images/services.jpg" class="anytech-box-image">
							</td>
						<tr>
					</table>
				</div>				
			</div>
			
			
			<div class="anytech-line-div-gray">
				<div class="anytech-box-index">
					<table width="100%">
						<tr>
							<td width="55%" align="center" valign="top" class="box-image-on-table">
								<img src="<?php echo VOLTAR; ?>images/seo.gif" class="anytech-box-image">
							</td>
							<td width="45%" valign="top" class="box-info">
								<img src="<?php echo VOLTAR; ?>images/seo.gif" class="anytech-box-image" id="box-image-out-table">
								<h1 class="anyetch-box-title">Você pode ter um website com a cara do seu empreendimento</h1>
								<p class="anyetch-box-desc">A ANYTECH desenvolve diversos sistemas e soluções inteligentes para você. O melhor em criação de websites, softwares e muitos outros serviços.</p>		
								<a href="#" class="anytech-box-link">Em breve, mais informações sobre nossos serviços</a>
							</td>
						<tr>
					</table>
				</div>				
			</div>
			
			<div class="anytech-sections" id="anytech_services" align="center">
			<h1 class="anyetch-box-title-about">Portfolio</h1>	
			<p class="anyetch-box-desc-about">Confira abaixo alguns dos trabalhos e templates desenvolvidos pela ANYTECH</p>
				<div id="anytech_services_form" align="left">						
					<img src="<?php echo VOLTAR; ?>images/portfolio/1.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/2.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/3.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/4.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/5.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/6.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/7.png" class="portfolio-image">
					<img src="<?php echo VOLTAR; ?>images/portfolio/8.png" class="portfolio-image">
				</div>
			</div>
			
			
			<div class="anytech-sections" id="anytech_about">
				<div id="anytech_about_form" align="left">
					<h1 class="anyetch-box-title-about">Afinal, quem somos nós?</h1>
					<p class="anyetch-box-desc-about">A ANYTECH é uma micro empresa de desenvolvimento de sistemas informatizados. Criamos diversos tipos de sistemas e soluções inteligentes para você. Realizamos o melhor na criação de websites, softwares e muitos outros serviços. Temos como objetivo proporcionar aos nossos clientes um serviço de qualidade, com entrega em curto prazo, e com preços acessíveis.</p>
					
					<p  class="anyetch-box-desc-about">Conheça a equipe de desenvolvimento da ANYTECH</p>
					<div class="anytech-people">
						<table height="100%" width="100%">
							<tr>
								<td valign="top">
									<img src="<?php echo VOLTAR; ?>images/people/1.jpg" class="anytech-image" alt="Gustavo Alves de Araújo">
								</td>
								<td width="100%" valign="top">
									<table>
										<tr>
											<td>
												<label class="anytech-subtitle">GUSTAVO ALVES</label>
											</td>
										</tr>
										<tr>
											<td>
												<label class="anytech-about-legend">Coordenação de Projetos e Web Design</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="button" class="anytech-button" id="anytech_more" value="+ Ver Mais">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					
					<div class="anytech-people">
						<table height="100%" width="100%">
							<tr>
								<td width="100%" align="right" valign="top">
									<table style="margin-right:20px;">
										<tr>
											<td align="right">
												<label class="anytech-subtitle">JOÃO VASCONCELOS</label>
											</td>
										</tr>
										<tr>
											<td align="right">
												<label class="anytech-about-legend">Publicidade e Marketing Digital</label>
											</td>
										</tr>
										<tr>
											<td align="right">
												<input type="button" class="anytech-button" id="anytech_more" value="+ Ver Mais">
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<img src="<?php echo VOLTAR; ?>images/people/2.jpg" class="anytech-image" alt="João Gabriel de Almindo Vasconcelos">
								</td>
							</tr>
						</table>
					</div>
					
					<div class="anytech-people">
						<table height="100%" width="100%">
							<tr>
								<td valign="top">
									<img src="<?php echo VOLTAR; ?>images/people/3.jpg" class="anytech-image" alt="Lucas Sérgio Denhei Alexandre">
								</td>
								<td width="100%" valign="top">
									<table>
										<tr>
											<td>
												<label class="anytech-subtitle">LUCAS DENHEI</label>
											</td>
										</tr>
										<tr>
											<td>
												<label class="anytech-about-legend">Desenvolvimento de Sistemas - Programação Front End</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="button" class="anytech-button" id="anytech_more" value="+ Ver Mais">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					
					<div class="anytech-people">
						<table height="100%" width="100%">
							<tr>
								<td width="100%" align="right" valign="top">
									<table style="margin-right:20px;">
										<tr>
											<td align="right">
												<label class="anytech-subtitle">LUIZ MARCELINO JUNIOR</label>
											</td>
										</tr>
										<tr>
											<td align="right">
												<label class="anytech-about-legend">Desenvolvimento de Banco de Dados</label>
											</td>
										</tr>
										<tr>
											<td align="right">
												<input type="button" class="anytech-button" id="anytech_more" value="+ Ver Mais">
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<img src="<?php echo VOLTAR; ?>images/people/4.jpg" class="anytech-image" alt="Luiz Carlos Marcelino Junior">
								</td>
							</tr>
						</table>
					</div>
					
					<div class="anytech-people">
						<table height="100%" width="100%">
							<tr>
								<td valign="top">
									<img src="<?php echo VOLTAR; ?>images/people/5.jpg" class="anytech-image" alt="Nícollas Leite Frazão Santos">
								</td>
								<td width="100%" valign="top"	>
									<table>
										<tr>
											<td>
												<label class="anytech-subtitle">NÍCOLLAS FRAZÃO</label>
											</td>
										</tr>
										<tr>
											<td>
												<label class="anytech-about-legend">Desenvolvimento de Sistemas - Programação Back End</label>												
											</td>
										</tr>
										<tr>
											<td>
												<input type="button" class="anytech-button" id="anytech_more" value="+ Ver Mais">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					
						<label class="anytech-subtitle" id="anytech_top">ACESSE NOSSAS OUTRAS PÁGINAS</label><br>						
						<label class="anytech-about-legend">Fique por dentro das novidades da ANYTECH também nas redes sociais!</label>
						<table width="100%" height="100px;">
							<tr>
								<td width="70px">
									<img src="<?php echo VOLTAR; ?>images/facebook.png" class="anytech-icons">
								</td>
								<td valign="center">
									<a class="anytech-subtitle-social"><b>FACEBOOK.COM/</b>ANYTECHOFICIAL</a>
								</td>
							<tr>
							
							<tr>
								<td width="70px">
									<img src="<?php echo VOLTAR; ?>images/twitter.png" class="anytech-icons">
								</td>
								<td>
									<a class="anytech-subtitle-social"><b>TWITTER.COM/</b>ANYTECHOFICIAL</a>
								</td>
							<tr>
						</table>				
				</div>
			</div>
			
			<div class="anytech-sections" id="anytech_library">
				<div class="anytech-line-div">
					<div class="anytech-box-index">
						<table width="100%">
							<tr>							
								<td width="50%" align="center" valign="center" class="box-image-on-table">
									<img src="<?php echo VOLTAR; ?>images/slider/books.png" class="anytech-box-image">
								</td>
								<td width="50%" valign="top" align="center">
								<br>
									<label class="anytech-titles">Já Conhece nossa Biblioteca?</label><br>
									<input type="button" class="anytech-button" value="ACESSAR" style="margin-top: 20px;">								
								</td>
							<tr>
						</table>
					</div>				
				</div>
				<div id="anytech_library_form" align="center" class="anytech-doubts">					
					<label id="anytech_library_label">O QUE VOCÊ DESEJA SABER SOBRE INFORMÁTICA?</label><br>
					<div id="anytech_library_search">
						<table width="100%">
							<tr>
								<td>
									<input type="text" id="anytech_library_input">	
								</td>
								<td width="10%">
									<input type="image" src="<?php echo VOLTAR; ?>images/search.png" id="anytech_library_button">
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			
			<div class="anytech-sections" id="anytech_contact">
				<div id="anytech_contact_form" align="center">
					<label class="anytech-titles" align="center">DEIXE SUA MENSAGEM</label>
					<input type="text" placeholder="Nome" class="anytech-input" id="mensagem_nome" required <?php if ($logado == 1) {echo 'readonly';} ?>/>
					<input type="text" placeholder="E-mail" class="anytech-input" id="mensagem_email" required <?php if ($logado == 1) {echo 'readonly';} ?>/>
					<input type="text" placeholder="Assunto" class="anytech-input" id="mensagem_assunto" required>
					<textarea placeholder="Mensagem" class="anytech-input" id="mensagem_mensagem" required></textarea><br>
					<input type="button" value="ENVIAR" class="anytech-contact-button" onclick="enviaDadosMensagem()"><Br>
					<label id="anytech_contact_label">ENTRE EM CONTATO PELO NOSSO E-MAIL</label>
					<label id="anytech_contact_label">CONTATO@ANYTECH.COM.BR</label>
				</div>
			</div>
			<div class="anytech-sections" id="anytech_map">
				<div class="anytech-map">
				<!--
					position: fixed;
					bottom:0%;
					alterar na rolagem via js
					-->
					<table id="anytech_map_table">
						<tr>
							<td width="20%">							
								<label class="anytech-map-label" id="home-map">HOME</label>
								<label class="anytech-map-label" id="about-map">SOBRE</label>
								<label class="anytech-map-label">SERVIÇOS</label>
								
							</td>
							<td width="20%">
								<label class="anytech-map-label" id="port-map">PORTFÓLIO</label>
								<label class="anytech-map-label">SISTEMAS</label>
								
							</td>
							<td width="20%">
								<label class="anytech-map-label" id="contact-map">CONTATO</label>
								<a href="https://www.facebook.com/anytechOficial/"  target="_blank"><label class="anytech-map-label">FACEBOOK</label></a>
							</td>
							<td width="20%">
								<div class="anytech-search">
									<label class="anytech-search-label">O QUE VOCÊ PROCURA?</label>
									<div id="anytech_search">
										<input type="text" id="anytech_search_input">
										<input type="image" src="<?php echo VOLTAR; ?>images/search.png" id="anytech_search_button">
									</div>
								</div>
							</td>
						</tr>
					</table>
					<label id="anytech_footer_label">ANYTECH - <?php echo date('Y'); ?></label>
				</div>
			</div>
		</div>
	</body>
	<script src="<?php echo VOLTAR; ?>js/jquery.min.js"></script>
	<script src="<?php echo VOLTAR; ?>js/res.js"></script>
	<script src="<?php echo VOLTAR; ?>js/cycle.js"></script>
	<script language="JavaScript" src="http://www.iplocationtools.com/iplocationtools.js?key=YOUR_API_KEY"></script>
	<script>		
		jQuery(document).ready(function($) {	
		
			$('#slides').responsiveSlides();	
			$('#covers').responsiveSlides();
			
		});
				
		
		//MAPA
		$(function (){
			$("#home-map").click(function (event) {
				event.preventDefault();
				var idElemento = $("#anytech_home");
				var deslocamento = $(idElemento).offset().top - 70;
				$('html, body').animate({ scrollTop: deslocamento }, 'slow');
			});
		});
		
		$(function (){
			$("#about-map").click(function (event) {
				event.preventDefault();
				var idElemento = $("#anytech_about");
				var deslocamento = $(idElemento).offset().top + 150;
				$('html, body').animate({ scrollTop: deslocamento }, 'slow');
			});
		});
		
		$(function (){
			$("#port-map").click(function (event) {
				event.preventDefault();
				var idElemento = $("#anytech_services");
				var deslocamento = $(idElemento).offset().top;
				$('html, body').animate({ scrollTop: deslocamento }, 'slow');
			});
		});
				
		$(function (){
			$("#contact-map").click(function (event) {
				event.preventDefault();
				var idElemento = $("#anytech_contact");
				var deslocamento = $(idElemento).offset().top + 170;
				$('html, body').animate({ scrollTop: deslocamento }, 'slow');
			});
		});
		
		//Transferencia do cd_usuario do php
		var cod_usuario = "<?php echo $cod_usuario; ?>";
		
		
		function anytech_recovery_on()
		{
			$('.anytech-cover').fadeIn('slide');
			setTimeout("$('.anytech-popup-recover').fadeIn('slide');",500);
		}
		
		function anytech_recovery_off()
		{
			$('.anytech-popup-recover').fadeOut('slide');
			setTimeout("$('.anytech-cover').fadeOut('slide');",100);
		}
		
		function anytech_access_code_on()
		{
			$('.anytech-cover').fadeIn('slide');
			setTimeout("$('.anytech-popup-access-code').fadeIn('slide');",500);
		}
		
		function anytech_access_code_off()
		{
			$('.anytech-popup-access-code').fadeOut('slide');
			setTimeout("$('.anytech-cover').fadeOut('slide');",100);
		}
		
		function anytech_password_on()
		{
			$('.anytech-popup-recover').fadeOut('slide');
			setTimeout("$('.anytech-popup-password').fadeIn('slide');",500);
		}
		
		function anytech_password_off()
		{
			$('.anytech-popup-password').fadeOut('slide');
			setTimeout("$('.anytech-popup-recover').fadeIn('slide');",500);
		}
		
		
		
		$(function (){
		  $("#anytech_login_button").click(function (event) {
			event.preventDefault();
			var idElemento = $("#anytech_login");
			var deslocamento = $(idElemento).offset().top - 70;
			$('html, body').animate({ scrollTop: deslocamento }, 'slow');
		  });
		});

		$(function (){
		  $("#anytech_signup_label").click(function (event) {
			event.preventDefault();
			var idElemento = $("#anytech_signup");
			var deslocamento = $(idElemento).offset().top +60;
			$('html, body').animate({ scrollTop: deslocamento }, 'slow');
		  });
		});
		
		$(function (){
		  $("#anytech_footer_login").click(function (event) {
			event.preventDefault();
			var idElemento = $("#anytech_login");
			var deslocamento = $(idElemento).offset().top - 70;
			$('html, body').animate({ scrollTop: deslocamento }, 'slow');
		  });
		});
		
		//function verifica se esta logado e carrega as informacoes vinculadas a conta
		function carregaDadosMensagem(){
			var aux_mensagem_nome = "<?php echo $linha_Usuario['nm_usuario_completo']; ?>"
			var aux_mensagem_email = "<?php echo $linha_Usuario['nm_email']; ?>"
			$("#mensagem_nome").val(aux_mensagem_nome);
			$("#mensagem_email").val(aux_mensagem_email);
		}
		
		//Variavel javascript indicadora se esta logado 
		var logado = "<?php echo $logado;?>";
		
		if(logado == 1 ){
				carregaDadosMensagem();
		}else{}
		
		function enviaDadosMensagem(){
			
			var aux_mensagem_nome = $("#mensagem_nome").val();
			var aux_mensagem_email = $("#mensagem_email").val();
			var aux_mensagem_assunto = $("#mensagem_assunto").val();
			var aux_mensagem_mensagem = $("#mensagem_mensagem").val();
			
			if (aux_mensagem_nome == "")
			{
			}
			else if (aux_mensagem_email == "")
			{
			}
			else if (aux_mensagem_assunto == "")
			{
			}
			else if (aux_mensagem_mensagem == "")
			{
			}
			else
			{
				if(cod_usuario != "null"){
					var mensagem_interno_externo = 1;
				}
				else{
					var mensagem_interno_externo = 0;	
				}
					
						
				$.ajax({
					url:'<?php echo VOLTAR; ?>php/EnviaMensagem.php',
					type:'POST',
					data:{Nome:aux_mensagem_nome, Email:aux_mensagem_email, Assunto:aux_mensagem_assunto, Mensagem:aux_mensagem_mensagem, Codigo:cod_usuario, InternoExterno: mensagem_interno_externo},
					success:function(retorno){
						if (logado == 0)
						{
							$("#mensagem_nome").val("");
							$("#mensagem_email").val("");
						}
						
						$("#mensagem_assunto").val("");
						$("#mensagem_mensagem").val("");
						alert(retorno);					
					}
				})
			}
		}
		
	</script>
</html>