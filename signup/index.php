<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>MessApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/normalize.min.css">
 <script src='../js/jquery-3.2.0.min.js'></script>
<script src="../js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../js/index.js"></script>
  
      <link rel="stylesheet" href="../css/style.css">

  
</head>

<body>
  <div class="mobile">
	<div class="mainContainer">
<!--
		<header>
            <a href='../'><i href="../" class="left"></i> </a>
           <a href="../signup" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
      <h1>Create new Account</h1>
    
     <?php
include("../connect.php");
require '../core.php';

                    
if (loggedin())
{
    header('location: requestsent.php');
}  

                    
if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $CustID = $_COOKIE['CustID'];
include("../room.php");


if ($Room == 0 )
{
header('location: Selectmethod.php');
}
else
{
header('location: ../session/');
}}            
                    

                    
if (isset($_POST['Submit']))

{
  if( $_POST['password'] == $_POST['confirmpassword'])
  {
    $username = $_POST['uname'];
    $query = "SELECT `UserName` FROM `members` WHERE `UserName` = '$username'";
    
    $result = mysqli_query($conn,$query);
if ($result)
{
  if (mysqli_num_rows($result) != 0)
  {
      echo '<span style="color:#fb0000;text-align:center;">That username is taken. Try another. </span>';
  }

  else
  {
    $today =   date("Y-m-d");
    $name = $_POST['name'];
    $Password = $_POST['password'];
    $email = $_POST['email'];

$insertvalue = "INSERT INTO `members`(`JoinDate`, `Name`, `UserName`, `Password`, `Email`) VALUES ('$today','$name','$username','$Password','$email')";

if (mysqli_query($conn, $insertvalue)) {

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Created New Account... Please login to Continue</span>';
    $_SESSION['CustName'] = $username;
   
    
    
    
    
    
    
    
    $squery = "SELECT `ID`, `Room` FROM `members` WHERE `UserName` = '$username' AND `Password` = '$Password'";


$sresult = mysqli_query($conn,$squery);

if ($sresult)
{
   
$squery_num = mysqli_num_rows($sresult);

if ($squery_num == 1)
{
  $srow = $sresult ->fetch_assoc()  ;
$userid = $srow['ID'];
$Room = $srow['Room'];
  
setcookie("CustID", $userid, time() + (86400 * 30), "/");
setcookie("Room", $Room, time() + (86400 * 30), "/");

    if ($Room == 0)
    {
        header('location: Selectmethod.php');
    }
    else if ($Room > 0 )
    {
    header('location: ../session');
    }

    }}
    
    
    
    
    
    
    
    
   
  
    


} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



  }}
    }
  else {echo '<span style="color:#fb0000;text-align:center;">Password not same</span>';}
}
                  
    ?>
    
    <form method=post>
    <input type="text" id = "name" placeholder="Type your Name" name ="name" required /><br/><div id="unamecheck" class="sred"></div>
    <input type="text" id = "uname" placeholder="User Name" minlength = "4" name ="uname"  required/><br/>
    <input type="password" id = "password" placeholder="Password" minlength = "5" name ="password" required /><br/><div id="pwordcheck" class="sred"></div>
    <input type="password" id = "confirmpassword" placeholder="Confirm Password" name ="confirmpassword" required/><br/>
    <input type="email" id = "email" placeholder="Email ID (for password recovery)" name ="email" required /><br/><br/>
    <input type="submit" class ="btn" Value = " Next Step" name="Submit"  align ="center" disabled><br/>
    <br/><br/>
    <span> Already have Account?<a href="../"> Click here</a></span>

</form>


</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 
<script type="text/javascript">
     var user = 0;
    var pword = 0;
    $("#uname").focusout(function () {
        var Uname = document.getElementById("uname").value;
        
       
        
        if (/\s/.test(Uname)) {
    document.getElementById("unamecheck").innerHTML="Spaces not allowed";  
            user = 1;
} else if (count = 1)
    {
        user = 0
        document.getElementById("unamecheck").innerHTML="";
    }
  if ( user == 0 && pword == 0)
            {
                    $(':input[type="submit"]').prop('disabled', false);
            }
            else
                {
                     $(':input[type="submit"]').prop('disabled', true);
                }

        
        
});
    
    
        $("#confirmpassword").focusout(function () {
       
        var Passw = document.getElementById("password").value;
        var passw2 = document.getElementById("confirmpassword").value;
       
        
        if(Passw != passw2)
            {
                document.getElementById("pwordcheck").innerHTML="Password not same";
                    pword = 1;
            }
            else 
                {
                    document.getElementById("pwordcheck").innerHTML="   ";
                     pword = 0;
                }
        
 if ( user == 0 && pword == 0)
            {
                    $(':input[type="submit"]').prop('disabled', false);
            }
            else
                {
                     $(':input[type="submit"]').prop('disabled', true);
                }
        
            
        
        
});
    
    

    </script>
</body> 
</html>
