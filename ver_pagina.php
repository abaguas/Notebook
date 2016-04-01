<html>
	<body> 
	<h2>Bloco de Notas</h2>
	<h4>Ver p&aacute;gina</h4>
		<?php
		
			session_start();
			include('functions.php');
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
		   	if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$idPagina = test_input($_POST["pag_id"]);
			}
			
			//acede aos regid dos registos ativos numa pagina
			$sql = "SELECT regid FROM reg_pag WHERE userid=".$_SESSION['id']." AND pageid=$idPagina AND ativa=1";
			$result = $connection->query($sql);
			$regIds = $result->fetchAll();
			
						
			//acede ao nome da pagina
			$sql = "SELECT nome FROM pagina WHERE userid=".$_SESSION['id']." AND pagecounter= $idPagina LIMIT 1";
			$result = $connection->query($sql);
			$rows = $result->fetchAll();
			echo("<h3> ".$rows[0][nome]." </h3>");
			
			if (count($regIds)<1){
				echo("<p>Pagina vazia</p>");
			}		
			foreach($regIds as $regId){
				$sql = "SELECT typecounter, nome FROM registo WHERE userid=".$_SESSION['id']." AND regcounter=".$regId[regid]." AND ativo=1";
				$result = $connection->query($sql);
				$registo = $result->fetchAll();
				
				echo("<b>Registo: </b> ".$registo[0][nome]." ");
				echo("<br></br>");
				$typeId = $registo[0][typecounter];
			
				$sql = "SELECT tipo_registo.nome AS nome_tipo, campo.nome AS nome_campo, valor.valor AS valor FROM
				 tipo_registo JOIN campo ON (tipo_registo.userid = campo.userid AND tipo_registo.typecnt=campo.typecnt 
				 AND tipo_registo.ativo=campo.ativo) JOIN valor ON (tipo_registo.userid=valor.userid AND
				 tipo_registo.typecnt=valor.typeid AND campo.campocnt = valor.campoid AND tipo_registo.ativo=valor.ativo)
				 WHERE tipo_registo.userid=".$_SESSION['id']." AND tipo_registo.ativo=1 AND valor.regid = ".$regId[regid]." ";
				
				$result = $connection->query($sql);
				if (!$result) {
		    			echo('Este tipo de registo nao tem campos');
				}
				$valores = $result->fetchAll();

				if (count($valores)<1){
					echo("<p>Registo vazio</p>");
				}
				else{
					echo("<b>Tipo do registo: </b> ".$valores[0][nome_tipo]." ");
					foreach ($valores as $valor){
						echo("<br></br>");
						echo("<b> ".$valor[nome_campo].": </b> ".$valor[valor]." ");
					}
					echo("<br></br>");
				}
				echo("<br></br>");
				
			}
			
			buttons();
			
			$connection->close();
		?>
	</body>
</html>  
 
 
