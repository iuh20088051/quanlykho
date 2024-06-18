<?php
class phieu
{
	function connect() {
		$servername = "localhost";
		$username = "qlkho";
		$password = "123456";
		$dbname = "quanlykho";
	
		$conn = new mysqli($servername, $username, $password, $dbname);
	
		if ($conn->connect_error) 
		{
			die("Kết nối không thành công: " . $conn->connect_error);
		}
	
		return $conn;
	}
}
?>
