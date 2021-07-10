<?php


// Create connection
$conn = new mysqli("localhost", "admin", "admin", "Messapp");

// Check connection
if ($conn->connect_error) {
    die("sql Connection failed: " . $conn->connect_error);

} 

?>


