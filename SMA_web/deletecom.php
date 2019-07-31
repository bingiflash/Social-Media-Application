<?php
session_start();
require 'connect.php';
if(isset($_SESSION["user"]))
{
	$cid = $_GET["id"];
	$sql = "DELETE FROM `comment` WHERE cid=".$cid;
	$result = mysqli_query($conn, $sql);
	echo "<script>location.href='login.php'</script>";
}
else
{
	echo "<script>alert('You should login to access this page')</script>";
	echo "<script>location.href='index.php'</script>";
}
?>