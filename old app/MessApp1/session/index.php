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
		<header>
            <!--<a href='../'><i href="../" class="left"></i> </a>-->
            <a href="../session" class="logo">MessApp</a> 
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
$messege = "";
$message2 = "";







if (isset($_POST['Save']))
{
  $RoomID = $_SESSION['id'];
  $PDate = $_POST['date'];
  $Name = $_POST['name'];
  $Amount = $_POST['amount'];
  $Description = $_POST['description'];

  
 $insertvalue = "INSERT INTO `purchase`(`Room_ID`, `Purchase_Date`, `Name`, `Amount`, `Description`) VALUES ('$RoomID','$PDate','$Name' ,'$Amount' ,'$Description')";

if (mysqli_query($conn, $insertvalue)) 
{
$messege = "<span class ='sgreen'>Seccessfully Added Your Purchase Detials.</span><br>";
$message2 = "<span class='sred'>Now You Can Add New Detials</span><br>";

  }
 else
  {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


}



?>
<html>
 



<body>

	
<div align="right">
 </div>
<br>



<!--forms start-->
<div class="login" align="Center">
<h1> Purchase</h1>
<form Action="" Method = "POST">
 <?php Echo $messege . " " . $message2; ?>
<input  type="date" class = "form-control" id="today" name = "date" required > 
<script>
  document.getElementById('today').value= new Date().toJSON().slice(0,10);
</script>
<?php

$RMID = $_SESSION['id'];
$rmquery = "SELECT `ID`, `Name` FROM `members` WHERE `Room_ID` = '$RMID' AND `Status` = '1'";
$rmresult = mysqli_query($conn,$rmquery);

if ($rmresult->num_rows > 0)
{
  echo '<SELECT name="name" required>';
  echo '<OPTION disabled selected value> --Select Name--</option>';
while($rmrow = $rmresult ->fetch_assoc())
{
  echo "<OPTION Value =" . $rmrow["ID"] . ">" . $rmrow["Name"] ."</OPTION>";
 
} echo "</SELECT>";
  }
  else
  {
     echo '<span class="sred">No Room members in this room, Kindly add new Members</span>';
    header("refresh:1;url=../member");
  }

?>
<br><input type="text" class = "form-control" placeholder ="Amount" name="amount" id = "amount" required onkeypress="return isNumberKey(event)">
<input type="text" class = "form-control" placeholder ="Bill Number / Description" name="description" id = "description"><br><br>
<input type="submit" class = "form-control" name="Save" id = "Save" value ="Save">
</div>
<!--forms end-->
</form>
<br>






<br>
<!-- data table start-->
<div class="login" align="center">
<h1>Purchasing List</h1>
<?php
$month = date('m');
$year = date('Y');
$id = $_SESSION['id'];

$query = "SELECT `ID`, `Purchase_Date`, `Name`, `Amount`, `Description` FROM `purchase` WHERE `Room_ID`= '$id' AND MONTH(`Purchase_Date`) = '$month' AND  YEAR(`Purchase_Date`) = '$year'";
echo "<form id='Update' Method='POST'>" ;

$result = mysqli_query($conn,$query);
if ($result)
{

if ($result->num_rows > 0)
{
echo "<div class='tabdiv'><table><tr><th>Update </th><th> Date </th><th> Purchased by </th><th> Description</th><th> Amount </th></tr>";
$no = "1";
while($row = $result ->fetch_assoc())
{
  
$PNquery = "SELECT `Name` FROM `members` WHERE `ID` = '$row[Name]'";

 
$PNresult = mysqli_query($conn,$PNquery);

if ($PNresult)
{
$PNrows = mysqli_num_rows($PNresult);
if ($PNrows == 1)
{ 
$PNName = mysqli_fetch_assoc($PNresult)['Name'];
}
else{
  echo "name fetch error";
}
}

$PurchaseDate = date("d - M - Y (D)", strtotime($row["Purchase_Date"]));

  echo "<tr><td> <input  type = 'radio' Name = 'edit' Value =" . $row["ID"] . " OnChange='Update()'> </td><td> ".$PurchaseDate." </td><td> ".$PNName." </td><td> ".$row["Description"]." </td><td> ".$row["Amount"]."</td></tr>";
 $no = $no + 1;
} echo "</table></div>";
  }
else
{
  echo "0 Results";

}
}
else
{
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    
 echo "</Form>"  ; 
    
       

  if(isset($_POST['edit']))
  {
    $bringID = $_POST['edit'];
    $UPBquery = "SELECT `Purchase_Date`, `Name`, `Amount`, `Description` FROM `purchase` WHERE `ID` = '$bringID'";

$UPBresult = mysqli_query($conn,$UPBquery);

if ($UPBresult)
{


if ($UPBresult->num_rows > 0)
{
while($UProw = $UPBresult ->fetch_assoc())
{

$UPBDate = $UProw['Purchase_Date'];
$UPBName = $UProw['Name'];
$UPBAmount = $UProw['Amount'];
$UPBDescription = $UProw['Description'];


 

echo '<SECTION ID = "gotedit">';
 echo "<form METHOD = 'POST'> 
 <input type='hidden' name='bringid' ID = 'bringid' value = '$bringID'>
    <input type='date' name='UpDate' Value ='$UPBDate' required>";
        
$RMID = $_SESSION['id'];
$rmquery = "SELECT `ID`, `Name` FROM `members` WHERE `Room_ID` = '$RMID' AND `Status` = '1' NOT IN (`ID` = '$UPBName')";
$rmresult = mysqli_query($conn,$rmquery);

if ($rmresult->num_rows > 0)
{
$MyNquery = "SELECT `Name` FROM `members` WHERE `ID` = '$UPBName'";

 
$MyNresult = mysqli_query($conn,$MyNquery);

if ($MyNresult)
{
$MyNrows = mysqli_num_rows($MyNresult);
if ($MyNrows == 1)
{ 
$MyNName = mysqli_fetch_assoc($MyNresult)['Name'];
}
else{
  echo "name fetch error";
}
}
  echo '<SELECT name="UPName" required>';
   echo '<OPTION Selected = selected value = '. $UPBName . ' >' . $MyNName . '</option>';
while($rmrow = $rmresult ->fetch_assoc())
{

 
  echo "<OPTION " . $selected . " Value =" . $rmrow["ID"] . ">" . $rmrow["Name"] ."</OPTION>";
 
} echo "</SELECT>";
  }



        echo "<input type='text' name='UPDescription' placeholder='Update Description' Value = '$UPBDescription'>
        <input type='text' name='UPAmount' placeholder='Update Amount' Value = '$UPBAmount' required onkeypress='return isNumberKey(event)'><br><br>
        <input type='submit' name='update' value='Update' required>
        <input type='submit' name ='Delete' value='Delete' required>
        
    </form> </section>    </div>";
}

}
}else{
  echo "name fetch error";
     
  }}


  if(isset($_POST['update']))
  {
     $bringID = $_POST['bringid'];
     $newdate = $_POST['UpDate'];
     $newname = $_POST['UPName'];
      $NewAmount = $_POST['UPAmount'];
       $newdescription = $_POST['UPDescription'];
    $setquery = "UPDATE `purchase` SET `Purchase_Date`='$newdate',`Name`=$newname,`Amount`='$NewAmount',`Description`='$newdescription' WHERE `ID`='$bringID'";

 
$setresult = mysqli_query($conn,$setquery);

if ($setresult)
{
echo "Seccess fully Updated";
}
else{
  echo "update query error";
}
  }

  if(isset($_POST['Delete']))
  {
    $bringID = $_POST['bringid'];
    $Dltquery = "DELETE FROM `purchase` WHERE `ID` = '$bringID'";

 
$Dltresult = mysqli_query($conn,$Dltquery);

if ($Dltresult)
{
echo "Seccess fully Deleted";
}
else{
  echo "delete query error";
}
}
  
  
?>

<!-- data table end--></section>

		</div>
            
 <script>
    function Update()
     {
          $('#Update').submit(); 
              
        	
     }
 jQuery.fn.extend({
            scrollTo : function(speed, easing){
              return this.each(function(){
                var targetOffset = $(this).offset().top;
                $('html,body').animate({scrollTop: targetOffset}, speed, easing);
              });
            }
          })
          $('#gotedit').scrollTo('fast', 'linear');

     function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
    return false;
    return true;
}   
document.getElementById('update').value= new Date().toJSON().slice(0,10);
    </script>
		<footer>
           

		</footer>
	</div>
        </div></div>
 

</body> 
</html>
