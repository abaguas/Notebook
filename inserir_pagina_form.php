<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Inserir p&aacute;gina</h3>
		<?php
			session_start();
			include('functions.php');
			
			echo("<h5>Sess&atilde;o de {$_SESSION['nome']} </h5>");
		?>
	    	<form method="post" action="inserir_pagina.php"> 
		        Nome da p&aacute;gina: <input type="text" name="nome_pag" >
		        <br><br>
		        <input type="submit" value="Inserir"> 
		</form>
		<?php
			buttons();
		?>
	</body>
</html>
