<html>
	<body>
	<h2>Bloco de Notas</h2>
	<h4>Retirar p&aacute;gina</h4>
		<?php		
			session_start();
			include('functions.php');
		    
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
		    	
		   	if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$pageId = test_input($_POST["pag_id"]);
			}
			
			try{
				$connection->beginTransaction();
			

				//criar page counter da nova pagina (apagada)
				$newPageCounter = geraId(pagecounter, pagina, $connection);
			
				//obter pagecounter da pagina
				$sql = "SELECT * from pagina WHERE userid=".$_SESSION['id']." AND pagecounter=$pageId AND ativa=1"; 
				$result = $connection->query($sql);
				if (!$result) {
					echo($sql);
			    	die('P&aacute;gina inexistente ' . mysql_error());
					//significa que alguem apagou antes da transacao comecar
				}
				$rows = $result->fetchAll();
			
				//receber novo idseq da nova entrada no log
				$idSeq = geraIdSeq($connection);
				
				//colocar ativa a 0
				$sql = "UPDATE pagina SET ativa=0 WHERE userid=".$_SESSION['id']." AND pagecounter=$pageId AND ativa=1"; 
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}
				$sql = "INSERT INTO pagina (userid, ppagecounter, nome, ativa, pagecounter, idseq)
						VALUES (".$rows[0][userid].", $pageId, '".$rows[0][nome]."', 0, $newPageCounter, $idSeq)";
				
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}
				$connection->commit();
  
			} catch (Exception $e) {
  				$connection->rollBack();
  				echo "Failed: " . $e->getMessage();
			}
			
			echo("<br></br>");
			echo("<p>P&aacute;gina removida com sucesso</p>");
			
			buttons();
			
			$connection->close();
		?>
	</body>
</html>  
 
