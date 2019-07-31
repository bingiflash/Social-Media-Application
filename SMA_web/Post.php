<?php
session_start();
require 'connect.php';
if(isset($_SESSION["user"]))
{
	if(isset($_POST["Post"]) && !empty($_POST["body"]))
	{
		$sql = "INSERT INTO `twitts`(`tid`, `uid`, `body`, `post_time`) VALUES (null,".$_SESSION["uid"].",'".$_POST["body"]."',NOW())";
		$result = mysqli_query($conn, $sql);
		echo "<script>location.href='login.php'</script>";
	}
}
else
{
	echo "<script>alert('You should login to access this page')</script>";
	echo "<script>location.href='index.php'</script>";
}
?>