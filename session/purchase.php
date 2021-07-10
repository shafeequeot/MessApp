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
           <a href="../session/purchase.php" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
      <h1>Purchase</h1>
    
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
                    

  
// Pani stalam start
                    
                    
                    
                    
    if(isset($_POST['SubmitPurchase']))
    {
        $Date = $_POST['PurchaseDate'];
        $Description = $_POST['Description'];
        $BillNo = $_POST['BillNo'];
        $Amount = $_POST['Amount'];
        
                 $PurchaseQuery = "INSERT INTO `purchase`(`Date`, `CustID`, `Room`, `Description`, `Bill No`, `Amount`) VALUES ('$Date','$CustID', '$Room', '$Description', '$BillNo', '$Amount')";

                        if (mysqli_query($conn, $PurchaseQuery))
                            {
                            echo "<span class='sred'>Conguradulations!!.. You are Seccessfully Updated </span>";
            
                            } else
                        {
                            echo "some thing went worng: 212456512";
                        }
    }
                    
                    
    ?>                
                    
                    
                    
<form method="Post">
                        
		                 
                          <?php $date = date("Y-m-d"); 
                          
                            echo "<input type='date' value='$date' name='PurchaseDate' ID='PurchaseDate'>";   
                            ?>
    
    
            
    <input type="text"  id="Description" placeholder="Description" tabindex="0" name="Description" autocomplete='off' /> <br/>
    
    <input type="text" placeholder="Bill No" id="BillNo" tabindex="1" name="BillNo" autocomplete='off' /><br/>
    
    
<?php 
    $MyCurrencyQuery = "SELECT `ID`, `Currency`, `Type` FROM `currency` WHERE `ID` =" . $_COOKIE['Currency'] ;
                
$MyCurrencyResult = mysqli_query($conn,$MyCurrencyQuery);
if ($MyCurrencyResult)
{
    
  
$MySqlCurrency = $MyCurrencyResult ->fetch_assoc();

   $MyCurrency = $MySqlCurrency['Currency'];
    $MyCurrencyType = $MySqlCurrency['Type'];
    
    if($MyCurrencyType == 2)
    {
        $CurrencyType = '0.01';
        $NoFormat = "2";
    }
    else
    {
        $CurrencyType = '0.001';
        $NoFormat = "3";
    }
    
  }
   
    
    
   echo '<input type="Number" placeholder= "Amount (' . $MyCurrency . ')" id="Amount" tabindex="2" name="Amount" autocomplete="off" required step= "' . $CurrencyType . '"<br/><br/>';
	 ?>	                

                        <button class="btn"  name="SubmitPurchase" id ="SubmitPurchase">Add Detials</button>

</form>
        
    
        
    


            
           


            
 <?           
                           

   
               
                    
              $CheckRoomMonth =  date('Y-m');
                   
                    
      $RoomStatementQuery = "SELECT `purchase`.`ID`,`purchase`.`Date`, `members`.`Name`,`purchase`.`Description`, `purchase`.`Bill No`, `purchase`.`Amount` FROM `purchase`,`members` WHERE `purchase`.`CustID` = `members`.`ID` AND `purchase`.`Room` = $Room AND DATE_FORMAT(`purchase`.`Date`, '%Y-%m') = '$CheckRoomMonth' ";


                    
$StatementResult = mysqli_query($conn,$RoomStatementQuery);

if ($StatementResult)
{

echo "<table><th>Date</th><th>Brought By</th><th>Amount</th>";
    $ID = 0;
    $TotalAmount = 0;
while($Srow = $StatementResult ->fetch_assoc())
{
    $ID = $ID + 1;
    
$MemberName = $Srow['Name'];
$Amount = $Srow['Amount'];
$TblValue = $Srow['ID'];
    $PurchaseDate = $Srow['Date'];
    
$TotalAmount = $TotalAmount + $Amount;
   
echo "<tr ID='$TblValue'><td> $PurchaseDate</td><td>$MemberName</td><td>" . number_format($Amount,$NoFormat) . "</td>

</tr>";

}

}
            

 echo "<tr><td bgcolor='#fce297' colspan='2'><h3>Total</h3></td><td bgcolor='#fce297'><h3>" . number_format($TotalAmount,$NoFormat) ." " . $MyCurrency . "</h3></td></tr></table>";             
                    
 

            
      ?>    
            
            
            
            
     <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
       <form method="get" name="form2" id="form2">
            <input type="hidden" name="takeValue" id="takeValue" value="dsf"> </form> 
      <h2>Modify<br/></h2>
    </div>
    <div class="modal-body">
      
<?php
         if(isset($_GET['takeValue']))
         {
             $PurchaseID = $_GET['takeValue'];
         }
        else
        {
           $PurchaseID = 0; 
        }
        $CheckRoomMonth =  date('Y-m');
      $EditStatementQuery = "SELECT `purchase`.`ID`,`purchase`.`Date`, `purchase`.`CustID`, `members`.`Name`,`purchase`.`Description`, `purchase`.`Bill No`, `purchase`.`Amount` FROM `purchase`,`members` WHERE `purchase`.`CustID` = `members`.`ID` AND `purchase`.`ID` =  $PurchaseID";


                    
$EditStatementResult = mysqli_query($conn,$EditStatementQuery);

if ($Erow = $EditStatementResult ->fetch_assoc())
{
$PurchaseID = $Erow['ID'];
$CheckCustID = $Erow['CustID'];
$EditDate = $Erow['Date'];
$EditCustName = $Erow['Name'];
$EditDescription = $Erow['Description'];
$EditBillNo = $Erow['Bill No'];
$EditAmount = $Erow['Amount'];

$formatedAmount =  number_format($EditAmount,$NoFormat, '.', '');

if($CustID==$CheckCustID || admin())
{
    $disabled = "";
}
    else
    {
        $disabled = "disabled";
        echo "<span class='sred'> only can edit detials their own detials or room admin</span>";
    }

echo "<form id=UpdateForm method='POST'><br><h3>Brought By: $EditCustName </h3>";  
echo "<input type='date' value=$EditDate name='TxtEditDate' id='TxtEditDate' $disabled/>";
echo "<br/>Bill No.<input type='text' value=$EditBillNo name='TxtEditBillNo' $disabled/>";
echo "Description<input type='text' value='$EditDescription' name='TxtEditDescription' $disabled/>";
echo '<input type="number" id="TxtEditAmount" value="' . $formatedAmount . '" name= "TxtEditAmount" autocomplete="off"  step="' . $CurrencyType . '" ' . $disabled . ' required>'; 
    
    
    
    if($CustID==$CheckCustID || admin())
{
    echo "<button class='btn'  name='BtnUpdate' id ='BtnUpdate' >Update</button>";
echo "<button class='btn'  name='BtnDelete' id ='BtnDelete' >Delete</button>";
}


echo "</form>";


}
        
        

        
        
 ?>       
        
        
    </div>
    <div class="modal-footer">
      
        
    </div>
  </div>

</div>
            
            
            
                    
            
            
<!-- Link to open the modal -->

            
     <?php
            
            
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

         modal.style.display = "block";</script>
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
            
            //        update/delete query start
        
        if(isset($_POST['BtnUpdate']))
        {
            
            $NewUpdateQuery = "UPDATE `purchase` SET `Date`='" . $_POST['TxtEditDate'] ."', `Description`= '" . $_POST['TxtEditDescription']. "', `Bill No`='" . $_POST['TxtEditBillNo'] . "', `Amount`='" . $_POST['TxtEditAmount'] . "' WHERE `ID` ='" . $PurchaseID . "'";
            
            if(mysqli_query($conn,$NewUpdateQuery))
            {
                echo " yes u updated";
                echo '<script> modal.style.display = "none"; </script>';
                 header('location: ../session/purchase.php');
            }
            else
            {
                echo "unable to update";
            }
            
            
//            
        }
        
        if(isset($_POST['BtnDelete']))
        {
            $DeleteQuery = "DELETE FROM `purchase` WHERE ID = $PurchaseID";
            if(mysqli_query($conn,$DeleteQuery))
            {
                echo "<span class='sred'>Seccess fully deleted</span>";
               
          header('location: ../session/purchase.php');
                




               
            }else
            {
                echo "<span class='sred'>Unabled to delete!</span>";
            }
            
            
            
            
        }

        
        
//        update /delete query end
            ?>
            
            
            
            
            
            
            
    <!-- Pani stalam end -->        
            
            
            
            
                    </center>    </div></div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
