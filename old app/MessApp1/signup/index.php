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
           <a href="../index.php" class="logo">MessApp</a> 
			
		</header>
		<div class="container">
            <center>
                <div class="login">
      <h1>Create new Account</h1>
    
     <?php
include("../connect.php");


if (isset($_POST['Submit']))

{
  if( $_POST['password'] == $_POST['confirmpassword'])
  {
    $username = $_POST['uname'];
    $query = "SELECT `User_Name` FROM `mess_room` WHERE `User_Name` = '$username'";
    
    $result = mysqli_query($conn,$query);
if ($result)
{
  if (mysqli_num_rows($result) != 0)
  {
      echo '<span style="color:#fb0000;text-align:center;">That username is taken. Try another. </span>';
  }

  else
  {
    $roomname = $_POST['name'];
    $Password = $_POST['password'];
    $hint = $_POST['hint'];
    $email = $_POST['email'];

$insertvalue = "INSERT INTO `mess_room`(`Room_Name`, `User_Name`, `Password`, `Hint`, `Email`) VALUES ('$roomname','$username','$Password','$hint','$email')";

if (mysqli_query($conn, $insertvalue)) {

    echo '<span class="sred">Conguradulations!!.. You are Seccessfully Created New Account... Please login to Continue</span>';
    header("refresh:3;url=../");
   


} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



  }}
    }
  else {echo '<span style="color:#fb0000;text-align:center;">Password not same</span>';}
}
    ?>
    
    <form method=post>
    <input type="text" id = "name" placeholder="Mess Room Name" name ="name" required /><br/>
    <input type="text" id = "uname" placeholder="User Name" name ="uname" required/><br/>
    <input type="password" id = "password" placeholder="Password" name ="password" required /><br/>
    <input type="password" id = "confirmpassword" placeholder="Confirm Password" name ="confirmpassword" required/><br/>
    <input type="text" id = "hint" placeholder="Password Hint" name ="hint" required /><br/>
    <input type="email" id = "email" placeholder="Email ID (for password recovery)" name ="email" required /><br/><br/>
    <input type="submit" class ="btn btn-def btn-block" Value = " Create New Account" name="Submit" align ="center"><br/>
    <br><br>
    <span> Already have Account?<a href="../"> Click here</a></span>

</form>


</div></center>
            
		</div>
		<footer>
            
		</footer>
	</div>
</div>
 

</body> 
</html>
