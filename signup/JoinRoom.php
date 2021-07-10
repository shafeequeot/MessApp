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
      <h1>Join Room</h1>
    
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
//header('location: Selectmethod.php');
}
else
{
header('location: ../session/');
}}else
            {
              header('location: ../index.php'); 
            }
 
                    
                    
     
if (isset($_POST['Submit']))

{
    $ckquery = "SELECT `ID` FROM `joinroom` WHERE `CustID` = '$CustID'";

$ckresult = mysqli_query($conn,$ckquery);

if ($ckresult)
{
$ckquery_num = mysqli_num_rows($ckresult);

if ($ckquery_num >= 1)
{

    echo "<span class='sred'> You already sent request..</span>";

}
else
{
   
    
  
    $RoomName = $_POST['RoomName'];
    $query = "SELECT `ID`,`RoomName`,`MonthStart`, `Currency` FROM `room` WHERE `RoomName` = '$RoomName'";
    
    $result = mysqli_query($conn,$query);
if ($result)
{
  if (mysqli_num_rows($result) != 0)
  {
      
      $Date = $_POST['JoinDate'];
   $Room = $result ->fetch_assoc()  ;
$RoomID = $Room['ID'];
      $Currency = $Room['Currency'];
      $MonthStart = $Room['MonthStart'];
      $CustID = $_COOKIE['CustID']; 
        
    
     
      
      
$UpdateValue = "INSERT INTO `joinroom`(`CustID`, `RoomID`, `JoinDate`) VALUES ($CustID,$RoomID,'$Date')";

if (mysqli_query($conn, $UpdateValue)) {
$Room = mysqli_insert_id($conn);

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Sent Request to Join Room... </span>';
     header('location: requestsent.php');
 

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

 
     
  }

  else
  {
     echo '<span style="color:#fb0000;text-align:center;">Room Not Exist. Try another. </span>';


  }}
    
  
}
   }}                 
           
                    
    ?>
    
    <form method=post>
       <br/>  <br/><span class="sgreen">Mess Room Name</span><br/>
    
      
<div class="main">
      
     	 <div id="holder"> 
             
             <input type="text" id="keyword" tabindex="0" name="RoomName" autocomplete='off'>
		 </div>
		 <div id="ajax_response"></div>
	 <img src="../images/loading.gif" id="loading">
        </div>
        
<!--  select currency end      -->
        
        
       
        
        
        
  <!--   Month start-->

        <br/>  <br/><span class="sgreen">Join Date Date</span> <br/>
        
<input type="date" name="JoinDate" Value="<?php echo date("Y-m-d");?>">

                   
<!--  Month Start   -->
        
        

        <br/><br/>
   
    <input type="submit" class ="btn btn-def btn-block" Value = "Sent Join Request" name="Submit" align ="center"><br/>
    <br><br>
    <span> Create New Room?<a href="CreateRoom.php"> Click here</a></span>

</form>


               
                   

</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
