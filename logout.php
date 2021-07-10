<?php

session_start();
session_unset();
session_destroy();
setcookie("Cust_ID","0",  time() - 3600);
header('location: index.php');

?>