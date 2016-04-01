<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Retirar tipo de registo</h3>
	
		<?php
	     
			session_start();
		    
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			$sql = "SELECT nome, typecnt FROM tipo_registo where userid = ".$_SESSION['id']." AND ativo=1";
			$result = $connection->query($sql);
		     	$rows = $result->fetchAll();
			if (count($rows) == 0){
				die('Operacao invalida: nao possui tipos de registo');
			}
		?>
		<form method="post" action="retirar_tipo_registo.php">
		        Nome do tipo de registo: <select name = "tipo_reg_id">
	        	<?php
	        		foreach ($rows as $row) { ?>
               			<option value="<?php echo($row[typecnt]); ?> "> <?php echo($row[nome]); ?> </option>
                	<?php } ?>
	                </select>
		        <br><br>
		        <input type="submit" value="Retirar">
		</form>
		<?php
			echo("<br></br>");
			echo("<p><a href=\"main.php?\">Voltar ao Menu</a></p>");		
			echo("<br></br>");
			echo("<h7><a href=\"logout.php?\">Logout</a></h7>");
		
			$connection->close();
		?>
	</body>
</html> 
