<html>
	<body> 
		<h2>Bloco de Notas</h2>
		<h3>Inserir registo</h3>
		<?php
	     
			session_start();
			include('functions.php');
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
			
			$connection=createConnection();
			
			$sql = "SELECT nome, typecnt FROM tipo_registo where userid = ".$_SESSION['id']." AND ativo=1";
			$result = $connection->query($sql);
		     	$rows = $result->fetchAll();
			if (count($rows) == 0){
				die('Operacao invalida: nao possui p&aacute;ginas');
			}
			$sql = "SELECT nome, pagecounter FROM pagina where userid = ".$_SESSION['id']." AND ativa=1";
			$result = $connection->query($sql);
	     		$paginas = $result->fetchAll();
			if (count($paginas) == 0){
				die('Operacao invalida: nao possui p&aacute;ginas');
			}
	    	?>
        	<form method="post" action="inserir_registo_form2.php">
        		Nome do registo: <input type="text" name="nome_registo" >
		        <br><br>
		        Nome do tipo de registo: <select name = "tipo_reg_count">
		       	<?php
		       		foreach ($rows as $row) { ?>
                		<option value="<?php echo($row[typecnt]); ?> "> <?php echo($row[nome]); ?> </option>
                	<?php } ?>
                	</select>
                	<br><br>
                	Nome da p&aacute;gina: <select name = "pag_id">
		        <?php
		        	foreach ($paginas as $pagina) { ?>
                		<option value="<?php echo($pagina[pagecounter]); ?> "> <?php echo($pagina[nome]); ?> </option>
                	<?php } ?>
                	</select>
		        <br><br>
		        <input type="submit" value="Seguinte">
		</form>
		<?php
			buttons();
			
			$connection->close();
		?>
	</body>
</html> 
 
