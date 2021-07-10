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
            <a href='../'><i href="../" class="left"></i> </a>
            <a href="../statement" class="logo">MessApp</a> 
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
$norow = '0';


if(isset($_POST['thismonth']))
{
 
$month = date('m', strtotime($_POST['thismonth']));
$year = date('Y', strtotime($_POST['thismonth']));
$fullmonth = date('M', strtotime($_POST['thismonth']));
}else
{
  $month = date('m');
  $year = date('Y');
   $fullmonth = date('M');
}
echo "<div class='login' align='center'>";
echo "<h1> Statement of " .  $fullmonth ." ". $year . "</h1>";
?>




<!--calculation pad start-->



<form id='submitmonth' method='POST'>
<input type='date' id ='thismonth' name='thismonth' OnChange="monthchange()"></input><br><br>
</form>





<script>
  function monthchange()
{
   $('#submitmonth').submit();
}
// document.getElementById('thismonth').value= new Date().toJSON().slice(0,10);


</script>





<?php


$totalamount = '0';


$id = $_SESSION['id'];
$totalquery = "SELECT ROUND(SUM(`Amount`),2) as total FROM `purchase` WHERE `Room_ID`= '$id' AND MONTH(`Purchase_Date`) = '$month' AND  YEAR(`Purchase_Date`) = '$year'";

$totalresult = mysqli_query($conn,$totalquery);
if ($totalresult)
{

if ($totalresult->num_rows > 0)
{
$total = $totalresult ->fetch_assoc()['total'];
if ($total == NULL)
{
  $total = "0";
}
echo "<h1>Total Expense: " . $total . "</h1>";
}}




// calculation table start
echo "<div class='tabdiv'><table><tr><th>No.</th><th>Name</th>";

//Table Date |  new member start

if(isset($_POST['thismonth']))
{
  
$thisMonth = date('n', strtotime($_POST['thismonth']));
$thisYear = date('Y', strtotime($_POST['thismonth']));
$firstDate = date('Y-m-01', strtotime($_POST['thismonth']));
}else
{
  $thisMonth = date("n");
$thisYear = date("Y");
$firstDate = date('Y-m-01');
}




$columnid = "0";
$rowid = "0";
$part = '1';
 
$NJQuery = "SELECT `Join_Date` FROM `vecation` WHERE `Room_ID` = '$id' AND MONTH(`Join_Date`) = '$thisMonth' AND YEAR(`Join_Date`) = '$thisYear' UNION SELECT `ReJoin` FROM `vecation` WHERE `Room_ID` = '$id' AND MONTH(`ReJoin`) = '$thisMonth' AND YEAR(`ReJoin`) = '$thisYear' UNION SELECT `Vecation` FROM `vecation` WHERE `Room_ID` = '$id' AND MONTH(`vecation`) = '$thisMonth' AND YEAR(`Vecation`) = '$thisYear' UNION SELECT `RoomVecated` FROM `vecation` WHERE `Room_ID` = '$id' AND MONTH(`RoomVecated`) = '$thisMonth' AND YEAR(`RoomVecated`) = '$thisYear' UNION SELECT DISTINCT LAST_DAY (`Purchase_Date`)  FROM `purchase` WHERE MONTH(`Purchase_Date`) = '$thisMonth' ";

$NJresult = mysqli_query($conn,$NJQuery);
if ($NJresult)
{

if ($NJresult->num_rows > 0)
{

  if ($NJresult->num_rows == 1 )
  {
// echo "<th> Total </th>";

  }
 else{
  
while ($NJmember = $NJresult ->fetch_assoc())
{
  
   $norow = '1';
  $NewMemberDate = $NJmember['Join_Date'];
  $columnid = $columnid + 1;
  $rowid = $rowid + 1;
  $firstDateshow = date("d/m/y", strtotime($firstDate));
   $NewMemberDateshow = date("d/m/y", strtotime($NewMemberDate));
   
echo "<th> Part " . $part . "<br>" . $firstDateshow ." to " . $NewMemberDateshow . "</th>";
$part = $part + 1;
$firstDate = $NewMemberDate;
 }}
}
} 
Echo "<th>Total </th><th>Expenses </th><th> Balance </th></tr><tr>";
    
$sno ="0";
    $NameQuery= "SELECT `ID` FROM `members` WHERE `Status` = '1' AND `Room_ID` = '$id' AND `ID` NOT IN (SELECT `Name` AS ID FROM `vecation` WHERE Month(`Join_Date`)>=$thisMonth AND YEAR(`Join_Date`) = $thisYear) UNION SELECT Distinct `Name` FROM `vecation` WHERE (MONTH(`Join_Date`) = '$thisMonth' AND YEAR(`Join_Date`) = '$thisYear' AND`Room_ID` = '$id') OR (MONTH(`ReJoin`) = '$thisMonth' AND YEAR(`ReJoin`) = '$thisYear' AND `Room_ID` = '$id') OR (MONTH(`Vecation`) = '$thisMonth' AND YEAR(`Vecation`) = '$thisYear' AND `Room_ID` = '$id') OR (MONTH(`RoomVecated`) = '$thisMonth' AND YEAR(`RoomVecated`) = '$thisYear' AND `Room_ID` = '$id')";

$Nameresult = mysqli_query($conn,$NameQuery);
if ($Nameresult->num_rows > 0)
{
$totalmembers = mysqli_num_rows($Nameresult);
 while ($Names = $Nameresult ->fetch_assoc())
{

if(isset($_POST['thismonth']))
{
  
$monthstart = date('Y-m-01', strtotime($_POST['thismonth']));

}else
{
$monthstart = date('Y-m-01');
}



  
   $sno = $sno+ "1";
 $PMmemberidlist = $Names['ID'];
  $PMNAMEquery = "SELECT `Name` FROM `members` WHERE `ID` = '$PMmemberidlist'";
 
$PMNAMEresult = mysqli_query($conn,$PMNAMEquery);

if ($PMNAMEresult)
{
$query_num = mysqli_num_rows($PMNAMEresult);

if ($query_num == 1)
{ 
$PMnamelist = mysqli_fetch_assoc($PMNAMEresult)['Name'];
}}
  
echo "<tr><td>" . $sno . "</td><td>" . $PMnamelist . "</td>";
$sno =+$sno;
$totalamount = '0';


$Dateresult = mysqli_query($conn,$NJQuery);
if ($Dateresult)
{

if ($Dateresult->num_rows > 0)
{
 
while ($Datemember = $Dateresult ->fetch_assoc())
{
  
  $PartDate = $Datemember['Join_Date'];


// part calculation in table row start


// check how many members start
$HowmanyQuery= "SELECT Distinct `Name` FROM `vecation` WHERE (MONTH(`Join_Date`) = '$thisMonth' AND YEAR(`Join_Date`) = '$thisYear' AND `Join_Date`< '$PartDate'  AND `Room_ID` = '$id') OR (MONTH(`ReJoin`) = '$thisMonth' AND YEAR(`ReJoin`) = '$thisYear' AND `ReJoin`< '$PartDate' AND `Room_ID` = '$id') OR (MONTH(`Vecation`) = '$thisMonth' AND YEAR(`Vecation`) = '$thisYear' AND  `Vecation`>= '$PartDate'  AND `Room_ID` = '$id') OR (MONTH(`RoomVecated`) = '$thisMonth' AND YEAR(`RoomVecated`) = '$thisYear' AND `RoomVecated`>= '$PartDate'  AND `Room_ID` = '$id') UNION SELECT `ID` FROM `members` WHERE `Status` = '1' AND `Room_ID` = '$id' AND ID NOT IN (SELECT `Name` from `vecation` WHERE (MONTH(`Join_Date`) >= '$thisMonth' AND YEAR(`Join_Date`) >= '$thisYear' AND `Room_ID` = '$id') OR (MONTH(`ReJoin`) = '$thisMonth' AND YEAR(`ReJoin`) = '$thisYear' AND `Room_ID` = '$id') OR (MONTH(`Vecation`) = '$thisMonth' AND YEAR(`Vecation`) = '$thisYear' AND `Room_ID` = '$id') OR (MONTH(`RoomVecated`) = '$thisMonth' AND YEAR(`RoomVecated`) = '$thisYear' AND `Room_ID` = '$id'))"; 

$howmanyresult = mysqli_query($conn,$HowmanyQuery);
if ($howmanyresult->num_rows > 0)
{
$totalmembers1 = mysqli_num_rows($howmanyresult);
// echo $totalmembers1;
}
else
{
  $totalmembers1 = '1';
}
// check how many members end




$checkjoinquery = "SELECT ROUND(SUM(`Amount`) / '$totalmembers1',2) AS PartAmount FROM `purchase` WHERE `Room_ID` = '$id' AND `Purchase_Date` >= '$monthstart' AND `Purchase_Date` < '$PartDate'";

 
$checkjoinresult = mysqli_query($conn,$checkjoinquery);

if ($checkjoinresult)
{
$query_num = mysqli_num_rows($checkjoinresult);
if ($checkjoinresult->num_rows > 0)

{


$bringPartAmount = $checkjoinresult ->fetch_assoc();
  $PartAmount = $bringPartAmount['PartAmount']; 

// check except members start

$ExceptQuery = "SELECT `ID` FROM `vecation` WHERE (`Name` = '$PMmemberidlist' AND `Join_Date` > '$monthstart') OR (`Name` = '$PMmemberidlist' AND `ReJoin` > '$monthstart')";
$exceptresult = mysqli_query($conn,$ExceptQuery);
if ($exceptresult)
{

if ($exceptresult->num_rows > 0)
{
$PartAmount = '0';
}}

$ExceptQuery2 = "SELECT `ID` FROM `vecation` WHERE (`Name` = '$PMmemberidlist' AND `Vecation` < '$PartDate') OR (`Name` = '$PMmemberidlist' AND `RoomVecated` < '$PartDate')";
$exceptresult2 = mysqli_query($conn,$ExceptQuery2);
if ($exceptresult2)
{

if ($exceptresult2->num_rows > 0)
{
$PartAmount = '0';
}}

// check except members end


    if ($PartAmount == NULL)
    {
        $PartAmount = '0';
    }
    if ($norow == '0')
    {

    }
    else
    {
echo "<td>" . $PartAmount . "</td>";
    }
    

    $totalamount = $totalamount + $PartAmount;



}

else
{
echo "<td>Some thing went wrong</td>";
}

$monthstart = $PartDate;



// part calculation in table end


 
 

 }
}
} 

echo "<td>$totalamount</td>";
// expense row start

$expensequery = "SELECT ROUND(SUM(`Amount`),2)  AS Myexpense FROM `purchase` WHERE `Room_ID` = '$id' AND `Name` = '$PMmemberidlist' AND MONTH(`Purchase_Date`) = '$thisMonth' AND YEAR(`Purchase_Date`) = '$thisYear'";

 
$expenseresult = mysqli_query($conn,$expensequery);

if ($expenseresult)
{
$query_num = mysqli_num_rows($expenseresult);
if ($expenseresult->num_rows > 0)

{
  $MyTotalExpanse = $expenseresult ->fetch_assoc()['Myexpense'];
   if ($MyTotalExpanse == Null)
   {
     $MyTotalExpanse = 0;
   }
echo "<td>" . $MyTotalExpanse . "</td>";
    $MyBlance = $MyTotalExpanse - $totalamount;

}}

else
{
echo "<td>0</td>";
}

}
if ($MyBlance < 0)
{
  $span = '<span class=sred> ';
}
else{
 $span = '<span class=sgreen>';
}
    echo "<td>$span". $MyBlance . "</span></td>";
// expense row end



echo "</tr>";

 }
}






echo "</table></div>";
// calculation table end




?>
</div>
<!--calculation pad end-->

		<footer>
           

		</footer>
	</div>
        </div></div>
 

</body> 
</html>
