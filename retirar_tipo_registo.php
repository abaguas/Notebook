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
				$typeCounter = test_input($_POST["tipo_reg_id"]);
			}
			
			//obter dados da pagina
			$sql = "SELECT * from tipo_registo WHERE userid=".$_SESSION['id']." AND typecnt=$typeCounter AND ativo=1"; 
			$result = $connection->query($sql);
			if (!$result) {
		    	die('Tipo de registo inexistente ' . mysql_error());
				//significa que alguem apagou antes da transacao comecar
			}
			$rows = $result->fetchAll();
			
			//criar counter do novo tipo de registo (apagado)
			$newTypeCounter = geraId(typecnt, tipo_registo, $connection);
			
			try{
				$connection->beginTransaction();
				//receber novo idseq da nova entrada no log
				$idSeq = geraIdSeq($connection);
			
				//colocar ativa a 0
				$sql = "UPDATE tipo_registo SET ativo=0 WHERE userid=".$_SESSION['id']." AND typecnt=$typeCounter AND ativo=1"; 
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}
				
				$sql = "INSERT INTO tipo_registo (userid, ptypecnt, nome, ativo, typecnt, idseq)
						VALUES (".$rows[0][userid].", ".$rows[0][typecnt].", '".$rows[0][nome]."', 0, $newTypeCounter, $idSeq)";
				if ($connection->query($sql) === FALSE) {
			    		die( "Error: " . $sql . "<br>" . $conn->error);
				}
				$connection->commit();
  
			} catch (Exception $e) {
  				$connection->rollBack();
  				echo "Failed: " . $e->getMessage();
			}
			
			echo("<br></br>");
			echo("<p>Tipo de registo removido com sucesso</p>");
			buttons();
			
			$connection->close();		
		?>
	</body>
</html>  
 
