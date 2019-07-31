You need XAMPP for this. install it. copy this folder into C:\XAMPP\htdocs\SMA folder. start Apache and MySQL. type localhost/SMA in your browser.

My project's homepage is index.php from there one can go to query4.php, query5.php and login.php. For query1 to query5 one don't need to login. Once login, one can get access to query6 to query10.

The files present in the project 
connect.php		-	manages database connection to the program
index.php		-	homepage also executes query 1 to query3 and contains login
Query4.php		-	executes Query4 
Query5.php		-	executes Query5
login.php		- 	page after login also contains query6 to quer10
Post.php		-	Inserts post into database
comment.php		-	Inserts comment to post in database
deletcom.php	-	deletes particular comment
follow.php		- 	used to follow or unfollow any user
deletepost.php	-	deletes particular post created by a logged in user
logout.php		-	deletes all session variables and logsout current user
readme.txt		- 	explains about structure of project and extra features

extra features:
added deleting post feature
logged in user can delete all comment that are under his/her posts.
Query9 and query10 sort of executes in same place
neatly organized query execution