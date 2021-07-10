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
           <a href="profile.php" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
      <h1>Profile</h1>
    
     <?php
include("../connect.php");
require '../core.php';
include("../SessionLogged.php");

                    
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
}



if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $CustID = $_COOKIE['CustID'];
   $Room = $_COOKIE['Room'];


if ($Room == 0 )
{
header('location: Selectmethod.php');
}
else
{
// header('location: ../session/');
}}else
            {
              header('location: ../index.php'); 
            }            
                    

                    
if (isset($_POST['BtnCancel']))

{
    
    
    header('location: ../session');
    
    
}
                    
                    
if (isset($_POST['btn']))
{
    $pword1 = $_POST['Password'];
     $pword2 = $_POST['ConfirmPassword'];
    if ($pword1 != $pword2)
    {
        echo "<span class='sred'>Passwords not match </span>";
    }
    else
    {
    $UserName = $_POST['UserName'];
    $query = "SELECT `UserName` FROM `members` WHERE `UserName` = '$UserName' and NOT `ID` = '$CustID'";
    
    $result = mysqli_query($conn,$query);
if ($result)
{
  if (mysqli_num_rows($result) != 0)
  {
      
         
      
      echo '<span style="color:#fb0000;text-align:center;">That User Name is taken. Try another. </span>';
  }
    else
    {
        
  $Name = $_POST['Name'];
        
        $Email = $_POST['Email'];
        $UpdateValue = "UPDATE `members` SET `Name`='$Name',`UserName`='$UserName',`Password`='$pword1',`Email`='$Email' WHERE ID = '$CustID'";

if (mysqli_query($conn, $UpdateValue)) {

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Updated... </span>';
        
}
    
    
    
    
    
}}}
    }
                    
                    
                    
                    
                    
                    
                    
                    
    $CustID = $_COOKIE['CustID'];
    $RoomID = $_COOKIE['Room'];
    

$QueryFetch = "Select `members`.`Name`,`members`.`UserName`, `members`.`Password`, `members`.`Email`,`members`.`Room` FROM `members` where `members`.`ID` = '$CustID'";
 
	$result = mysqli_query($conn,$QueryFetch); 
	if(mysqli_num_rows($result))
	{
		
		while($row = $result ->fetch_assoc())
		{

			$CustName = $row['Name'];
			$UserName = $row['UserName'];
            $Password = $row['Password'];
            $Email = $row['Email'];
            $RoomName = $row['Room'];
			
		}
       
	}
	else
    {
		echo "Something Went Wrong. 0002222";
        }
	   


    
        
       echo "<form method='post'><div class='login'> 
       
<br><br> 
             <span class='sgreen'> Name </span> <br>
               <input type='text' name = 'Name' id='Name' value= '$CustName' require><br>
            
                <span class='sgreen'> User Name </span><br>
                <div id='frmCheckUsername'>
                <input  type='text' disabled name = 'UserName'id='UserName' value= '$UserName' onBlur='checkAvailability()' require ><br><span id='user-availability-status'></span></div>
                <br>
             <span class='sgreen'> Password </span> <br>
             <input type='password' name = 'Password' id='Password' value= '$Password' onfocusout='PwordChanged()' require><br>
             
             <span class='sgreen' > Confirm Password </span> <br>
             <input type='password' name = 'ConfirmPassword' id='ConfirmPassword'  value= '$Password'  onChange='CheckPword()' onfocusout='CheckPword()'>
             <div id='error'></div>
            <span class='sgreen'> Email </span> <br> 
            <input type='Email'  name = 'Email' id='Email' value= '$Email' require><br>";

?>

                    
                
                    
                    
<input type='Submit' class ='btn btn-def btn-block' name = 'btn' id='btn' value= 'Save'/>
                    <input type='button' class ='btn btn-def btn-block' name = 'BtnCancel' id='BtnCancel' onclick=location='../' value= 'Cancel'/></div></form>

</div></center>
      <div id="Ck"></div>      
		

<script type="text/javascript">
 function PwordChanged()
    {
       
    document.getElementById("divConfirm").style.display = "Block";
        
        
    }
    
    function CheckPword()
    {
        
        var pword1 = document.getElementById("Password").value;
        var pword2 = document.getElementById("ConfirmPassword").value;
        if (pword1 != pword2)
            {
             document.getElementById("error").innerHTML="<span class='sred'>Password not same</span>";
               
            } else
                {
                    document.getElementById("error").innerHTML="";
                    
                }
    
    }
    
    
    
function checkAvailability() {
	$("#loaderIcon").show();
	jQuery.ajax({
	url: "check_availability.php",
	data:'username='+$("#UserName").val(),
	type: "POST",
	success:function(data){
		$("#user-availability-status").html(data);
		$("#loaderIcon").hide();
	},
	error:function (){}
	});
}
    
</script>




		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
