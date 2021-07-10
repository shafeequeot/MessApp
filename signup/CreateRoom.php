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
      <h1>Create new Room</h1>
    
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
  
  
    $RoomName = $_POST['RoomName'];
    $query = "SELECT `RoomName` FROM `room` WHERE `RoomName` = '$RoomName'";
    
    $result = mysqli_query($conn,$query);
if ($result)
{
  if (mysqli_num_rows($result) != 0)
  {
      echo '<span style="color:#fb0000;text-align:center;">That Room Name is taken. Try another. </span>';
  }

  else
  {
    $Date = date("Y-m-d");
    $MonthStart = $_POST['MonthStart'];
       $Currency = $_POST['Currency'];
      
      
$insertvalue = "INSERT INTO `room`(`Date`, `RoomName`, `MonthStart`, `RoomCreatedBy`, `Currency`) VALUES ('$Date','$RoomName','$MonthStart','$CustID','$Currency')";

if (mysqli_query($conn, $insertvalue)) {
$Room = mysqli_insert_id($conn);
    setcookie("Room", $Room, time() + (86400 * 30), "/");
    setcookie("Currency", $Currency, time() + (86400 * 30), "/");
    setcookie("MonthStart", $MonthStart, time() + (86400 * 30), "/");

$insertDate = "INSERT INTO `datetable`(`CustID`, `RoomID`, `RoomJoined`) VALUES ('$CustID','$Room', '$Date')";

if (mysqli_query($conn, $insertDate)) {

}else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    
      
 $UpdateValue = "UPDATE `members` SET `Room`= $Room WHERE ID = $CustID" ;   
    
    if (mysqli_query($conn, $UpdateValue)) {

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Created New Room... </span>';
     
 
header("refresh:0;url=../session");

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    


} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



  }}
    
  
}
                    
           
                    
    ?>
    
    <form method=post>
       <br/>  <br/><span class="sgreen">Mess Room Name</span><br/>
    <input type="text" id = "RoomName" placeholder="Mess Room Name" name ="RoomName" required /><br/>
<!--   select currency start-->
       <br/>  <br/><span class="sgreen">Select Currency</span><br/>  
<?php
echo '<SELECT name="Currency" required>';
   echo '<OPTION disabled selected value>--Select a Currency--</option>';
$MyNquery = "SELECT `ID`, `Currency` FROM `currency` ORDER BY `Currency` ASC";
$MyNresult = mysqli_query($conn,$MyNquery);
if ($MyNresult)
{
$MyNrows = mysqli_num_rows($MyNresult);
  
while($MyNrows = $MyNresult ->fetch_assoc())
{

 
  echo "<OPTION Value =" . $MyNrows["ID"] . ">" . $MyNrows["Currency"] ."</OPTION>";
 
} echo "</SELECT>";
}
        ?>
        
<!--  select currency end      -->
        
        
  <!--   Month start-->
        <br/>  <br/><span class="sgreen">Month Starting on</span> <br/>
        
<SELECT name="MonthStart" required disabled>
<!--
<OPTION selected value = "1">1</option>
 <OPTION Value ="5">5</OPTION>
    <OPTION Value ="10">10</OPTION>
    <OPTION Value ="15">15</OPTION>
    <OPTION Value ="20">20</OPTION>
    <OPTION Value ="25">25</OPTION>
-->
 </SELECT>
                    <br/> <span class="sred">*Expenses calculation based on selected day Eg. if you selected 15, January 15 to February 14 </span><br/>
<!--  Month Start   -->
        
        
        <br/><br/>
   
    <input type="submit" class ="btn btn-def btn-block" Value = " Create New Room" name="Submit" align ="center"><br/>
    <br><br>
    <span> Join Room?<a href="JoinRoom.php"> Click here</a></span>

</form>


</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
