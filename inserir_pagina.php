<html>
	<body> 
		<h2>Bloco de Notas</h2>
		<h4>Inserir P&aacute;gina</h4>
		<?php
		
			session_start();
			include('functions.php');
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
		   		if (empty($_POST["nome_pag"])) {
   					 die('Nome da pagina nao preenchida');
  				}
				$nomePag = test_input($_POST["nome_pag"]);
			}
					
			try{	
				$connection->beginTransaction();

				$pageCounter = geraId(pagecounter, pagina, $connection);
				
				$idSeq = geraIdSeq($connection);
				
				$sql = "INSERT INTO pagina (userid, ppagecounter, nome, ativa, pagecounter, idseq)
						VALUES (".$_SESSION['id'].", NULL, '$nomePag', 1, $pageCounter, $idSeq)";		
				if ($connection->query($sql) === FALSE) {
		    			die( "Error: " . $sql . "<br>" . $conn->error);
				}
				$connection->commit();
  
			} catch (Exception $e) {
  				$connection->rollBack();
  				echo "Failed: " . $e->getMessage();
			}			
			echo("<br></br>");
			echo("<p>P&aacute;gina inserida com sucesso</p>");
			buttons();
			
			$connection->close();
		?>
	</body>
</html>
