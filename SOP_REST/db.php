<?php 
	class Database {
		private $db_host = "localhost";
		private $db_user = "root";
		private $db_pass = "root";
		private $db_name = "sop-wcf-phprest";

		private $conn;

		function openConnection(){
			$connection = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			
			if(mysql_connect_errno()){
				die("Kapcsolódás sikertelen: " . mysqli_connect_error());
            	exit();
			}else{
            	$this->conn = $connection;
	        }
	        return $this->conn;
		}
	}

 ?>