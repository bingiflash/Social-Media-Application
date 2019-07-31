<?php
require 'connect.php';
$sql = "select username from user, (select count(tid) as no_of_posts, uid, year(post_time) from twitts where year(post_time) = ".$_POST["year"]." GROUP BY uid) as temp1 where user.uid = temp1.uid and no_of_posts = (select max(no_of_posts) from (select count(tid) as no_of_posts, uid, year(post_time) from twitts where year(post_time) = ".$_POST["year"]." GROUP BY uid) as temp1)";
$result = mysqli_query($conn, $sql);
$i = mysqli_num_rows($result);
if($i)
{
echo "<b>Highest no of Posts in  ".$_POST["year"]." is by</b> - <br><br>";
while($i--)
	echo mysqli_fetch_assoc($result)["username"]."<br><br>";
}
else
	echo "No posts in that year<br>";
echo "<a href='index.php'><input type=\"button\" value=\"back\" ></a>"
?>