<?php
	session_start();
	include 'Conexao.php';
	include 'ConexaoPrincipal.php';
	
	if (!isset($_POST['etapaOrcamento']))
	{
		exit;
	}
	
	if (isset($_COOKIE['AnyTech']['codigoOrcamento']))
	{
		$cookie = 1;
		$codigoOrcamento = $_COOKIE['AnyTech']['codigoOrcamento'];
	}
	else
	{
		$cookie = 0;
	}
	
	$etapaOrcamento = mysql_escape_string($_POST['etapaOrcamento']);
	
	if ($etapaOrcamento == 1)
	{
		$nomeUsuario = mysql_escape_string($_POST['nomeUsuario']);
		$dateTime = date('Y-m-d H:i:s');
		
		if ($cookie == 0)
		{
			$result = $conexaoPrincipal -> Query("insert into tb_orcamento(nm_usuario, dt_orcamento) values('$nomeUsuario', '$dateTime')");
			
			if ($result)
			{
				echo 1;
				
				$result = $conexaoPrincipal -> Query("select cd_orcamento from tb_orcamento where dt_orcamento = '$dateTime'");
				$linha = mysqli_fetch_array($result);
				$codigoOrcamento = $linha[0];
				
				setcookie("AnyTech[codigoOrcamento]", $codigoOrcamento, time() + (86400 * 7), "/"); // 86400 = 1 day
				
				if (!isset($_COOKIE['AnyTech']['codigoOrcamento']))
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
				else if ($_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
			else
			{
				//echo mysqli_error($conexaoPrincipal -> getConexao());
			}
		}
		else
		{
			$result = $conexaoPrincipal -> Query("update tb_orcamento set nm_usuario = '$nomeUsuario' where cd_orcamento = '$codigoOrcamento'");
			
			if ($result)
			{
				echo 1;
			}
			else
			{
				//echo mysqli_error($conexaoPrincipal -> getConexao());
			}
		}
	}
	else if ($etapaOrcamento == 2)
	{
		if ($cookie == 1)
		{
			$opcaoEtapa = mysql_escape_string($_POST['opcaoEtapa']);
			
			$result = $conexaoPrincipal -> Query("select * from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = '$opcaoEtapa'");
			$total = mysqli_num_rows($result);
			
			if ($total == 0)
			{
				$result = $conexaoPrincipal -> Query("insert into orcamento_servico(cd_orcamento, cd_servico) values ('$codigoOrcamento', '$opcaoEtapa')");
				
				if ($result)
				{
					echo 1;
					
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
				else
				{
					echo mysqli_error($conexaoPrincipal -> getConexao());
				}
			}
			else
			{
				echo 1;
					
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
		}
	}
	else if ($etapaOrcamento == 3)
	{
		if ($cookie == 1)
		{
			$opcaoEtapa = mysql_escape_string($_POST['opcaoEtapa']);
			
			$result = $conexaoPrincipal -> Query("select * from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = '$opcaoEtapa'");
			$total = mysqli_num_rows($result);
			
			if ($total == 0)
			{
				$result = $conexaoPrincipal -> Query("insert into orcamento_servico(cd_orcamento, cd_servico) values ('$codigoOrcamento', '$opcaoEtapa')");
				
				if ($result)
				{
					echo 1;
					
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
				else
				{
					echo mysqli_error($conexaoPrincipal -> getConexao());
				}
			}
			else
			{
				echo 1;
					
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
		}
	}
	else if ($etapaOrcamento == 4)
	{
		if ($cookie == 1)
		{
			$opcaoEtapa = mysql_escape_string($_POST['opcaoEtapa']);
			
			$result = $conexaoPrincipal -> Query("select * from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = '$opcaoEtapa'");
			$total = mysqli_num_rows($result);
			
			if ($total == 0)
			{
				$result = $conexaoPrincipal -> Query("insert into orcamento_servico(cd_orcamento, cd_servico) values ('$codigoOrcamento', '$opcaoEtapa')");
				
				if ($result)
				{
					echo 1;
					
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
				else
				{
					echo mysqli_error($conexaoPrincipal -> getConexao());
				}
			}
			else
			{
				echo 1;
					
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
		}
	}
	else if ($etapaOrcamento == 5)
	{
		if ($cookie == 1)
		{
			$opcaoEtapa = mysql_escape_string($_POST['opcaoEtapa']);
			
			$result = $conexaoPrincipal -> Query("select * from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = '$opcaoEtapa'");
			$total = mysqli_num_rows($result);
			
			if ($total == 0)
			{
				$result = $conexaoPrincipal -> Query("insert into orcamento_servico(cd_orcamento, cd_servico) values ('$codigoOrcamento', '$opcaoEtapa')");
				
				if ($result)
				{
					echo 1;
					
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
				else
				{
					echo mysqli_error($conexaoPrincipal -> getConexao());
				}
			}
			else
			{
				echo 1;
					
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
		}
	}
	else if ($etapaOrcamento == 6)
	{
		if ($cookie == 1)
		{
			$nomeProjetoEmpresa = mysql_escape_string($_POST['nomeProjetoEmpresa']);
			
			$result = $conexaoPrincipal -> Query("update tb_orcamento set nm_projeto_empresa = '$nomeProjetoEmpresa' where cd_orcamento = '$codigoOrcamento'");
				
			if ($result)
			{
				echo 1;
				
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
			else
			{
				//echo mysqli_error($conexaoPrincipal -> getConexao());
			}
		}
	}
	else if ($etapaOrcamento == 7)
	{
		if ($cookie == 1)
		{
			$opcaoEtapa = mysql_escape_string($_POST['opcaoEtapa']);
			
			$result = $conexaoPrincipal -> Query("select * from orcamento_servico where cd_orcamento = '$codigoOrcamento' and cd_servico = '$opcaoEtapa'");
			$total = mysqli_num_rows($result);
			
			if ($total == 0)
			{
				$result = $conexaoPrincipal -> Query("insert into orcamento_servico(cd_orcamento, cd_servico) values ('$codigoOrcamento', '$opcaoEtapa')");
				
				if ($result)
				{
					echo 1;
					
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
				else
				{
					echo mysqli_error($conexaoPrincipal -> getConexao());
				}
			}
			else
			{
				echo 1;
					
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
		}
	}
	else if ($etapaOrcamento == 8)
	{
		if ($cookie == 1)
		{
			if (isset($_POST['opcaoEtapa']))
			{
				$opcaoEtapa = array();
				
				foreach ($_POST['opcaoEtapa'] as $opcao)
				{
					array_push($opcaoEtapa, mysql_escape_string($opcao));
				}
				
				$aux = $opcaoEtapa[0];
				
				$result = $conexaoPrincipal -> Query("select cd_servico from tb_servico where cd_etapa = (select cd_etapa from tb_servico where cd_servico = '$aux')");
				$linha = mysqli_fetch_assoc($result);
				$total = mysqli_num_rows($result);
				
				$aux = '';
				$cont = 0;
				
				if ($total > 0)
				{
					do
					{
						$cont = $cont + 1;
						
						if ($cont == $total)
						{
							$aux = $aux.$linha['cd_servico'];
						}
						else
						{
							$aux = $aux.$linha['cd_servico'].',';
						}
					}
					while ($linha = mysqli_fetch_assoc($result));
				}
				
				$aux = explode(',', $aux);
				
				$query = "delete from orcamento_servico where cd_orcamento = '$codigoOrcamento' and (";
				
				$cont = 0;
				
				foreach ($aux as $opcao)
				{
					$cont = $cont + 1;
					
					if (count($aux) == $cont)
					{
						$query = $query."cd_servico = '$opcao'";
					}
					else
					{
						$query = $query."cd_servico = '$opcao' or ";
					}
				}
				
				$query = $query.')';
				
				$result = $conexaoPrincipal -> Query($query);
				
				if ($result)
				{
					$query = "insert into orcamento_servico(cd_orcamento, cd_servico) values ";
					
					$cont = 0;
				
					foreach ($opcaoEtapa as $opcao)
					{
						$cont = $cont + 1;
						
						if (count($opcaoEtapa) == $cont)
						{
							$query = $query."('$codigoOrcamento', '$opcao')";
						}
						else
						{
							$query = $query."('$codigoOrcamento', '$opcao'), ";
						}
					}
					
					$result = $conexaoPrincipal -> Query($query);
					
					if ($result)
					{
						echo 1;
						
						setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
					}
				}
			}
		}		
	}
	else if ($etapaOrcamento == 9)
	{
		if ($cookie == 1)
		{
			$descricaoProjeto = mysql_escape_string($_POST['descricaoProjeto']);
			
			$result = $conexaoPrincipal -> Query("update tb_orcamento set ds_orcamento = '$descricaoProjeto' where cd_orcamento = '$codigoOrcamento'");
			
			if ($result)
			{
				echo 1;
				
				if (isset($_COOKIE['AnyTech']['etapaOrcamento']) && $_COOKIE['AnyTech']['etapaOrcamento'] == $etapaOrcamento)
				{
					setcookie("AnyTech[etapaOrcamento]", $etapaOrcamento + 1, time() + (86400 * 7), "/"); // 86400 = 1 day
				}
			}
			else
			{
				//echo mysqli_error($conexaoPrincipal -> getConexao());
			}
		}
	}
	else if ($etapaOrcamento == 10)
	{
		if ($cookie == 1)
		{
			$email = mysql_escape_string($_POST['email']);
			
			$result = $conexaoPrincipal -> Query("update tb_orcamento set nm_email = '$email' where cd_orcamento = '$codigoOrcamento'");
			
			if ($result)
			{
				$result = $conexaoPrincipal -> Query("select sum(tb_servico.vl_servico) as vl_orcamento
														  from tb_orcamento inner join orcamento_servico
															on tb_orcamento.cd_orcamento = orcamento_servico.cd_orcamento
															  inner join tb_servico
																on orcamento_servico.cd_servico = tb_servico.cd_servico
																  where tb_orcamento.cd_orcamento = '$codigoOrcamento'");
				$linha = mysqli_fetch_assoc($result);
				
				echo '1;-;'.$linha['vl_orcamento'];
				
				include 'LimparOrcamento.php';
			}
			else
			{
				//echo mysqli_error($conexaoPrincipal -> getConexao());
			}
		}
	}
	
	$conexaoPrincipal -> FecharConexao();
?>