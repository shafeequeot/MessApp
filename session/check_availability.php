<?php
require_once("../connect.php");

if(isset($_COOKIE['CustID']))
 {
$CustID = $_COOKIE['CustID'];
 }
 else
 {
     $CustID = "NULL";
 }
if(!empty($_POST["username"])) {
  $result = mysqli_query($conn,"SELECT count(*) FROM members WHERE UserName='" . $_POST["username"] . "' and NOT `ID` = '$CustID'");
  $row = mysqli_fetch_row($result);
  $user_count = $row[0];
  if($user_count>0) {
      echo "<span class='sred'> Username Not Available.</span>";
      
  }else{
      echo "";
  }
}
?>