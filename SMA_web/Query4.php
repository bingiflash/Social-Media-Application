<?php
require 'connect.php';
$sql = "select body from twitts,user where user.uid = twitts.uid and user.username = \"".$_POST["Loginname"]."\"";
$result = mysqli_query($conn, $sql);
$i = mysqli_num_rows($result);
if($i)
{
	echo "<b>Posts by ".$_POST["Loginname"]."</b> - <br><br>";
	while($i--)	
		echo mysqli_fetch_assoc($result)["body"]."<br><br>";
}
else
	echo "No posts by ".$_POST["Loginname"]."<br><br>";
echo "<a href='index.php'><input type=\"button\" value=\"back\" ></a>"
?>