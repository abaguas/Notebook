<html>
    <body>
	<h2>Bloco de Notas</h2>
	<h3>Inserir campo</h3>
	<?php
	     
    		session_start();
		include('functions.php');
			
		echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
		$connection=createConnection();
			
		$sql = "SELECT nome, typecnt FROM tipo_registo WHERE userid = ".$_SESSION['id']." AND ativo=1";
			
		$result = $connection->query($sql);
	
	     	$rows = $result->fetchAll();
			
		if (count($rows) == 0){
			die('Operacao invalida: nao possui tipos de registo para este utilizador');
		}
	?>
        <form method="post" action="inserir_campo.php"> 
		Nome do campo: <input type="text" name="nome_campo" >
	        <br><br>
	        Nome do tipo de registo: <select name = "tipo_reg_id">
	      	<?php
	       		foreach ($rows as $row) { ?>
         		<option value="<?php echo($row[typecnt]); ?> "> <?php echo($row[nome]); ?> </option>
                <?php } ?>
                </select>
		<br><br>
	        <input type="submit" value="Inserir">
	</form>
	<?php
		buttons();
			
		$connection->close();
	?>
    </body>
</html> 
