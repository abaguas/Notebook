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
			if (empty($_POST["nome_campo"])) {
   				die('Nome do campo nao preenchido');
  			}
			$nomeCampo = test_input($_POST["nome_campo"]);
			$typeCounter = test_input($_POST["tipo_reg_id"]);
		}
		try{	
			$connection->beginTransaction();
	
			$campoCounter = geraId(campocnt, campo, $connection);
			
			$connection->beginTransaction();
				
			$idSeq = geraIdSeq($connection);

			$sql = "INSERT INTO campo (userid, typecnt, campocnt, idseq, ativo, nome, pcampocnt)
				VALUES (".$_SESSION['id'].", $typeCounter, $campoCounter, $idSeq, 1, '$nomeCampo', NULL)";		

			if ($connection->query($sql) === FALSE) {
		    		die( "Error: " . $sql . "<br>" . $conn->error);
			}
				$connection->commit();
  
		} catch (Exception $e) {
  			$connection->rollBack();
  			echo "Failed: " . $e->getMessage();
		}
		
		echo("<br></br>");
		echo("<p>Campo inserido com sucesso</p>");
		echo("<br></br>");
		echo("<p><a href=\"inserir_campo_form.php?\">Inserir novo campo</a></p>");
		buttons();
		
		$connection->close();
	?>
    </body>
</html>  
