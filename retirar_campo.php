<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h4>Retirar campo</h4>
		<?php
		
			session_start();
			include 'functions.php';
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
		   	if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$campoId = test_input($_POST["campo_id"]);
			}
			
			$typeCounter = $_SESSION['aux'];
			
			try{
				$connection->beginTransaction();
						
				//criar campocnt do novo campo (apagado)
				$newCampoCounter = geraId(campocnt, campo, $connection);
			
				//obter informacao do campo
				$sql = "SELECT * from campo WHERE userid=".$_SESSION['id']." AND campocnt=$campoId AND typecnt=$typeCounter AND ativo=1"; 
				$result = $connection->query($sql);
				$rows = $result->fetchAll();
				if (count($rows)<1) {
					echo("<p>$sql</p>");
			    	die('Campo inexistente' . mysql_error());
					//significa que alguem apagou antes da transacao comecar
				}
				$nomeCampo = $rows[0]['nome'];		
			
			
				//receber novo idseq da nova entrada no log
				$idSeq = geraIdSeq($connection);
					
				//colocar ativa a 0
				$sql = "UPDATE campo SET ativo=0 WHERE userid=".$_SESSION['id']." AND campocnt=$campoId AND ativo=1"; 
					
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}
					
				$sql = "INSERT INTO campo (userid, typecnt, campocnt, idseq, ativo, nome, pcampocnt)
						VALUES (".$rows[0][userid].", ".$rows[0][typecnt].", $newCampoCounter, $idSeq, 0, '$nomeCampo', $campoId)";
					
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}	
			
				$connection->commit();
  
			} catch (Exception $e) {
  				$connection->rollBack();
  				echo "Failed: " . $e->getMessage();
			}
					
			echo("<br></br>");
			echo("<p>Campo removido com sucesso</p>");
			buttons();
			
			$connection->close();		
		?>
	</body>
</html>
