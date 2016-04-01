<html>
	<body> 
		<h2>Bloco de Notas</h2>
		<h3>Retirar Campo</h3>
		
		<?php
		    	include 'functions.php';
		    	session_start();
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$_SESSION['aux'] = test_input($_POST["tipo_reg_count"]);
			}
			
			$sql = "SELECT nome, campocnt FROM campo where userid = ".$_SESSION['id']." AND ativo=1 AND typecnt=".$_SESSION['aux']."";
			
			$result = $connection->query($sql);
			
		     	$rows = $result->fetchAll();
			
			if (count($rows) == 0){
				die('Operacao invalida: este tipo de registo nao possui campos');
			}
		?>
		<form method="post" action="retirar_campo.php">
		        Nome do campo: <select name = "campo_id">
		        	<?php
		        		foreach ($rows as $row) { ?>
                			<option value="<?php echo($row[campocnt]); ?> "> <?php echo($row[nome]); ?> </option>
                	<?php } ?>
	                </select>
		        <br><br>
		        <input type="submit" value="Remover">
		</form>
		<?php
			echo("<br></br>");
			echo("<p><a href=\"retirar_campo_form.php?\">Retroceder</a></p>");		
			
			buttons();
			
			$connection->close();
		?>
	</body>
</html> 
 
 
