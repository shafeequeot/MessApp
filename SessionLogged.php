<?PHP

if (isset($_COOKIE['CustID']))
{
   $COOKIE = $_COOKIE['CustID'];
$squery = "SELECT `UserName`,`Room` FROM `members` WHERE `ID` = '$COOKIE'";

 
$sresult = mysqli_query($conn,$squery);

if ($sresult)
{
$squery_num = mysqli_num_rows($sresult);

if ($squery_num == 1)
{
$roomid =mysqli_fetch_assoc($sresult)['Room'];

if ($roomid == 0 )
{
    setcookie("Room", "0", time() + (86400 * 30), "/");
header('location: ../signup/Selectmethod.php');
}
else
{
// header('location: session');
}
}}

}
else
{
    header('location: index.php');
}
?>




