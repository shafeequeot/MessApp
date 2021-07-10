<?php
class DBController {
	private $host = "localhost";
	private $user = "admin";
	private $password = "admin";
	private $database = "Messapp";
	
	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->selectDB($conn);
		}
	}
	
	function connectDB() {
		$conn = mysqli_connect("localhost","admin","admin","messapp");
		return $conn;
	}
	
	function selectDB($conn) {
		mysqli_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysqli_query($query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}
?>