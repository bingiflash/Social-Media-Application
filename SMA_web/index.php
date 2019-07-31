<?php
require 'connect.php';
?>
<html>
<head>
<style>
td {
	
	vertical-align: top;
	padding: 20px;
}
</style>
</head>
<body> 
<table border=5 style="width:100%">
  <tr>
    <td>
	<p><b>Query 1: Posts with most no.of likes</b></p>
	<?php
	$sql = "SELECT uid, body from twitts t, (SELECT tid from (SELECT count(like_id) AS no_likes, tid from thumb GROUP BY tid) as temp1 where no_likes = (SELECT max(no_likes) from (SELECT count(like_id) AS no_likes, tid from thumb GROUP BY tid) as temp2)) AS temp3 where t.tid=temp3.tid";
	//echo $sql."<br>";
	$result = mysqli_query($conn, $sql);
	$i = mysqli_num_rows($result);
	if($i)
		while($i--)
		{
			$temp=mysqli_fetch_assoc($result);
			$sql1="SELECT username from user where uid = ".$temp['uid'];
			$result1= mysqli_query($conn,$sql1);
			
			echo "<br><b>".mysqli_fetch_assoc($result1)['username']."</b> - ".$temp["body"];
		}
	?>
	</td>
    <td>
	<p><b>Query 2: Users with highest no.of followers</b></p>
	<?php
	$sql = "select username from user, (select count(following_id) AS no_followers,following_id from follow GROUP BY following_id) as temp1 where no_followers = (select max(no_followers) from (select count(following_id) AS no_followers,following_id from follow GROUP BY following_id) as temp1) and temp1.following_id = user.uid";
	//echo $sql."<br>";
	$result = mysqli_query($conn, $sql);
	$i = mysqli_num_rows($result);
	if($i)
		while($i--)
			echo "<br>".mysqli_fetch_assoc($result)["username"];
	?>
	</td> 
    <td>
	<p><b>Query 3: Twitt details regarding FLU</b></p>
	<?php
	$sql = "SELECT location,count(body) from user u ,(select uid,body from twitts where (body LIKE 'flu %') or (body like '% flu') or (body LIKE '%flu %' and body like '% flu%') or (body like 'flu') or (body like 'flu.')) as temp1 where temp1.uid = u.uid group by location";
	$result = mysqli_query($conn, $sql);
	$i=mysqli_num_rows($result);
	if($i)
	while($i--)
	{
		$temp = mysqli_fetch_assoc($result);
		echo "<i>".$temp["location"]."</i> - ".$temp["count(body)"]."<br><br>";
	}
	else
		echo "No Posts regarding FLU";
	?>
	</td>
  </tr>
  <tr>
    <td>
	<p><b>Query 4: Enter username to find the posts by user</b></p>
	<br>
	<form action="Query4.php"  method="post">
	<input type="text" name="Loginname" placeholder="username">
	<input type="submit" value="Query4">
	</form>
	</td>
    <td>
	<p><b>Query 6-10: Login for further Queries</b></p><br>
	<form action="login.php" method="post">
		<br>
		<input type="text" name="Loginname" placeholder="username">
		<br>
		<br>
		<input type="text" name="Password" placeholder="password">
		<br><br>
		<input type="submit" name="Login" value="Login">
	</form>
	</td> 
    <td>
	<p><b>Query 5: Enter a year to find the person who made most no.of posts that year</b></p><br>
	<form action="Query5.php"  method="post">
	<input type="text" name="year" placeholder="year">
	<input type="submit" value="Query5">
	</form>
	</td>
  </tr>
</table>
</body>
</html>
