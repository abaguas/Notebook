<html>
	<body> 
		<h2>Bloco de Notas</h2>
		<h4>Retirar p&aacute;gina</h4>
		<?php
			session_start();
			include 'functions.php';
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			$nCampos = $_SESSION['counter'];
			$arrayValoresCampos = array();
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				for ($i = 0; $i <= $nCampos; $i++) {
   					array_push($arrayValoresCampos, test_input($_POST["$i"]));
				}
			}
			
			$typecnt = $_SESSION['typecnt'];
			$nomeRegisto = $_SESSION['nomeRegisto'];
			$pageId = $_SESSION['pageId'];
			
			try{
				$connection->beginTransaction();

				$regCounter = geraId('regcounter', 'registo', $connection);
			
				//obter os campos do tipo de registo
				$i=0;
				$sql = "SELECT campocnt FROM campo WHERE userid=".$_SESSION['id']." AND typecnt=$typecnt";
				$result = $connection->query($sql);
				if (!$result) {
				    	die('Invalid query: ' . mysql_error());
				}
				$rows = $result->fetchAll();
			
			
							
				//inserir novo registo
				$idSeq = geraIdSeq($connection);
				
				$sql = "INSERT INTO registo (userid, typecounter, regcounter, nome, ativo, idseq, pregcounter)
					VALUES (".$_SESSION['id'].", $typecnt, $regCounter, '$nomeRegisto', 1, $idSeq, NULL)";
		
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}
				
				//inserir novos valores nos campos				
				foreach ($rows as $row){
					$i++;
					$idSeq = geraIdSeq($connection);
					
					$sql = "INSERT INTO valor (userid, typeid, regid, campoid, valor, idseq, ativo, pcampoid)
						VALUES (".$_SESSION['id'].", $typecnt, $regCounter, ".$row[campocnt].", '$arrayValoresCampos[$i]', $idSeq, 1, NULL)";
						
					if ($connection->query($sql) === FALSE) {
			    			die( "Error: " . $sql . "<br>" . $conn->error);
					}
				}
				
				//inserir registo na pagina
				$idSeq = geraIdSeq($connection);
				
				$sql = "INSERT INTO reg_pag (userid, pageid, typeid, regid, idseq, ativa, pidregpag)
						VALUES (".$_SESSION['id'].", $pageId, $typecnt, $regCounter, $idSeq, 1, NULL)";
				if ($connection->query($sql) === FALSE) {
		    			die( "Error: " . $sql . "<br>" . $conn->error);
				}
				
				$connection->commit();
  
			} catch (Exception $e) {
  				$connection->rollBack();
  				echo "Failed: " . $e->getMessage();
			}
					
			echo("<br></br>");
			echo("<p>Registo inserido com sucesso</p>");
			buttons();
			
			$connection->close();
			
		?>
	</body>
</html>
