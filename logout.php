<html>
	<body>
		<h2>Bloco de Notas</h2>
		<h3>Logout</h3>
		<?php

			session_start();
	  
			session_unset();
	
			session_destroy();
	
			header('Location: http://web.ist.utl.pt/ist178854/login.html');
	
		?>
	</body>
</html> 
