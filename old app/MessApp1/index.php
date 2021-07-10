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
		<header>
            
            <a href="index.php" class="logo">MessApp</a> 
			
			
		</header>
		<div class="container">
            
            <center>

    <div class="login">
      <h1>Login to Mess App</h1>
 <?php
include("connect.php");
session_start();
if (isset($_COOKIE['Cust_ID']))
{
 $CookieID = $_COOKIE['Cust_ID'];
$query = "SELECT `ID` FROM `mess_room` WHERE `ID` = '$CookieID'";

 
$result = mysqli_query($conn,$query);

if ($result)
{
$query_num = mysqli_num_rows($result);  

if ($query_num == 1)
{
$userid = mysqli_fetch_assoc($result)['ID'];

$_SESSION['id'] = $userid;
header('location: ./session');
}}
}
else if (isset($_SESSION['id']))
{
   $SessionID = $_SESSION['id'];
$squery = "SELECT `ID` FROM `mess_room` WHERE `ID` = '$SessionID'";

 
$sresult = mysqli_query($conn,$squery);

if ($sresult)
{
$squery_num = mysqli_num_rows($sresult);

if ($squery_num == 1)
{
$suserid = mysqli_fetch_assoc($sresult)['ID'];

header('location: ./session');
}}

}

else
{
if (isset($_POST['Submit']))

{

$Username = $_POST['Uname'];
$Password = $_POST['pword'];

$query = "SELECT `ID` FROM `mess_room` WHERE `User_Name` = '$Username' AND `Password` = '$Password'";


$result = mysqli_query($conn,$query);

if ($result)
{
$query_num = mysqli_num_rows($result);

if ($query_num == 1)
{
$userid = mysqli_fetch_assoc($result)['ID'];
$_SESSION['id'] = $userid;
if(!empty($_POST["remember"])) {
  setcookie("Cust_ID", $userid, time() + (86400 * 30), "/");
 
	} else {
	if(isset($_COOKIE['Cust_ID'])) {
	setcookie("Cust_ID", $userid, time() - 3600);
	}
	
}
header('location: ./session');
}
else
{
echo '<span class="sred">Wrong Username and Password</span>';

}}
mysqli_close($conn);
}}

?>



<form Action="" Method = "POST">


<input class ="form-control" type="text"  name = "Uname" id="Name" placeholder="username" required/> <br>
<input class="Absolute-Center is-Responsive" type="password" name = "pword" id="" placeholder="password" required/> <br><br>

<input type="checkbox" name="remember"> Remember me on this computer</a>


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
