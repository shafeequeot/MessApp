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
           <a href="settings.php" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
     
    
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
                    

                    
if (isset($_POST['BtnCancel']))

{
    
    
    header('location: ../session');
    
    
}
                    
//    room vecate and room left starting here
                    
if (isset($_POST['BtnLeftSave']))
{
   $value = $_POST['vecate'];
    
    if ($value == 1)
    {
      $UpdateLeftRoom =  "UPDATE `datetable` SET `WentVecation` ='" . date('Y/m/d') . "' WHERE `CustID` = $CustID AND `RoomID` = $Room AND `LeftRoom` IS NULL";  
        
    }
    else if ($value == 2)
    {
       $UpdateLeftRoom =  "UPDATE `datetable` SET `LeftRoom` ='" . date('Y/m/d') . "' WHERE `CustID` = $CustID AND `RoomID` = $Room"; 
        
        $WannaToLeft = "UPDATE `members` SET `Room` ='0' WHERE `ID` = $CustID";
       if( mysqli_query($conn, $WannaToLeft))
       {
          setcookie("Room","", time() + (86400 * 30), "/"); 
           header('location: ../session');
       }
    } 
    else if ($value == 3)
    {
        $UpdateLeftRoom =  "UPDATE `datetable` SET `ReJoin` ='" . date('Y/m/d') . "' WHERE `CustID` = $CustID AND `RoomID` = $Room AND `LeftRoom` IS NULL"; 
    }
    else 
    {
        echo "something went wrong, contact admin (code 10301)";
    }
    if (mysqli_query($conn, $UpdateLeftRoom )) {

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Updated... </span>';
    
    }
}
                    
                    
                    $CheckIsVecation = "SELECT * FROM `datetable` WHERE `WentVecation` > `Rejoin` AND `LeftRoom` IS NULL AND `CustID` = $CustID AND `RoomID` = $Room";
                    
                 
$result = mysqli_query($conn,$CheckIsVecation);
if ($result)
{

if ($result->num_rows > 0)
{
   
    $MyStatus = "Re Join"; 
    $MyValue = "3";
    
}
    else
    {
        
        $MyStatus = "Going Vecation"; 
    $MyValue = "1";
    }
}
                    
                    

   
                 Echo  "<div class='login'> 
                        <h1>I wanna to</h1><form method='POST'>
                       <span class='sred'>please confirm, before submit...</span><br/><br/>
                        <input type='radio' name='vecate' value=$MyValue onchange='BtnEnable()' ><span class='sgreen'>$MyStatus</span>
                        <input type='radio' name='vecate' value='2' onchange='BtnEnable()'> <span class='sgreen'>Left Room</span><br><br>
                        <input type='submit' class ='btn btn-def btn-block' value='Save' name='BtnLeftSave' id='BtnLeftSave' disabled>
                       <input type='submit' class ='btn btn-def btn-block' value='Cancel' name='BtnCancel' id='BtnCancel'>
                        </form> </div><br>";
               
//    room vecate and room left ending here         
               
       
                    
                    
                    
                    
                    
                    
                    
//          admin can edit room detials start here      
                    
                if(admin())
                {
                    
                    
                    if(isset($_POST['BtnUpdateRoom']))
                    {
                        $NewCurrency = $_POST['Currency'];
                        echo $NewCurrency;
                        $RoomUpdateQuery = "UPDATE `room` SET `Currency` = $NewCurrency WHERE `ID` = $Room";
       if( mysqli_query($conn, $RoomUpdateQuery))
       {
            setcookie("Currency","$NewCurrency", time() + 86400 * 30, "/", "", 0);
            echo " <span class='sred'>Detials Updated...</span>";
           header("Refresh:0");
        }
                     }
                     
               
                    
                     
$CheckMyRoom = "SELECT `RoomName`  FROM `room` WHERE`ID` = $Room";
                    
                 
$result = mysqli_query($conn,$CheckMyRoom);
if ($result)
{

$MyRoomGot = $result ->fetch_assoc();

    $MyRoom = $MyRoomGot['RoomName'];
   
}
    else
    {
        $MyRoom = "";
    }
                    
                    
                    
                    
       echo "<div class='login'> <h1>Edit Room Detials</h1><form method='post'>
                
        <span class='sgreen'> Room Name </span> <br>
        <input type='text' name = 'RoomName' id='RName' value= '$MyRoom' require disabled><br>
            
                <span class='sgreen'> Month Starting on </span><br>
                <SELECT name='MonthStart' required disabled>
<OPTION selected value = '1'>1</option>
 <OPTION Value ='5'>5</OPTION>
    <OPTION Value ='10'>10</OPTION>
    <OPTION Value ='15'>15</OPTION>
    <OPTION Value ='20'>20</OPTION>
    <OPTION Value ='25'>25</OPTION>
 </SELECT>
                <br>
             <span class='sgreen'> Change Currency </span> <br>
              <SELECT name='Currency' required>";
   
$MyNquery = "(SELECT `ID`, `Currency` FROM `currency` WHERE `ID` =" . $_COOKIE['Currency'] . ") UNION (SELECT `ID`, `Currency` FROM `currency` ORDER BY `Currency`)";
                   
$MyNresult = mysqli_query($conn,$MyNquery);
if ($MyNresult)
{
$MyNrows = mysqli_num_rows($MyNresult);
  
while($MyNrows = $MyNresult ->fetch_assoc())
{

 
  echo "<OPTION Value =" . $MyNrows["ID"] . ">" . $MyNrows["Currency"] ."</OPTION>";
 
} echo "</SELECT>";
} echo "<br><br>
             
            <input type='submit' class ='btn btn-def btn-block' value='Save' name='BtnUpdateRoom' id='BtnUpdateRoom' >
           <input type='submit' class ='btn btn-def btn-block' value='Cancel' name='BtnCancel' id='BtnCancel'>";
               }
                     
//          admin can edit room detials end here   
?>

                    
                
 

</div></center>
         
	
            
            
   <script type="text/javascript">

//alert ("if you submit once, cann't undo")
function BtnEnable()
{
  
    document.getElementById('BtnLeftSave').disabled = false;
       
}
</script>
            
            
            
            
            

            
            
<script type="text/javascript">
 
    
//    
//function checkAvailability() {
//	$("#loaderIcon").show();
//	jQuery.ajax({
//	url: "check_availability.php",
//	data:'username='+$("#UserName").val(),
//	type: "POST",
//	success:function(data){
//		$("#user-availability-status").html(data);
//		$("#loaderIcon").hide();
//	},
//	error:function (){}
//	});
//}
//    
</script>




		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
