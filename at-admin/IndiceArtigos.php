<?php
	session_start();
	define('VOLTAR', '../');
	include VOLTAR.'php/Conexao.php';
	include VOLTAR.'php/ConexaoPrincipal.php';
	
	if (!isset($_SESSION['AnyTech']['codigoUsuario']))
	{
		$logado = 0;
		$cod_usuario = "null";
		$linha_Usuario['nm_usuario_completo'] = "";
		$linha_Usuario['nm_email'] = "";
		
		header('location: '.VOLTAR.'/login?url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	}
	else
	{
		$logado = 1;
		
		$codigoUsuario = $_SESSION['AnyTech']['codigoUsuario'];
		$nivelUsuario = $_SESSION['AnyTech']['nivelUsuario'];
		
		if (!($nivelUsuario > 1))
		{
			header('location: '.VOLTAR.'index.php');
		}
		
		$result_Usuario = $conexaoPrincipal -> Query("select nm_usuario_completo, nm_email, im_perfil, cd_nivel_cadastro from tb_usuario where cd_usuario = '$codigoUsuario'");
		$linha_Usuario = mysqli_fetch_assoc($result_Usuario);
		
		$nomeUsuario = $linha_Usuario['nm_usuario_completo'];
		$imagemUsuario = $linha_Usuario['im_perfil'];
		$nivelCadastro = $linha_Usuario['cd_nivel_cadastro'];
		
		if ($nivelCadastro < 4)
		{
			header('Location: '.VOLTAR.'signup/');
		}
	}
	
	$result_artigos = $conexaoPrincipal -> Query("select * from tb_artigo order by dt_criacao desc;");
	$linha_artigos = mysqli_fetch_assoc($result_artigos);
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Índice de Artigos</title>
		<style>
			*
			{
				font-family: century gothic;
				margin: 0px; padding: 0px;
			}
			
			body
			{
				background-color: #666;
			}
			
			.item-artigo
			{
				display: inline-block;
				width: 94%;
				padding: 2%;
				margin: 1%;
				background-color: white;
				box-shadow: 0px 2px 3px rgba(0,0,0,0.3);
				margin-bottom: 10px;
			}
			
			.titulo-artigo
			{
				displaY: inline-block;
				width: 100%;
				font-size: 1.4em;
				color: black;
				font-weight: bold;
			}
			
			.data-artigo
			{
				displaY: inline-block;
				width: 100%;
				font-size: 1em;
				color: black;
			}
			
			.busca-artigo
			{
				displaY: inline-block;
				width: 100%;
				font-size: 1.4em;
				color: #555;
				font-weight: bold;
				outline: none;
				border: 0px;
			}
		</style>
	</head>
	<body>
		<div class="item-artigo">
			<input type = "text" class="busca-artigo" placeholder="Buscar..."/>
		</div>
		<div class="item-artigo">
			<table>
				<tr>
					<td>
						<input type="radio" name="tosearch">
					</td>
					
					<td>
						<span style="margin-right: 50px;">Todos</span>
					</td>
					
					<td>
						<input type="radio" name="tosearch">
					</td>
					
					<td>
						<span style="margin-right: 50px;">Publicados</span>
					</td>
					
					<td>
						<input type="radio" name="tosearch">
					</td>
					
					<td>
						<span style="margin-right: 50px;">Pendentes</span>
					</td>
				</tr>
			</table>
		</div>
		<div class="tutti">
			<?php
				if ($linha_artigos > 0)
				{
					do
					{
					?>
						<div class="item-artigo">
							<a href="https://www.anytech.com.br/at-admin/EditorArtigo.php?codigoArtigo=<?php echo $linha_artigos['cd_artigo']; ?>"><span class="titulo-artigo"><?php echo $linha_artigos['nm_titulo']; ?></span></a>
							<span class="data-artigo"><?php if($linha_artigos['ic_artigo_pendente'] == 1){echo 'Pendente';} else {echo 'Publicado';} ?></span>
						</div>
					<?php
					}
					while ($linha_artigos = mysqli_fetch_assoc($result_artigos));
				}
			?>						
		</div>
	</body>
</html>