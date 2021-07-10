<?php

// Create connection
include("../connect.php");
require '../core.php';

// Check connection
if ($conn->connect_error) {
    die("sql Connection failed: " . $conn->connect_error);

} 



 $MembID=$_POST["Custid"];
 $Adminstatus = $_POST["Adminstatus"];
if($Adminstatus=='true')
{
    $ChangeStatus = '1';
} else
{
    $ChangeStatus = '0';
}
$sql="UPDATE `members` SET `Admin`= $ChangeStatus WHERE `ID`='" . $MembID . "'";

if($conn->query($sql)===TRUE){
    echo "DATA updated";
}
else
{
  echo "Got Error: 54211220";  
}
    ?>