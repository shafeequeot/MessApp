<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>MessApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/normalize.min.css">
 <script src='../js/jquery-3.2.0.min.js'></script>
    <link rel="stylesheet" href="../css/tab.css" type="text/css">

    <script src="../js/index.js"></script>
  
      <link rel="stylesheet" href="../css/style.css">
<script src="../js/tab.js" type="text/javascript">
</script>
  
</head>

<body>
  <div class="mobile">
	<div class="mainContainer">
		<header>
            <a href='../'><i href="../" class="left"></i> </a>
            <a href="../member" class="logo">MessApp</a> 
			<a href="#" class="menuBtn">
				<span class="lines"></span>
			</a>
			<nav class="mainMenu">
				<ul>
					<li>
						<a href="#"></a>
					</li>
					<li>
						<a href="../index.php">Home</a>
					</li>
					<li>
						<a href="../statement">Statement</a>
					</li>
					<li>
						<a href="../member">Members</a>
					</li>
          	<li>
						<a href="../about" >About</a>
					</li>
          <li>
						<a href="../help" >Help</a>
					</li>
					<li>
						<a href="../logout.php" class="suBtn">Logout</a>
					</li>
				</ul>
			</nav>
		</header>
		<div class="container">
            

 

<?php

require '../core.php';
include '../connect.php';
include '../mydetials.php';
 $error ="";
 $messege = "";
$message2 = "";
$updatemessage ="";



if (isset($_POST['save']))
{
  $MID = $_SESSION['id'];
$MName = $_POST['name'];
$mquery = "SELECT `ID`FROM `members` WHERE `Name` = '$MName' and `Room_ID` = '$MID'" ;
$mresult = mysqli_query($conn,$mquery);

if ($mresult->num_rows > 0)
{
$error='<span class="sred">This Name already taken.. Please Enter Another Name</span>';
  }
  else
  {
    $date = $_POST['date'];
    
      $insertvalue = "INSERT INTO `members`(`Room_ID`, `Name`) VALUES ('$MID','$MName')"; 
      

if (mysqli_query($conn, $insertvalue)) 
{

$bringIDquery = "SELECT `ID` FROM `members` WHERE `Name` = '$MName'";

 
$bringresult = mysqli_query($conn,$bringIDquery);

if ($bringresult)
{
$query_num = mysqli_num_rows($bringresult);

if ($query_num == 1)
{ 
$NameId = mysqli_fetch_assoc($bringresult)['ID'];


  $JDQuery = "INSERT INTO `vecation`(`Name`, `Room_ID`, `Join_Date`) VALUES('$NameId','$MID','$date')";
  if (mysqli_query($conn, $JDQuery)) 
  {
$messege = "<span class ='sgreen'>Your Seccessfully Added Mr/Mrs $MName</span><br>";
$message2 = "<span class='sred'>Now You Can Add New Member</span><br>";
  }
  else
  {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}}}
  }
 else
  {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
  }}



?>
<div class="login" align="center">



<!-- tab Start -->


<ul class="tabs" data-persist="true">

    <li><a href="#view1">Add New Member</a></li>
    <li><a href="#view2">Edit Detials</a></li>
  
  
</ul>
<div class="tabcontents">
  
  <div id="view1">
        <form method="POST">
<?php echo "$messege";
 echo "$message2"; ?>
 <?php echo $error; ?>
  <br>
  <input type = "text" id="uname" placeholder="Enter Name" name ="name" required>
  <br>
 
  <span>Join Date:</span> <br>   <input type="date" id = "mydate" name ="date" value="<?php print(date("Y-m-01")); ?>"<br/>
  <br>
<span class="sred"> * Make sure all detials are correct. cannot delete after add a member </span><br/>
 <input type="submit" name="save" value="Save">


</form>
    </div>
    <div id="view2">
    
    <form id ="selectName" method="POST">
          <br> 
        <?php

$RMID = $_SESSION['id'];
$rmquery = "SELECT `ID`, `Name` FROM `members` WHERE `Room_ID` = '$RMID'";
$rmresult = mysqli_query($conn,$rmquery);

if ($rmresult->num_rows > 0)
{
  echo '<SELECT name="name" onchange="NameSelected()" required >';
  echo '<OPTION disabled selected value> --Select Name--</option>';
while($rmrow = $rmresult ->fetch_assoc())
{
  echo "<OPTION Value =" . $rmrow["ID"] . ">" . $rmrow["Name"] ."</OPTION>";
 
} echo "</SELECT>";
  }
  else
  {
     echo '<span class="sred">No Room members in this room, Kindly add new Members</span>';
     
  }
  echo $updatemessage;
  echo "</form><form method='POST' name='update'>";



if (isset($_POST['name']))
{

$name = $_POST['name'];
    //$roomid = $_SESSION['id'];
    $EMquery="SELECT `ID`,`Name`, `Status`FROM `members` WHERE `ID` = '$name'";
    $EMresult = mysqli_query($conn,$EMquery);
    if ($EMresult)
    {
 $EMrow = $EMresult ->fetch_assoc();
      
   $EMID = $EMrow['ID'];
    $EMName = $EMrow['Name'];
    $EMStatus = $EMrow['Status'];
      
echo "Member ID: $EMID<input type='hidden' name='EID' id='EID' value = $EMID>" . "</input><br/>";
  echo "Change Name<br>";
  echo "<input type='text' name='changename' placeholder='Change Your Name' value='$EMName' required>";
 

     $available=""; $vecation=""; $vecated="";
   if ($EMStatus==="1")
   {
$available="checked";
$CurrentStatus = "Available";
   }
   elseif($EMStatus==="2")
   {
     $vecation="checked";
     $CurrentStatus = "Vecation";
   }
   else
   {
     $vecated="checked";
     $CurrentStatus = "Room Vecated";
   }
     echo "<br/><br/>Now Your Status is <span class='sred'> $CurrentStatus.</span> do you want change it? <br/>";
     if ($CurrentStatus="Available")
     {
       $rejoin = "Available";
       $rjvalue= "1";
     }
     else
     {
       $rejoin = "Re Join";
       $rjvalue="4";
     }
   echo "<input type='radio' name='status' $available id='rejoin' value ='$rjvalue' onchange='showdate()'>$rejoin</Rejoin></input>". "<input type='radio' name='status' $vecation value='2' id='vecation' onchange='showdate()'>Going to Vecation</input>" . "<input type='radio' name='status' $vecated id='vecated' value='3' onchange='showdate()'>Room Vecated</input><br/>";
   echo "<div name='UDate' id='UDate' style='display: none;width:100%;padding-left: 0'><input type='date' id='EditDate' name='EditDate'></input></div>";
   echo "<input type='submit' name='BtnUpdate' id='BtnUpdate'>";
}
else
{
  echo "<span class='sred'> fetching Detials Error</span>";
}
}
echo "</form>";

// Update button start
if(isset($_POST['BtnUpdate']))
{
  $UPMID = $_POST['EID'];
  $UPRMID= $_SESSION['id'];
$CKquery="SELECT `Status`FROM `members` WHERE `ID` = '$UPMID'";
    $CKresult = mysqli_query($conn,$CKquery);
    if ($CKresult)
    {
 $CKrow = $CKresult ->fetch_assoc();
      
   $CKID = $CKrow['Status'];
   $ckstatus = $_POST['status'];

if ($CKID===$ckstatus)
{
  $updatedName = $_POST['changename'];
    
    $updatequery = "UPDATE `members` SET `Name`='$updatedName' WHERE `ID` = '$UPMID'";
  if (mysqli_query($conn, $updatequery)) {
echo '<span class="sred">You are Success Fully Updated..</span>';
  }
}
else
{
  if ($ckstatus ==="1")
  {
    
    $rejoinDate = $_POST['EditDate'];
    $insertvalue = "INSERT INTO `vecation`(`Name`, `Room_ID`, `ReJoin`) VALUES ('$UPMID','$UPRMID','$rejoinDate')";

if (mysqli_query($conn, $insertvalue)) {
  $updatedName = $_POST['changename'];
  $updatequery = "UPDATE `members` SET `Name`='$updatedName',`Status`='1'  WHERE `ID` = '$UPMID'";
  if (mysqli_query($conn, $updatequery)) {
echo '<span class="sred">You are Success Fully Updated..</span>';
  }

  }
}
elseif($ckstatus ==="2")
{

  
  $rejoinDate = $_POST['EditDate'];
    $insertvalue = "INSERT INTO `vecation`(`Name`, `Room_ID`, `Vecation`) VALUES ('$UPMID','$UPRMID','$rejoinDate')";

if (mysqli_query($conn, $insertvalue)) {
    
    $updatedName = $_POST['changename'];
  $updatequery = "UPDATE `members` SET `Name`='$updatedName',`Status`='2'  WHERE `ID` = '$UPMID'";
  if (mysqli_query($conn, $updatequery)) {
echo '<span class="sred">You are Success Fully Updated..</span>';
  }
}
}
elseif($ckstatus ==="3")
{
   
  $rejoinDate = $_POST['EditDate'];
    $insertvalue = "INSERT INTO `vecation`(`Name`, `Room_ID`, `RoomVecated`) VALUES ('$UPMID','$UPRMID','$rejoinDate')";

if (mysqli_query($conn, $insertvalue)) {

        $updatedName = $_POST['changename'];
  $updatequery = "UPDATE `members` SET `Name`='$updatedName',`Status`='3'  WHERE `ID` = '$UPMID'";
  if (mysqli_query($conn, $updatequery)) {
echo '<span class="sred">Conguradulations!!.. You are Seccessfully Updated inside 3rd step</span>';
  }
}

}
}}

  $UPQUERY = "";
}
// update button end

?>


      
    
    </div>
   
</div>


<!-- tab End -->

<script>
 
function NameSelected()
{
  $('#selectName').submit();
}
function showdate()
{
  // alert("nadako");
  var Udate = $('#UDate');
 Udate.css('display','block');
}
// todays date
// document.getElementById('mydate').value= new Date().toJSON().slice(0,10);
   
  
    
    
    
 document.getElementById('EditDate').value= new Date().toJSON().slice(0,10);
</script>
<?php
//show members
echo "<br/><br/><h1>All Members</h1>";
     $RMID = $_SESSION['id'];
$rmquery = "SELECT `ID`, `Name`,`Status` FROM `members` WHERE `Room_ID` = '$RMID'";
$rmresult = mysqli_query($conn,$rmquery);

if ($rmresult->num_rows > 0)
{
    echo "<div class='tabdiv'>";
echo "<table><tr><th>Number </th><th> Name </th><th> Status </th></tr>";
$no ="1";
while($row = $rmresult ->fetch_assoc())
{

  if($row["Status"] == 1)
  {
    $status="Available";
  }elseif( $row["Status"] == 2)
  {$status="on Vecation";}
  else
  {
    $status="Room Vecated";
  }
  
  echo "<tr><td>".$no."</td><td>".$row["Name"]."</td><td>".$status."</td></tr>";
 $no = $no+1;
} echo "</table>";
  }
else
{
  echo "0 Results";
  }
  ?>
    </div>
</div>

<script type="text/javascript">

  var extraRender = $('#update');
  
  $( document ).ready(function() {
    $('#editname').on('keyup',$.debounce( 500, function(){
        var name = $('#editname').val();
        if(name == ""){
          return;
        }

        $.post( "checkdata.php",{
          user_name:name
         
        },function( data ) {
          
           if(data.exist){
              extraRender.css('display','block');
              
           }else{
              extraRender.css('display','none');
              
           }
        });
        
      } 
    ));
});


    function checkname()
    {
        var name = $('#editname').val();
        if(name == ""){
          return;
        }

        $.post( "checkdata.php",{
          user_name:name
        },function( data ) {
          
           if(data.exist){
               extraRender.css('display','block');

               }else{
              extraRender.css('display','none');
           }
        });
        
      } 
  

</script>

		<footer>
           

		</footer>
	</div>
        </div></div>
 

</body> 
</html>
