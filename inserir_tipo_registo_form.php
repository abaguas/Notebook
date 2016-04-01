<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Inserir tipo de registo</h3>
		<?php
		       	session_start();
			include('functions.php');
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
		?> 
		<form method="post" action="inserir_tipo_registo.php"> 
			Nome do tipo de registo: <input type="text" name="nome_tipo_reg" >
			<br><br>
			<input type="submit" value="Inserir"> 
		</form>
		
		<?php
			buttons();
		?>
	</body>
</html>
