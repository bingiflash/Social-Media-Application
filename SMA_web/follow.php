<?php
session_start();
require 'connect.php';
if(isset($_SESSION["user"]))
{
if(strcmp($_GET["do"],'unfollow')==0)
{
	$sql = "DELETE FROM follow WHERE follower_id=".$_SESSION["uid"]." and following_id=".$_GET["id"];
	$result = mysqli_query($conn, $sql);
}
if(strcmp($_GET["do"],'follow')==0)
{
	$sql = "INSERT INTO follow VALUES (".$_SESSION["uid"].",".$_GET["id"].",NOW())";
	$result = mysqli_query($conn, $sql);
}
echo "<script>location.href='login.php'</script>";
}
else
{
	echo "<script>alert('You should login to access this page')</script>";
	echo "<script>location.href='index.php'</script>";
}
?>