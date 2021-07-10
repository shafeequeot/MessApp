<?php
	include("../connect.php");
	$keyword = $_POST['data'];
	$sql = "select RoomName from room where RoomName like '".$keyword."%' limit 0,20";
 
	//$sql = "select name from ".$db_table."";
	$result = mysqli_query($conn,$sql); 
	if(mysqli_num_rows($result))
	{
		echo '<ul class="list">';
		while($row = $result ->fetch_assoc())
		{

			$str = strtolower($row['RoomName']);
			$start = strpos($str,$keyword); 
			$end   = similar_text($str,$keyword); 
			$last = substr($str,$end,strlen($str));
			$first = substr($str,$start,$end);
			
			$final = '<span class="bold">'.$first.'</span>'.$last;
		
			echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
		}
		echo "</ul>";
	}
	else
		echo 0;
?>	   
