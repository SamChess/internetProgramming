 <!DOCTYPE html>
<?php 
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
 ?>
 <html>
 <head>
 	<title>Private Page</title>
 	<script type="text/javascript" src="js/validate.js"></script>
 	<link rel="stylesheet" type="text/css" href="css/validate.css">
 </head>
 <body>
 	<p>This is a private page</p>
 	<p>We want to protect it</p>
 	<p><a href="logout.php">Logout</a></p>
 </body>
 </html>