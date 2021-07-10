
<?PHP

ob_start();
session_start();
function loggedin()
{
if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $COOKIE = $_COOKIE['CustID'];
$query = "SELECT `ID` FROM `joinroom` WHERE `CustID` = '$COOKIE'";
 $conn = new mysqli("localhost", "admin", "admin", "Messapp");
$result = mysqli_query($conn,$query);

if ($result)
{
$query_num = mysqli_num_rows($result);

if ($query_num >= 1)
{

return true;
}
else
{
    return false;
}}}}




//check admin start

function admin()
{
if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $CustID = $_COOKIE['CustID'];
    $Room = $_COOKIE['Room'];
$CheckAdminQuery = "SELECT `ID`  FROM `room` WHERE `ID` = '$Room' AND `RoomCreatedBy` = $CustID UNION (SELECT `ID` FROM `members` WHERE `ID` = '$CustID' AND `admin` = '1')";
 $conn = new mysqli("localhost", "admin", "admin", "Messapp");
$result = mysqli_query($conn,$CheckAdminQuery);

if ($result)
{
$query_num = mysqli_num_rows($result);

if ($query_num >= 1)
{

return true;
}
else
{
    return false;
}}}}

//check admin end



//check member on vecation start

function IamAvailable()
{
if (isset($_COOKIE['CustID']) && !empty($_COOKIE['CustID']))
{
   $CustID = $_COOKIE['CustID'];
    $Room = $_COOKIE['Room'];
$CheckMyAvailablity = "SELECT * FROM `datetable` WHERE `WentVecation` > `Rejoin` AND `LeftRoom` IS NULL AND `CustID` = $CustID AND `RoomID` = $Room ";
   
    
 $conn = new mysqli("localhost", "admin", "admin", "Messapp");
$result = mysqli_query($conn,$CheckMyAvailablity);

if ($result)
{
$query_num = mysqli_num_rows($result);

if ($query_num >= 1)
{

return false;
}
else
{
    return true;
}}}}

//check member on vecation end





?>



