<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>MessApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/normalize.min.css">
 <script src='../js/jquery-3.2.0.min.js'></script>

    <script src="../js/index.js"></script>
  
      <link rel="stylesheet" href="../css/style.css">

  
</head>
<body>
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
//header('location: signup/Selectmethod.php');
}
else
{
header('location: ../session/');
}}else
            {
              header('location: ../index.php'); 
            }
    
    
    
    
    ?>
    
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
      <h1>Select</h1>
    
   
 
       <br/> <a href="CreateRoom.php"><input type="submit" class ="btn" Value = " Create New Room " name="Submit" align ="center"></a><br/><br/>
     <a href="JoinRoom.php"><input type="submit" class ="btn" Value = "Join Existing Room" name="Submit" align ="center"><br/>
    <br/><br/>
   



</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
