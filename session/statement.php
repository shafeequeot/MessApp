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
           <a href="../session/statement.php" class="logo">MessApp</a> 
			
		</header>
-->
		<div class="container">
            <center>
                <div class="login">
<!--      <h1>Statements</h1>-->
    
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
        
                  if(isset($_POST["FilterDate"]))
{
    
                    $ThisMonth = $_POST['FilterDate'];
                    $CheckRoomMonth = $_POST['FilterDate'];
                    $tabid1 = "";
                    $tabid2 = "defaultOpen";
}
   else
   {
        $ThisMonth = date('Y-m');
       $CheckRoomMonth =  date('Y-m');
       $tabid1 = "defaultOpen";
       $tabid2 = "";
                        
   } 
   
       if(isset($_GET['takeValue']))
       {
           $tabid1 = "";
                    $tabid2 = "defaultOpen";
       }
   
          
                    
                    
                    
                    if (isset($_POST['PayFilterDate'])) 
    {
                        $PayThisMonth = $_POST['PayFilterDate'];
          $PayMonth = date ("m", strtotime($_POST['PayFilterDate']));
           $PayYear = date ("Y", strtotime($_POST['PayFilterDate']));
           
      }
      else
    {
          $PayThisMonth = date('Y-m');
        $PayMonth = date('m');
           $PayYear = date('Y');
    }
                    
                    
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
                   
    ?>                
                    
              
                    

      
<!--pani sthalam start-->
                    
                    
   <div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Statement')" id="<?php echo $tabid1; ?>">Payments</button>
  <button class="tablinks" onclick="openCity(event, 'Archive')" id ="<?php echo $tabid2; ?>">Archive</button>                 
                    
    </div>     
                    
                    
  <div id="Statement" class="tabcontent">
  
  <?php
      
     $CurrentMonth = date("Y-m-d");
  echo "<span> &nbsp;</span><h3 >Select Month</h3>
   <form method='POST' name='PaySubmit' id='PaySubmit'>
    <input type='Month' value='$PayThisMonth' id='PayFilterDate'  Name='PayFilterDate' placeholder='Previous Month'  
     onchange='this.form.submit();'/> </form>"; 
                        
       
       
                        
                        
              $StateRoomMembers = "SELECT `ID`,`Name` FROM `members` WHERE `Room` = $Room UNION (SELECT `datetable`.`CustID`, `members`.`Name` FROM `datetable`, `members` WHERE `members`.`ID` = `datetable`.`CustID` AND `datetable`.`RoomID` = $Room AND MONTH(`datetable`.`LeftRoom`) =" . date("m") . " AND YEAR(`datetable`.`LeftRoom`) = " . date("Y") . ")";
      
     
 
                    
$StateMemberResult = mysqli_query($conn,$StateRoomMembers);

if ($StateMemberResult)
{

echo "<table><th>Name</th><th>Paid</th><th>Expense</th><th>Balance</th>";
    
   
while($SMrow = $StateMemberResult ->fetch_assoc())
{
   
   $totalMember = mysqli_num_rows($StateMemberResult);
       
$MemberName = $SMrow['Name'];
    $MyID = $SMrow['ID'];
    

$MyTotalQuery = "SELECT SUM(`Amount`) as MyAmount FROM `purchase` WHERE `Room` = $Room AND `CustID` = $MyID AND Month(`Date`) = $PayMonth and YEAR(`Date`) = $PayYear ";
    
     $MyTotalResult = mysqli_query($conn,$MyTotalQuery);           
if( $MyTotalResult)
{
   
   $MyTotalBring = $MyTotalResult ->fetch_assoc();
    $MyTotalAmount = $MyTotalBring['MyAmount'];
 
}
    
    
    $RoomTotalQuery = "SELECT SUM(`Amount`) as TotalAmount FROM `purchase` WHERE `Room` = $Room AND Month(`Date`) = $PayMonth and YEAR(`Date`) = $PayYear";
     $RoomTotalResult = mysqli_query($conn,$RoomTotalQuery);           
if($RoomTotalResult)
{
   
   while($RoomTotalBring = $RoomTotalResult->fetch_assoc())
   {
    $RoomTotalAmount = $RoomTotalBring['TotalAmount'];
   }
}
    
    
    
    
    
    
    
    

//    $EachExpense = $TotalExp/$totalMember;
  
//    
    $Expense = $RoomTotalAmount / $totalMember;
    $Balance = $MyTotalAmount - $Expense;
echo "<tr><td>$MemberName</td><td>" . number_format($MyTotalAmount,$NoFormat) . "</td><td>$Expense</td><td>$Balance</td>

</tr>";

}

}
            

 echo "</table>";           
                        
                        
                        
   ?>                     
                        
                        
                        
                        
</div>
                    
                    
            
                    
                    
                    
                    
                    
                    
                    
  <div id="Archive" class="tabcontent">
  
                       
  <?php
                
                
                    

   echo "<span> &nbsp;</span><h3 >Select a month</h3>
   <form method='POST' name='submit' id='submit'>
    <input type='month' value='$ThisMonth' id='FilterDate'  Name='FilterDate' defaplaceholder='Previous Month' onchange='this.form.submit();'/> </form>";
   
                 
              
                    
      $RoomStatementQuery = "SELECT `purchase`.`ID`, `purchase`.`Date`, `members`.`Name`,`purchase`.`Description`, `purchase`.`Bill No`, `purchase`.`Amount` FROM `purchase`,`members` WHERE `purchase`.`CustID` = `members`.`ID` AND `purchase`.`Room` = $Room AND DATE_FORMAT(`purchase`.`Date`, '%Y-%m') = '$CheckRoomMonth' ";


                    
$StatementResult = mysqli_query($conn,$RoomStatementQuery);

if ($StatementResult)
{

echo "<table id = 'table2'><th>Date</th><th>Brought By</th><th>Amount</th>";
    $ID = 0;
    $TotalAmount = 0;
while($Srow = $StatementResult ->fetch_assoc())
{
    $ID = $ID + 1;
    
$MemberName = $Srow['Name'];
$Amount = $Srow['Amount'];
$TotalAmount = $TotalAmount + $Amount;
    $PurchaseDate = $Srow['Date'];
   $TblAValue = $Srow['ID'];
   
echo "<tr ID='$TblAValue' ><td> $PurchaseDate</td><td>$MemberName</td><td>" . number_format($Amount,$NoFormat) . "</td>

</tr>";

}

}
            

 echo "<tr><td bgcolor='#fce297' colspan='2'><h3>Total</h3></td><td bgcolor='#fce297'><h3>" . number_format($TotalAmount,$NoFormat) . "</h3></td></tr></table>";             
                    
                    
      ?>     
</div>
                    
     
                    
                    
                    
                    
                    
                    
<!--                    Model panisthalam start-->
                    
    <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
       <form method="get" name="form2" id="form2">
            <input type="hidden" name="takeValue" id="takeValue" value="dsf"> </form> 
      <br/><h2>Modify</h2><br/>
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


        $disabled = "disabled";
       
    

echo "<form id=UpdateForm method='POST'><br><h3>Brought By: $EditCustName </h3>";  
echo "<input type='date' value=$EditDate name='TxtEditDate' id='TxtEditDate' $disabled/>";
echo "<br/>Bill No.<input type='text' value=$EditBillNo name='TxtEditBillNo' $disabled/>";
echo "Description<input type='text' value='$EditDescription' name='TxtEditDescription' $disabled/>";
echo '<input type="number" id="TxtEditAmount" value="' . $formatedAmount . '" name= "TxtEditAmount" autocomplete="off"  step="' . $CurrencyType . '" ' . $disabled . ' required>'; 
    
    
    


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
   
       
           
        $( "#table2 tr" ).click(function() {
            var id = $(this).attr('ID');
            document.getElementById('takeValue').value= id;
//          $("#takeValue").value = $("tr").value;
           
      $( "#form2" ).submit();
               
   
});  
    

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
      



    </script>         
            
       
            
      

        
  
                    
                    
                    
                    
                    
<!--      Model panisthalam end              -->
                 
                   
                    
                    
<script type="text/javascript">

window.open('', '_self', '');
window.close();
    

  
function openCity(evt, StatementName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(StatementName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

  
  $(document).ready(function(){
    $("#PayFilterDate").datepicker({
        minDate: "-1m"
    })
})  
    
</script>
            
 <!--pani sthalam end-->          

</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
