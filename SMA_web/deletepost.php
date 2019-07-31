<?php
session_start();
require 'connect.php';
if(isset($_SESSION["user"]))
{
	$tid = $_GET["id"];
	$sql = "DELETE FROM twitts WHERE tid=".$tid;
	$result = mysqli_query($conn, $sql);
	echo "<script>location.href='login.php'</script>";
}
else
{
	echo "<script>alert('You should login to access this page')</script>";
	echo "<script>location.href='index.php'</script>";
}
?>