<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Inserir Registo</h3>
		<?php
			session_start();
			include('functions.php');
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$_SESSION['typecnt'] = test_input($_POST["tipo_reg_count"]);
				if (empty($_POST["nome_registo"])) {
   					 die('Nome do registo nao preenchido');
  				}
				$_SESSION['nomeRegisto'] = test_input($_POST["nome_registo"]);
				$_SESSION['pageId'] = test_input($_POST["pag_id"]);
			}
			
			$sql = "SELECT nome FROM campo where userid = ".$_SESSION['id']." AND ativo=1 AND typecnt=".$_SESSION['typecnt']."";
			$result = $connection->query($sql);
		     	$rows = $result->fetchAll();
			
			if (count($rows) == 0){
				die('Operacao invalida: este tipo de registo nao possui campos');
			}
			$contador=1;
			$_SESSION['counter'] = count($rows);
	    	?>
        	<form method="post" action="inserir_registo.php">
        		<?php
			    	foreach ($rows as $row) {
        				echo($row[nome]);?>: <input type="text" name="<?php echo($contador); ?>" >
			        	<br><br>
			        	<?php $contador++; ?>
            		<?php } ?>
			<input type="submit" value="Inserir">
		</form>
		<?php
			echo("<br></br>");
			echo("<p><a href=\"inserir_registo_form.php?\">Retroceder</a></p>");		
			buttons();
			
			$connection->close();
		?>
	</body>
</html>
