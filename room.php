<?php

$CheckRoomQuery = "SELECT `Room` FROM `members` WHERE `ID` = '$CustID'";
$CKresult = mysqli_query($conn,$CheckRoomQuery);

if ($CKresult)
{
$CKrows = mysqli_num_rows($CKresult);
if ($CKrows == 1)
{ 
$Room = mysqli_fetch_assoc($CKresult)['Room'];

setcookie("Room", $Room, time() + (86400 * 30), "/");
}
else
{
    $Room = "NULL";
}}

if (isset($_COOKIE['Currency']) & isset($_COOKIE['MonthStart']))
{} else {

$CheckOthersQuery = "SELECT `MonthStart`, `Currency` FROM `room` WHERE `ID` = '$Room'";
$CAresult = mysqli_query($conn,$CheckOthersQuery);

if ($CAresult)
{

while($CArow = $CAresult ->fetch_assoc())
{
$Currency = $CArow['Currency'];
$MonthStart = $CArow['MonthStart'];

    setcookie("Currency", $Currency, time() + (86400 * 30), "/");
    setcookie("MonthStart", $MonthStart, time() + (86400 * 30), "/");
}}}

?>