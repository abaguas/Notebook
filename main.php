<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Menu</h3>
		<?php
	
			session_start();
			include('functions.php');
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$email = test_input($_POST["email"]);
				$pass = test_input($_POST["password"]);
			}
			else{
				$email = $_SESSION['email'];
				$pass = $_SESSION['pass'];
			}
			    
			$connection=createConnection();
				
			$sql = "SELECT * from utilizador where email='$email'";
			$result = $connection->query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$rows = $result->fetchAll();
			$rowCount = count($rows);
			
			if ($rowCount != 1) {
				die('Email inv&aacute;lido');
			}
			
			$database_pass = $rows[0]['password'];
			
			if ($database_pass != $pass){
				die('Password inv&aacute;lida');
			}
			
			$_SESSION['id'] = $rows[0]['userid'];
			$_SESSION['nome'] = $rows[0]['nome'];
			$_SESSION['email'] = $rows[0]['email'];
			$_SESSION['pass'] = $rows[0]['password'];
			
			
			echo("<h5>Ol&aacute; {$_SESSION['nome']} !</h5>");
		
			echo("<p><a href=\"inserir_pagina_form.php?\">Inserir uma nova pagina</a></p>");
			echo("<p><a href=\"inserir_tipo_registo_form.php?\">Inserir um novo tipo de registo</a></p>");
			echo("<p><a href=\"inserir_campo_form.php?\">Inserir novos campos para um tipo de registo</a></p>");
			echo("<p><a href=\"retirar_pagina_form.php?\">Retirar uma p&aacute;gina</a></p>");
			echo("<p><a href=\"retirar_tipo_registo_form.php?\">Retirar um tipo de registo</a></p>");
			echo("<p><a href=\"retirar_campo_form.php?\">Retirar um campo de um tipo de registo</a></p>");
			echo("<p><a href=\"inserir_registo_form.php?\">Inserir um registo</a></p>");
			echo("<p><a href=\"ver_pagina_form.php?\">Ver uma p&aacute;gina</a></p>");
					
			echo("<br></br>");
			echo("<h7><a href=\"logout.php?\">Logout</a></h7>");
			
			$connection->close();
		?>
	</body>
</html>
