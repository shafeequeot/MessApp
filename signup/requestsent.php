<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>MessApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/normalize.min.css">
 
      <link rel="stylesheet" href="../css/style.css">
    
    
    <SCRIPT LANGUAGE="JavaScript" src="../js/jquery.js"></SCRIPT>
 <SCRIPT LANGUAGE="JavaScript" src="../js/script.js"></SCRIPT>

  
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
    
    
     <?php
include("../connect.php");
require '../core.php';
                    
                    
                    
if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $CustID = $_COOKIE['CustID'];
  include("../room.php");


if ($Room == 0 )
{
//header('location: Selectmethod.php');
}
else
{
header('location: ../session/');
}}else
            {
              header('location: ../index.php'); 
            }
 
                    
                    
     if (loggedin())
{
//    header('location: requestsent.php');
}else
     {
          header('location: Selectmethod.php');
     }
                    

if (isset($_POST['Submit']))

{
$CustID = $_COOKIE['CustID'];
$DltQuery = "DELETE FROM `joinroom` WHERE `CustID` = '$CustID'";
$Dltresult = mysqli_query($conn,$DltQuery);

if ($Dltresult)
{
    
echo "Your Request canceled";
    header('location: Selectmethod.php');

} }                 
                    
                    
                    
                    
$CustID = $_COOKIE['CustID'];
$query = "SELECT `RoomName` FROM `room` WHERE  `ID` IN (SELECT `RoomID` FROM `joinroom` WHERE `CustID` = '$CustID')";
$result = mysqli_query($conn,$query);

if ($result)
{
$query_num = mysqli_num_rows($result);

if ($query_num >= 1)
{
    $srow = $result ->fetch_assoc()  ;
$room = $srow['RoomName'];

echo "<br/><br/><br/><h1>Your request to join ". $room . " is not accepted yet. Kindly wait...</h1>";

header ("refresh:30");
}}

                  
           
                    
    ?>
    
                    <img src="../asset/messapp2.gif"/>
      <br/>
                    
   <form method="post">
    <input type="submit" class ="btn btn-def btn-block" Value = "Cancel Request" name="Submit" align ="center"><br/>
    <br><br>
  

</form>

            
                   

</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
