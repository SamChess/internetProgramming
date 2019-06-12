<!DOCTYPE html>
<?php 

	include_once 'DBConnector.php';
	include_once 'user.php';

	$con = new DBConnector;

	if (isset($_POST['btn-login'])){
		print("arg");

		$username = $_POST['username'];
		$password = $_POST['password'];

		// $instance = User::create();
		$instance = new User('','','',$username,$password,'','');
		 $instance->setPassword($password);
		$instance->setUsername($username);

		if ($instance->isPasswordCorrect()){
			
		$instance->createUserSession();
		$instance->login();
		$con->closeDatabase();
		
		} else {
			$con->closeDatabase();
			header("Location:login.php");
		}
	}
 ?>
 <html>
 <head>
 	<title>Log In</title>
 	<script type="text/javascript" src="js/validate.js"></script>
 	<link rel="stylesheet" type="text/css" href="css/validate.css">
 </head>
 <body>
 	<form method="post" name="login" id="login" action="<?=$_SERVER['PHP_SELF']?>">
 		<tr>
 			<td><input type="text" name="username" placeholder="Username" required></td>
 		</tr>
 		 <tr>
 			<td><input type="password" name="password" placeholder="Password" required></td>
 		</tr>
 		<tr>
 			<td><button type="submit" name="btn-login"><strong>LOGIN</strong></button></td>
 		</tr>
 	</form>
 </body>
 </html>