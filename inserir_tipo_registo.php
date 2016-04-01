<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h4>Inserir tipo de registo</h4>
		<?php
		
			session_start();
			include('functions.php');
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
		   	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		   		if (empty($_POST["nome_tipo_reg"])) {
   					 die('Nome do tipo de registo nao preenchido');
  				}
				$nomeTipoRegisto = test_input($_POST["nome_tipo_reg"]);
			}
			
			try{
				$connection->beginTransaction();

				$typeCounter = geraId(typecnt, tipo_registo, $connection);	
			
				$idSeq = geraIdSeq($connection);
				
				$sql = "INSERT INTO tipo_registo (userid, ptypecnt, nome, ativo, typecnt, idseq)
						VALUES (".$_SESSION['id'].", NULL, '$nomeTipoRegisto', 1, $typeCounter, $idSeq)";
				if ($connection->query($sql) === FALSE) {
		    			die( "Error: " . $sql . "<br>" . $conn->error);
				}
				$connection->commit();
  
			} catch (Exception $e) {
  				$connection->rollBack();
  				echo "Failed: " . $e->getMessage();
			}
			
			echo("<br></br>");
			echo("<p>Tipo de registo inserido com sucesso</p>");
			
			buttons();
			
			$connection->close();
		?>
	</body>
</html> 
