<?php
	$auxpasta = '../../artigo';
	$auxpastaimagem = '../../artigo/imagens';
	$caminho = 'imagens/';
	$auxcaminho = 'artigo/imagens';
			
	$_UP['pasta'] = '../../artigo/imagens/';
	
	header("Content-type: application/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<retorno>
	<aviso id="lbl_aviso">
		<?php
			if(!file_exists($auxpasta))
			{
				$pasta = mkdir($auxpasta);
				
				$pastaimagem = mkdir($auxpastaimagem);
			}
			
			if(!file_exists($auxpastaimagem))
			{
				$pastaimagem = mkdir($auxpastaimagem);
			}
			
			if (isset($_FILES['foto']))
			{
				$_UP['tamanho'] = 1024 * 1024 * 2; // 2MB
				$_UP['extensoes'] = array('jpg', 'jpeg', 'png');
				$_UP['renomeia'] = true;
				
				$_UP['erros'][0] = 'Não houve erro';
				$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
				$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
				$_UP['erros'][3] = 'O upload foi feito parcialmente';
				$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
				
				if ($_FILES['foto']['error'] != 0) //&& $_FILES['foto']['error'] != 4)
				{
					echo "Não foi possivel fazer o upload, erro: \n" . $_UP['erros'][$_FILES['foto']['error']];
				}
				
				$tmp = explode('.', $_FILES['foto']['name']);
				$extensao = strtolower(end($tmp));
				
				if (array_search($extensao, $_UP['extensoes']) === false)
				{
					if ($_FILES['foto']['error'] != 0) //&& $_FILES['foto']['error'] != 4)
					{
						echo 'Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.';
					}
					else
					{
						echo 'Por favor, envie arquivos com as seguintes extensões: jpg, jpeg ou png.';
					}
					
				}
				else if ($_UP['tamanho'] < $_FILES['foto']['size'])
				{
					echo 'O arquivo enviado é muito grande, envie arquivos de até 2MB.';
				}
				else
				{
					if ($_UP['renomeia'] == true)
					{
						$nome_final = time() . '.'.$extensao;
					}
					else
					{
						$nome_final = $_FILES['foto']['name'];
					}
					
					$nome_final = preg_replace( '/[´¨`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $nome_final ) );
					
					if (move_uploaded_file($_FILES['foto']['tmp_name'], $_UP['pasta'] . $nome_final))
					{
						$auxFoto = 1;
						
						$auxcaminho = $auxcaminho . '/' . $nome_final;
						
						echo 'Upload feito com sucesso!';
					}
					else
					{
						$auxFoto = 0;
						
						if ($_FILES['foto']['error'] != 0 && $_FILES['foto']['error'] != 4)
						{
							echo 'Não foi possivel enviar o arquivo, tente novamente';
						}							
					}
				}
			
				if ($_FILES['foto']['name'] != "" && $auxFoto == 1)
				{
					$foto = $caminho . $nome_final;
				}
				
				if ($_FILES['foto']['error'] == 0 && $auxFoto == 1)
				{
					
				}
			}
		?>
	</aviso>
	<indicador id="ic_adicionou">
		<?php echo $auxFoto; ?>
	</indicador>
	<arquivo id="nm_arquivo">
		<?php if (isset($foto)) {echo $foto;} ?>
	</arquivo>
</retorno>