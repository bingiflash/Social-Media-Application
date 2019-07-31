<?php
session_start();
require 'connect.php';
if(isset($_SESSION["user"]))
{
if(isset($_POST["comment"]) && !empty($_POST["combody"]))
{
	$tid = $_GET["id"];
	$sql = "INSERT INTO `comment` VALUES (null,".$_SESSION["uid"].",".$tid.",\"".$_POST["combody"]."\",NOW())";
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