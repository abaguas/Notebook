<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Retirar p&aacute;gina</h3>
		<?php
	     
		    	session_start();
			include('functions.php');		    
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			$sql = "SELECT nome, pagecounter FROM pagina where userid = ".$_SESSION['id']." AND ativa=1";
			$result = $connection->query($sql);
			$rows = $result->fetchAll();
			
			if (count($rows) == 0){
				die('Operacao invalida: nao possui p&aacute;ginas');
			}
		?>
	        <form method="post" action="retirar_pagina.php">
		        Nome da p&aacute;gina: <select name = "pag_id">
	        	<?php
	        		foreach ($rows as $row) { ?>
               			<option value="<?php echo($row[pagecounter]); ?> "> <?php echo($row[nome]); ?> </option>
                	<?php } ?>
        	        </select>
		        <br><br>
		        <input type="submit" value="Retirar">
		</form>
		<?php
			buttons();
			
			$connection->close();
		?>
	</body>
</html> 
