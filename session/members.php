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
           <a href="members.php" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
  <SCRIPT LANGUAGE="JavaScript" src="../js/jquery.js"></SCRIPT>
 <SCRIPT LANGUAGE="JavaScript" src="../js/script.js"></SCRIPT>   
    
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
                    
                    



// join request start



$query = "SELECT `ID`,`CustID`, `JoinDate` FROM `joinroom` WHERE `RoomID`= '$Room'";
echo "<form  Method='POST'>" ;

$result = mysqli_query($conn,$query);
if ($result)
{

if ($result->num_rows > 0)
{
echo "<div class='login'><h1>Join Requests</h1><table>";
$no = "1";
while($row = $result ->fetch_assoc())
{
  
$PNquery = "SELECT `Name` FROM `members` WHERE `ID` = '$row[CustID]'";

 
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
$NJoinDate = $row['JoinDate'];
$JoinID = $row['ID'];
echo "<tr><td width='60%'>$PNName</td><td width='20%'><button class='request' name='accept'value='$JoinID' value='Accept'>Accept</button></td><td width='20%'><button class='request' name='decline' value='$JoinID'>Decline</button></td></tr>";

}
echo "</table></div></form>";
}}


if (isset($_POST["accept"]))
{
  $AcceptedID = $_POST['accept'];
   
   $BringAccepter = "SELECT `CustID`, `RoomID`, `JoinDate` FROM `joinroom` WHERE `ID` = '$AcceptedID'";

 
$Bringresult = mysqli_query($conn,$BringAccepter);

if ($Bringresult)
{

    while($Brrows = $Bringresult ->fetch_assoc())
    {
$BringCustID = $Brrows['CustID'];
$BringRoomID = $Brrows['RoomID'];
$BringJoingDate = $Brrows['JoinDate'];
}}
else{
            echo "name fetch error";
}





    $AcceptUpdateQuery = "UPDATE `members` SET `Room`='$BringRoomID' WHERE ID = '$BringCustID'";

if (mysqli_query($conn, $AcceptUpdateQuery)) {

    $AcceptInsertQuery = "INSERT INTO `datetable`(`CustID`, `RoomID`, `RoomJoined`) VALUES ('$BringCustID','$BringRoomID', '$BringJoingDate')";

if (mysqli_query($conn, $AcceptInsertQuery)) {



$AcceptDeleteQuery = "DELETE FROM `joinroom` WHERE `ID`= '$AcceptedID'";
if (mysqli_query($conn, $AcceptDeleteQuery)) {
    header ("Refresh:0");
}

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Added... </span>';
        
}
}


    }

    if (isset($_POST["decline"]))
{
  $id = $_POST['decline'];

    $DeclineQuery = "DELETE FROM `joinroom` WHERE `ID` = $id";

if (mysqli_query($conn, $DeclineQuery)) {

    header("Refresh:0");
        
}



    
    }


// Join request end


// add new member start
echo "<div class='login' id='DivAddNew'>
                        <h1>Add New Member</h1>";
if (isset($_POST['addmember']))
{
    $NUsername = $_POST['MemberName'];
    $CKAddquery = "SELECT `ID`, `Room` FROM `members` WHERE `UserName` = '$NUsername'";

 
    $CKAddresult = mysqli_query($conn,$CKAddquery);

    if ($CKAddresult)
    {
        $CKAddrows = mysqli_num_rows($CKAddresult);
        if ($CKAddrows == 1)
        { 
            while($CKAddrows = $CKAddresult ->fetch_assoc())
                {
                $BringACustID = $CKAddrows['ID'];
                $CKAddRoom = $CKAddrows['Room'];
                }
            if ($CKAddRoom > 0)
                {
                echo "<span class='sred'>This Member Already member in other room</span>";
                } else 
                {


                    $AcceptUpdateQuery = "UPDATE `members` SET `Room`='$Room' WHERE ID = '$BringACustID'";

                    if (mysqli_query($conn, $AcceptUpdateQuery)) 
                    {
                        $AdderDate = $_POST['joindate'];
                        $AcceptInsertQuery = "INSERT INTO `datetable`(`CustID`, `RoomID`, `RoomJoined`) VALUES ('$BringACustID','$Room', '$AdderDate')";

                        if (mysqli_query($conn, $AcceptInsertQuery))
                            {
                            echo "<span class='sred'>Conguradulations!!.. You are Seccessfully Added Mr. $NUsername to this room </span>";
            
                            }   
                    }
                
                }
            }
            else
            {
                echo "<span class='sred'> Wrong Member Name</span>";
            }
    } else 
        { 
             echo "Query Error 0383732";
        }
}
                    
                    if (IamAvailable())
                    {
                        
                    }else
                    {
                       echo " <script> document.getElementById('DivAddNew').style.display = 'none'; </script>";
                    }

// add new member end

  ?>
   
                <br>

                     
                        
<form method="Post">
                        <div id="holder"> 
            Select Member<br>
                        <input type="text" id="keyword" tabindex="0" name="MemberName" autocomplete='off' >
		                </div>
		                 <div id="ajax_response"></div>
	                     <img src="../images/loading.gif" id="loading">
                         Join Date<br>
                          <?php $date = date("Y-m-01"); 
                          
                            echo "<input type='date' value='$date' name='joindate'>";   
                            ?>

                        <button class="btn"  name="addmember" id ="addmember"> add this member</button>

</form>
                    </div><br>
                    
                    
               
<?php   
         
echo "<div class='login'> <h1>Room Members</h1>";

                
               $RoomMembersQuery = "SELECT MIN(`datetable`.`RoomJoined`) as dates, `members`.`Name`, `members`.`ID`, `datetable`.`WentVecation`, `datetable`.`ReJoin`,`members`.`admin`  FROM `datetable`,`members` WHERE `members`.`Room` = $Room AND `datetable`.`CustID` = `members`.`ID` AND `datetable`.`RoomID` = $Room AND `datetable`.`LeftRoom` IS NULL GROUP BY `members`.`ID`";

                
$Membersresult = mysqli_query($conn,$RoomMembersQuery);

if ($Membersresult)
{

echo "<table><th>Joint Date</th><th>Name</th><th>Status</th>";
while($Mrow = $Membersresult ->fetch_assoc())
{
$MemberName = $Mrow['Name'];
$Joined = $Mrow['dates'];
$membID = $Mrow['ID'];
$WentVecation = $Mrow['WentVecation'];
$ReJoin = $Mrow['ReJoin'];
    $isAdmin = $Mrow['admin'];
    if ($WentVecation <= $ReJoin)
    {
    $MemberStatus = 'Available';
    }
    else
    {
    $MemberStatus = 'on Vecation';
    }
    
    if ($isAdmin == 0)
    {
        $isAdmin = "";
    } else
    {
        $isAdmin = "(Mngr)";
    }
    
    $DateJoined = date("m-d-Y", strtotime($Joined));
echo "<tr id='$membID'><td> $DateJoined</td><td>$MemberName $isAdmin</td>
    <td> $MemberStatus  </td>

</tr>";

}

}

 echo "</table></div>";             
    
 
?>

               
                
 

</div></center>
         
		

        
        
        
        
        
        
        
        
        
<!--        model start-->
        
   <center>     
        <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
       <form method="get" name="form2" id="form2">
            <input type="hidden" name="takeValue" id="takeValue" value="dsf"> </form> 
     
      
<?php
        
        
         if(isset($_GET['takeValue']))
         {
             $MemberID = $_GET['takeValue'];
         }
        else
        {
           $MemberID = 0; 
        }
        
      $ShowMemberQuery = "SELECT `ID`,`joindate`, `Name`, `username`, `admin` FROM `members` WHERE `ID` =  $MemberID";


                    
$ShowMemberResult = mysqli_query($conn,$ShowMemberQuery);

if ($Modelrow = $ShowMemberResult ->fetch_assoc())
{
$ModelMemberID = $Modelrow['ID'];
$ModelJoinDate = $Modelrow['joindate'];
$ModelCustName = $Modelrow['Name'];
$ModelUserName = $Modelrow['username'];
$ModelAdmin = $Modelrow['admin'];

    echo "<input type='hidden' name='MembCustID' id='MembCustID' value='" . $ModelMemberID . "'>";




    
    
    
echo " <br/><h2>$ModelCustName</h2>
    </div>
    <div class='modal-body'>" ;
    
    if(admin())
{
    $disabled = "";
    
}
    else
    {
        $disabled = "disabled";
        echo "<span class='sred'> only room manager can edit this detials</span>";
    }
    
    
    if ($ModelAdmin == 1)
    {
        $ModelStatus = "checked";
        
        
    }
    else
    {
        $ModelStatus = "";
         
    }
    
   
    
echo " <br/>  <br/> <label>
  Manager 
  <input type='checkbox' class='check-custom toggle-switch'  name='CkCheck' id='CkCheck'  onchange='mngChange()' $ModelStatus $disabled>
  
  
  
  <!-- Customization element for the checkbox -->
  <span class='check-toggle'></span>
</label> ";

    
    
    ?>
    
        <script>
            
 


                
        $(document).ready(function(){
            $("#CkCheck").click(function(){
                
                
                 if($("#CkCheck").is(':checked')){
          $("#CkCheck").attr('value', 'true');
      } else
          {
              $("#CkCheck").attr('value', 'false');
          }
                 var Custid=$("#MembCustID").val();
                

                 var Adminstatus=$("#CkCheck").val();
                 ajaxRequest= $.ajax({
                        url:'changeAdmin.php',
                        type:'post',
                        data:{
                            Custid:Custid,
                            Adminstatus:Adminstatus
                            
                        },
                        success:function(response){
                            alert(response);
                            modal.style.display = "none"
                             jQuery(document).ready(function($) {

var url = window.location.href;
    var cururl = url.split('?')[0];
        window.location.replace(cururl);
});
                        }
                    });
                
});
});
        
    
    </script>
    
    
    
    
    
    
   <?php 
    
    
    echo "<form method=POST name ='updateform'>";
    
$AvailableQuery = "SELECT  `WentVecation`, `ReJoin`  FROM `datetable` WHERE  `datetable`.`CustID` = $ModelMemberID AND `datetable`.`RoomID` = $Room";
  
    $AvailableResult = mysqli_query($conn,$AvailableQuery);

if ($Availablerow = $AvailableResult ->fetch_assoc())
{
$AvailWentVecation = $Availablerow['WentVecation'];
$AvailReJoinDate = $Availablerow['ReJoin'];
    
    if ($AvailWentVecation<=$AvailReJoinDate)
    {
        $RdAvail = "checked";
        $RdVecation = "";
    }else
    {
       $RdAvail = "";
        $RdVecation = "checked"; 
    }
}

    
    
   
echo " <br/>
<div id='wentout'>
<div >
<input type='radio' name='status' id='Available' value='Available' class='radio' $disabled $RdAvail/>
<label class='MyLabel' for='Available'>Available</label>
</div>
<div>
<input type='radio' name='status' id='Vecation' value='Vecation' class='radio' $disabled $RdVecation/>
<label class='MyLabel' for='Vecation'>Vecation</label>
</div>
<div>
<input type='radio' name='status' id='Left' value='Left' class='radio' $disabled/>
<label class='MyLabel' for='Left'>Remove</label>
</div> "; 
  
       
   
echo "<div id='DivUpdateDate' style='visibility: hidden'><input type='date' name='UpDate' id='UpDate' value='$date' $disabled></div>";
echo "<button name = 'MemberBtnUpdate' id='MemberBtnUpdate' class='btn' disabled>Update</button>";
    
 

echo "</form>";


}
        
        

        
        
 ?>       
        
     
        
        
        
        
    </div>
    <div class="modal-footer">
      
        
    </div>
  </div>

</div>
        
        
        
        
        
           <?php
       
       
       
       if (isset($_POST['MemberBtnUpdate']))
       {
           
          $UpdateHim = $_GET['takeValue'];
           $HeWent = $_POST['status'];
           $HisDate = $_POST['UpDate'];
          
           
         

           
           
           
           
           if ($HeWent == "Vecation")
    {
      $UpdateLeftRoom =  "UPDATE `datetable` SET `WentVecation` ='" . $HisDate . "' WHERE `CustID` = $UpdateHim AND `RoomID` = $Room AND `LeftRoom` IS NULL"; 
              
        
    }
    else if ($HeWent == "Left")
        
    {
       
       $UpdateLeftRoom =  "UPDATE `datetable` SET `LeftRoom` ='" . $HisDate . "' WHERE `CustID` = $UpdateHim AND `RoomID` = $Room"; 
        
        $WannaToLeft = "UPDATE `members` SET `Room` ='0' WHERE `ID` = $UpdateHim";
       if( mysqli_query($conn, $WannaToLeft))
       {
          
       }
    } 
    else if ($HeWent == "Available")
    {
       
        
        $UpdateLeftRoom =  "UPDATE `datetable` SET `ReJoin` ='" . $HisDate . "' WHERE `CustID` = $UpdateHim AND `RoomID` = $Room AND `LeftRoom` IS NULL"; 
    }
    else 
    {
        echo "something went wrong, contact admin (code 10301)";
    }
    if (mysqli_query($conn, $UpdateLeftRoom )) {

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Updated... </span>';
        header('location: ../session/members.php');
    
    }

           
           
           
           
           
           
       }
       
       
       
            
    
            
             if(isset($_GET['takeValue']))  
    {
                   
                 ?>
        
       <script >
        
          
           
       var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 

         modal.style.display = "block";
       
      
           
           $('input[name=status]').change(function() {
        $("#MemberBtnUpdate").attr('disabled',false);
               document.getElementById("DivUpdateDate").style.visibility = 'visible';
    });
           
           
           
       </script>
   <?php }
           
           
    ?> 
        
        
        
         <script >
   
       
           
        $( "tr" ).click(function() {
            var id = $(this).attr('ID');
            document.getElementById('takeValue').value= id;
//          $("#takeValue").value = $("tr").value;
           
      $( "#form2" ).submit();
               
   
});  
    

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
    
    jQuery(document).ready(function($) {

var url = window.location.href;
    var cururl = url.split('?')[0];
        window.location.replace(cururl);
});
    
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
      
        jQuery(document).ready(function($) {

var url = window.location.href;
    var cururl = url.split('?')[0];
        window.location.replace(cururl);
});
  }
}
      



    </script>         
            
       
            
              <?php
            
//            //        update/delete query start
//        
//        if(isset($_POST['BtnUpdate']))
//        {
//            
//            $NewUpdateQuery = "UPDATE `purchase` SET `Date`='" . $_POST['TxtEditDate'] ."', `Description`= '" . $_POST['TxtEditDescription']. "', `Bill No`='" . $_POST['TxtEditBillNo'] . "', `Amount`='" . $_POST['TxtEditAmount'] . "' WHERE `ID` ='" . $PurchaseID . "'";
//            
//            if(mysqli_query($conn,$NewUpdateQuery))
//            {
//                echo " yes u updated";
//                echo '<script> modal.style.display = "none"; </script>';
//                 header('location: ../session/purchase.php');
//            }
//            else
//            {
//        
//                echo "unable to update";
//            }
//            
//            
////            
//        }
        
        ?>
       
       </center>
        
<!--        Model end-->
        
        
        
        
        
        
        
        
        
        
        
        
            
            





		<footer>
            
		</footer>
	</div>
</div>
 
 <script>



</script>

</body> 
</html>
