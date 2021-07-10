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
           <a href="../index.php" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
      <h1>Dashboard</h1>
    
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
header('location: ../signup/Selectmethod.php');
}
}



if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{ 
   $CustID = $_COOKIE['CustID'];
   $Room = $_COOKIE['Room'];


if ($Room == 0 )
{
header('location: ../signup/Selectmethod.php');
}
else
{
// header('location: ../session/');
}}else
            {
              header('location: ../index.php'); 
            }            
                    

                    
if (isset($_POST['Submit']))

{
    
}
        
                    
                    
               
                    
    ?>
    
  
    
        
        <button id='BtnPurchase' onclick="location='purchase.php' "><img src="../asset/purchase-01.png" height="80" width="70" alt="Cool Image"/><h4 class="sgreen"> Purchase  </h4>  </button > &nbsp;&nbsp;&nbsp;
        <button id='BtnStatement' onclick="location='statement.php' "><img src="../asset/icon_statement.png" height="80" width="70" alt="Cool Image"/><br><h4 class="sgreen"> Statement <h4></button><br/><br/>
        <button onclick="location='settings.php'"><img src="../asset/manage_assets-01.png" height="80" width="85"/>  <h4 class="sgreen"> Settings  </h4> </button> &nbsp;&nbsp;&nbsp;
        <button onclick="location='profile.php'"><img src="../asset/profile-01.png" height="80" width="85"/><br> <h4 class="sgreen">Profile  </h4>    </button><br><br>
        <button onclick="location='members.php'"><img src="../asset/members.png" width="187"  height="20"/><br> <h4 class="sgreen">Members  </h4>    </button>

<?php
            
           if (IamAvailable())
                    {
                       
                       echo "<script type='text/javascript'>document.getElementById('BtnPurchase').disabled = false;</script>"; 
                    }
                    else
                    {
                       
                       echo "<script type='text/javascript'>document.getElementById('BtnPurchase').disabled = true;
                       </script>";
                    }
                          
            
            
            ?>

</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
