<?php
session_start();
require 'connect.php';
if(isset($_SESSION["user"])&&!isset($_POST["Login"]))
{
	echo "<center><h2>Welcome ".$_SESSION["user"]."</h2></center>";
	?>
	<html>
	<head>
	<style>
	td {
		vertical-align: top;
		padding: 15px;
		width: 10%;
	}
	div
	{
		height: 695px;
	}
	</style>
	</head>
	<body> 
	<a href='logout.php'><input type=button value=logout name =logout style="float: right;width:90px;height:40px;"></a>
	<br><br><br>
	<table border=5 style="width:100%">
	<tr>
		<td style="height:10%">
		<p><b>Query 7: Post a new twit</b></p><br>
		<form action="post.php" method="post">
		<input type="text" name="body" placeholder="Enter Something">
		<input type="submit" name="Post" value="Post">
		</form>
		</td>
		<td rowspan="2">
		<div style="overflow: auto;">
		<p><b>Query 9,10: Add/Delete a Comment to post</b></p><br>
		<?php
		$sql = "SELECT uid, tid, body,post_time from twitts order by post_time DESC";
		$result = mysqli_query($conn, $sql);
		$i = mysqli_num_rows($result);
		while($i--)
		{
			$del=0;
			$temp=mysqli_fetch_assoc($result);
			$uid = $temp['uid'];
			$tid = $temp['tid'];
			if($uid == $_SESSION["uid"])
				$del=1;
			$sql_temp = "select username from user where uid=".$uid;
			$result_temp=mysqli_query($conn,$sql_temp);
			echo "<b>".mysqli_fetch_assoc($result_temp)["username"]."</b> - ";
			echo $temp["body"];
			if($uid == $_SESSION["uid"])
				echo "&nbsp&nbsp&nbsp<a href='deletepost.php?id=$tid'><input type=button value=post_delete></a>";
			$tid = $temp['tid'];
			$sql1 = "select cid, uid, body from comment where tid=".$tid;
			$result1 = mysqli_query($conn, $sql1);
			$i1 = mysqli_num_rows($result1);
			while($i1--)
			{
				$temp1=mysqli_fetch_assoc($result1);
				$uid = $temp1["uid"];
				$sql_temp = "select username from user where uid=".$uid;
				$result_temp=mysqli_query($conn,$sql_temp);
				echo "<br><br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <b>".mysqli_fetch_assoc($result_temp)["username"]."</b> - ".$temp1["body"];
				$cid = $temp1["cid"];
				if($uid == $_SESSION["uid"] || $del==1)
					echo "&nbsp&nbsp&nbsp<a href='deletecom.php?id=$cid'><input type=button value=delete></a>";
			}
			?>
			<br><br><br>
			<form action="comment.php?id=<?php echo $tid; ?>"  method="post">
			 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
			<input type=text name=combody>
			&nbsp &nbsp
			<input type=submit name=comment value=comment>
			</form>
			<?php
			echo "<br>";
		}
		?>
		</div>
		</td>
		<td rowspan = "2">
		<div style="overflow: auto;">
		<p><b>Query 8: Follow/Unfollow other users</b></p><br>
		<?php
		$sql1 = "SELECT DISTINCT username from user, (SELECT following_id from follow,user where follower_id=".$_SESSION["uid"].") as temp1 where user.uid=temp1.following_id";
		$result1 = mysqli_query($conn, $sql1);
		$i1 = mysqli_num_rows($result1);
		$arr1_length=$i1;
		$arr1=array();
		while($i1--)
		{
			$temp1=mysqli_fetch_assoc($result1);
			$arr1[]=$temp1['username'];
		}
		$sql2 = "SELECT uid, username FROM user";
		$result2 = mysqli_query($conn, $sql2);
		$i2 = mysqli_num_rows($result2);
		while($i2--)
		{
			$temp=mysqli_fetch_assoc($result2);
			$temp2=$temp["username"];
			$tempid=$temp["uid"];		
			if($temp2!=$_SESSION["user"])
			{
				if(in_array($temp2,$arr1))
				{
					echo "<b>".$temp2."</b>";
					echo "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='follow.php?id=$tempid&do=unfollow'><input type=button value=unfollow ></a><br><br>";
				}
				else
				{
					echo "<b>".$temp2."</b>";
					echo "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='follow.php?id=$tempid&do=follow'><input type=button value=follow ></a><br><br>";
				}
			}
		}
		?>
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<div style="overflow: auto;">
		<p><b>Query 6: Senders of messages</b></p><br>
		<?php
		$sql = "select distinct username,body from user,(SELECT sender_id, body from message,user where message.receiver_id = ".$_SESSION["uid"].") as temp1 where temp1.sender_id=user.uid";
		//echo $sql."<br>";
		$result = mysqli_query($conn, $sql);
		$i = mysqli_num_rows($result);
		if($i>0)
		{
			echo "messages to ".$_SESSION["user"]." - <br><br>";
			while($i--)
			{
				$row = mysqli_fetch_assoc($result);
				echo "<b>".$row["username"]."</b> - ".$row["body"]."<br><br>";
			}
		}
		else
			echo "No messages to ".$_SESSION["user"];
		?>
		</div>
		</td>
	</tr>
	</table>
	</body>
	</html>
	<?php
}
else
{
	if(!empty($_POST["Loginname"]) || !empty($_POST["Password"]))
	{
	$sql = "SELECT * from user where username=\"".$_POST["Loginname"]." \"and password = \"".$_POST["Password"]."\"";
	//select * user where username=sdfz OR 1=1--
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) == 1)
	{
		$_SESSION["user"] = $_POST["Loginname"];
		$_SESSION["uid"] =  mysqli_fetch_assoc($result)["uid"];
		echo "<script>location.href='login.php'</script>";
	}
	else
	{
		unset($_SESSION['user']);
		unset($_SESSION['uid']);
		echo "<script>alert('username and password do not match')</script>";
		echo "<script>location.href='index.php'</script>";
		
	}
	}
	else
	{
		unset($_SESSION['user']);
		unset($_SESSION['uid']);
		echo "<script>location.href='index.php'</script>";
	}
}
?>