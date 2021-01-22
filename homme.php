<!DOCTYPE html>
<html>
	<head>
		<title>ANYTECH - Levando a tecnologia até você</title>	
		<meta charset="utf-8">
		<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
		<meta property="fb:app_id" content="701955103277894">
		<meta property="og:locale" content="pt_BR">
		<meta property="og:type" content="ANYTECH">
		<meta property="og:title" content="ANYTECH - Levando a Tecnologia Até Você" />
		<meta property="og:description" content="A ANYTECH desenvolve sistemas e soluções inteligentes para o você. O melhor em criação de aplicativos, websites, softwares e muitos outros serviços." />
		<meta property="og:url" content="https://www.anytech.com.br/index.php" />
		<meta property="og:site_name" content="ANYTECH"/> 
		<meta property="og:image" content="https://www.anytech.com.br/images/anytech-desenvolvimento-de-sistemas-e-aplicativos.png">
		<meta property="og:image:type" content="image/jpeg">
		<meta property="og:image:width" content="800">
		<meta property="og:image:height" content="600">		
		<meta name="twitter:card" content="photo">
		<meta name="twitter:url" content="https://www.anytech.com.br/index.php">
		<meta name="twitter:title" content="ANYTECH - Desenvolvimento de Sistemas e Aplicativos">
		<meta name="twitter:description" content="A ANYTECH desenvolve sistemas e soluções inteligentes para o você. O melhor em criação de aplicativos, websites, softwares e muitos outros serviços">
		<meta name="twitter:image" content="https://www.anytech.com.br/images/anytech-desenvolvimento-de-sistemas-e-aplicativos.png">
		<meta name="theme-color" content="#000000"> 		 
		<meta charset="UTF-8">	
		<meta name="google-site-verification" content="LHwdJcSUU1ZulIu-GK3tqGfkliNNViDbzvZWIB6ZwUo" />
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta name="robots" content="index, follow">
		<meta name="description" content="A ANYTECH desenvolve sistemas e soluções inteligentes para o você. O melhor em criação de aplicativos, websites, softwares e muitos outros serviços">
		<meta name="keywords" content="anytech desenvolvimento aplicativos em santos baixada santista sites apps app software empresa"/>
		<meta name="googlebot" content="index, follow">
		<meta name="author" content="ANYTECH">
		<meta name="google" content="notranslate" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="alternate" href="http://www.anytech.com.br" hreflang="pt-br" />
		<link rel="shortcut icon" type="image/png" href="images/icons/anytech-transparent-logo.png" alt="ANYTECH"/>
		<link rel="stylesheet" type="text/css" href="css/anytech-slider.css">
		<link rel="stylesheet" type="text/css" href="css/anytech-style-new.css">

		<script>

			
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '137808586645951');
		fbq('track', "PageView");</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=137808586645951&ev=PageView&noscript=1"
		/></noscript>
		<!-- End Facebook Pixel Code -->
		
		<!-- GOOGLE ANALYTICS-->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-80717206-1', 'auto');
		  ga('send', 'pageview');

	
		  window.fbAsyncInit = function() {
			FB.init({
			  appId      : '701955103277894',
			  xfbml      : true,
			  version    : 'v2.5'
			});
		  };

		  (function(d, s, id){
			 var js, fjs = d.getElementsByTagName(s)[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement(s); js.id = id;
			 js.src = "//connect.facebook.net/en_US/sdk.js";
			 fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		   
		</script>
	</head>

	<?php
		
		if($_GET['at'] == 'eletrontech'){
			
			//eader('Location: https://play.google.com/store/apps/details?id=com.Anytech.EletronTech');
				//e();
		
			?>
			<script>
			
				window.location.replace("https://play.google.com/store/apps/details?id=com.Anytech.EletronTech");	
			</script>
		<?php
		}

		function isMobile() {
		    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
		}



		if(isMobile()){

			include('include-mobile.php');

		}
		else{

			/*if(isset($_GET['mb'])){

				include('include-mobile.php');

			}
			else{*/

				include('include-desktop.php');

			/*}*/

		}


		?>
		
		<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="code" value="36FEE63C5252343DD4FF5FBB0C3F8F62" />
<input type="hidden" name="iot" value="button" />
<input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/120x53-comprar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

	
	 
	<!--	 <script type="text/javascript" src="js/jssor.slider-21.1.5.min.js"></script>-->
	 <script type="text/javascript" src="js/ajax.js"></script>
	 <script type="text/javascript" src="js/jquery.min.js"></script>
	 <script>
        //jssor_1_slider_init();

        window.onload = function(){

        	/*if(window.innerWidth <= 800 && window.innerHeight <= 600) {
			     window.open('www.anytech.com.br/?mb=7')
			   }*/
        }

        function orcamentoIn(){
        	modalOrcamento.style.marginTop = '0px';
        	modalOrcamento.style.display = "inline-block";
        }

        function orcamentoOut(){
        	modalOrcamento.style.display = "none";
        }

        function alteraServico(val){
        	if(val == 'Aplicativo'){
        		app_so.style.display = "table";
        	}
        	else{
        		app_so.style.display = "none";	
        	}
        }


        function orcamentoEnvia(){

        	tpC = 0;

        	nome = or_text_name.value;
        	email = or_text_mail.value;
        	assunto = or_select_assunto.value;
        	mensagem = document.getElementsByName('or_text_mensagem')[0].value;

        	if(chk_android.checked == true){

        		android = '1';
        		tpC++;
        	}
        	else{

        		android = '0';
        	}


        	if(chk_ios.checked == true){

        		ios = '1';
        		tpC++;
        	}
        	else{

        		ios = '0';
        	}

        	if(chk_wp.checked == true){

        		windowsphone = '1';
        		tpC++;
        	}
        	else{

        		windowsphone = '0';
        	}

        	if(chk_wa.checked == true){

        		webapp = '1';
        		tpC++;
        	}
        	else{

        		webapp = '0';
        	}

        	if(assunto == 'Aplicativo' && tpC == 0){

				alert("Favor selecione uma plataforma de desenvolvimento!");

        	}
        	else{


	        	if(nome == "" || email == "" || assunto == "" || mensagem == ""){

	        		alert("Favor preencher todos os campos solicitados!");

	        		if(nome == ""){

	        			or_text_name.focus();
	        		}
	        		else if(email == ""){

	        			or_text_mail.focus();

	        		}
	        		else if(assunto == ""){

	        			or_select_assunto.focus();

	        		}
	        		else if(mensagem == ""){

	        			at_contato_mensagem.focus();

	        		}

	        	
	        	}
	        	else{

	        		 $.ajax({

					  url: 'php/enviarMensagemContato.php',
					  type: "POST",
					  data: {
					  	nome: nome,
					  	email: email,
					  	mensagem: mensagem,
					  	assunto: assunto,
					  	android: android,
					  	ios: ios,
					  	windowsphone: windowsphone,
					  	webapp: webapp

					  },
					  success: function(data){
					    
					    if(data == 1){

					    	alert("Sua mensagem foi enviada com sucesso! Entraremos em contato em breve!");
					    	or_text_name.value = "";
					    	or_select_assunto.selectIndex = 0;
					    	document.getElementsByName('or_text_mensagem')[0].value = "";
					    	or_text_mail.value = "";
					    	chk_android.checked = false;
					    	chk_ios.checked = false;
					    	chk_wp.checked = false;
					    	chk_wa.checked = false;

						}
						else{

							alert("Desculpe! Ocorreu um erro, tente novamente mais tarde!");
						}
					  
					  }
					
					});  



	        	}

	        }




        }

        function enviarMensagem(){

        	nome = at_text_name.value;
        	email = at_text_mail.value;
        	assunto = at_text_title.value;
        	mensagem = document.getElementsByName('at_text_mensagem')[0].value;

        	if(nome == "" || email == "" || assunto == "" || mensagem == ""){

        		alert("Favor preencher todos os campos solicitados!");

        		if(nome == ""){

        			at_text_name.focus();
        		}
        		else if(email == ""){

        			at_text_mail.focus();

        		}
        		else if(assunto == ""){

        			at_text_title.focus();

        		}
        		else if(mensagem == ""){

        			at_contato_mensagem.focus();

        		}

        	
        	}
        	else{

		        $.ajax({

				  url: 'php/enviarMensagemContato.php',
				  type: "POST",
				  data: {
				  	nome: nome,
				  	email: email,
				  	mensagem: mensagem,
				  	assunto: assunto,
				  	android: '0',
					ios: '0',
					windowsphone: '0',
					webapp: '0'
				  },
				  success: function(data){
				    
				    if(data == 1){

				    	alert("Sua mensagem foi enviada com sucesso! Entraremos em contato em breve!");
				    	at_text_name.value = "";
				    	at_text_title.value = "";
				    	document.getElementsByName('at_text_mensagem')[0].value = "";
				    	at_text_mail.value = "";

					}
					else{

						alert("Desculpe! Ocorreu um erro, tente novamente mais tarde!");
					}
				  
				  }
				
				});  
	    	}      


    	}


    </script>
</html>