<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>MessApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/normalize.min.css">
 <script src='js/jquery-3.2.0.min.js'></script>

    <script src="js/index.js"></script>
  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <div class="mobile">
	<div class="mainContainer">
<!--
		<header>
            
            <a href="index.php" class="logo">MessApp</a> 
			
			
		</header>
-->
		<div class="container">
            
            <center>

    <div class="login">
      <h1>Login to Mess App</h1>
 <?php
include("connect.php");

        
        require 'core.php';

                    
if (loggedin())
{
    header('location: signup/requestsent.php');
}  
        
        
        
        
        if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $CustID = $_COOKIE['CustID'];

include("room.php");


if ($Room == 0 )
{
header('location: signup/Selectmethod.php');
}
else
{

header('location: ../session/');
}}   
        
        



        
        
        if (isset($_COOKIE['CustID']))
{
   $COOKIE = $_COOKIE['CustID'];
$squery = "SELECT `ID`,`Room` FROM `members` WHERE `ID` = '$COOKIE'";

 
$sresult = mysqli_query($conn,$squery);

if ($sresult)
{
$squery_num = mysqli_num_rows($sresult);

if ($squery_num == 1)
{
$suserid = mysqli_fetch_assoc($sresult)['ID'];
$roomid =mysqli_fetch_assoc($sresult)['Room'];

if ($roomid == 0 )
{
header('location: signup/Selectmethod.php');
}
else
{
header('location: session/');
}}}}
        
        
        
        
 
if (isset($_POST['Submit']))

{

$Username = $_POST['Uname'];
$Password = $_POST['pword'];

$query = "SELECT `ID`, `Room` FROM `members` WHERE `UserName` = '$Username' AND `Password` = '$Password'";


$result = mysqli_query($conn,$query);

if ($result)
{
   
$query_num = mysqli_num_rows($result);

if ($query_num == 1)
{
  $row = $result ->fetch_assoc()  ;
$userid = $row['ID'];
$Room = $row['Room'];
  
setcookie("CustID", $userid, time() + (86400 * 30), "/");
setcookie("Room", $Room, time() + (86400 * 30), "/");

    if ($Room == 0)
    {
        header('location: signup/Selectmethod.php');
    }
    else if ($Room > 0 )
    {
        
     
        
$RoomQuery = "SELECT `ID`, `MonthStart`, `Currency` FROM `room` WHERE `ID` = '$Room'";

$Roomresult = mysqli_query($conn,$RoomQuery);

if ($Roomresult)
{
   
$Roomquery_num = mysqli_num_rows($Roomresult);

if ($Roomquery_num == 1)
{
  $row = $Roomresult ->fetch_assoc()  ;
$RoomID = $row['ID'];
$MonthStart = $row['MonthStart'];
$Currency = $row['Currency'];       
        
   setcookie("Room", $RoomID, time() + (86400 * 30), "/");
    setcookie("Currency", $Currency, time() + (86400 * 30), "/");
    setcookie("MonthStart", $MonthStart, time() + (86400 * 30), "/");
    header('location: session');
 }}}

}
else
{
echo '<span class="sred">Wrong Username and Password</span>';

}}
mysqli_close($conn);
}

?>



<form Action="" Method = "POST">


<input class ="form-control" type="text"  name = "Uname" id="Name" placeholder="username" required/> <br>
<input class="Absolute-Center is-Responsive" type="password" name = "pword" id="" placeholder="password" required/> <br><br>



<br><br><br>
<div class="form-group">
<input type="submit" class ="btn btn-def btn-block" Value = "Login" name="Submit" >
</div>
</div>
</center>
</form>
            
		</div>
		<footer>
            <div class="login-help">
            <a href="#">Forgot Password?</a>&nbsp;|&nbsp; <a href="signup">Create New Account</a></a>
          </div>

		</footer>
	</div>
</div>
 

</body> 
</html>
