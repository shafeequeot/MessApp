<?php


// Create connection
$conn = new mysqli("localhost", "admin", "admin", "ot");

// Check connection
if ($conn->connect_error) {
    die("sql Connection failed: " . $conn->connect_error);

} 

?>