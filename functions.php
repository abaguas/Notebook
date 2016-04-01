<?php
	session_start();
	
	function createConnection(){
		$host="db.ist.utl.pt";
		$user="istXXXXX";	
		$password="XXX";
		$dbname = $user;
		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		return $connection;
	}
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
			
	//receber novo idseq da nova entrada no log
	function geraIdSeq($connection) {
		$sql = "INSERT INTO sequencia (userid) VALUES (".$_SESSION['id'].")";
		if ($connection->query($sql) === FALSE) {
    		die( "Error: " . $sql . "<br>" . $conn->error);
		}
		$sql = "SELECT contador_sequencia FROM sequencia ORDER BY contador_sequencia DESC limit 1";
		$result = $connection->query($sql);
		if (!$result) {
    		die('Invalid query: ' . mysql_error());
		}
		$rows = $result->fetchAll();
		return $rows[0]['contador_sequencia'];
	}
			
	function geraId($coluna, $tabela, $connection){
		$sql = "select max($coluna) as max from $tabela where userid = ".$_SESSION['id']." ";
		$result = $connection->query($sql);
		if (!$result) {
    		die('Invalid query: ' . mysql_error());
		}
		$rows = $result->fetchAll();
		$id = $rows[0][max] + 1;
		
		return $id;
	}
	
	function buttons(){
		echo("<br></br>");
		echo("<p><a href=\"main.php?\">Voltar ao Menu</a></p>");		
		echo("<br></br>");
		echo("<h7><a href=\"logout.php?\">Logout</a></h7>");
	}
			
?>