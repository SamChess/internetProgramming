<!DOCTYPE html>
<?php 
	include_once 'DBConnector.php';
	include_once 'user.php';

	$con = new DBConnector;
	// print_r($con);

	if (isset($_POST['btn_save'])){
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$city = $_POST['city_name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		// print_r($con);

		$user = new User($first_name, $last_name, $city, $username, $password);

		if (!$user->validateForm()) {
			$user->createFormErrorSessions("All fields are required");
			header("Refresh:0");
			die();
		}

		$res = $user->save();

		if ($res) {
			echo "Save operation was successful";
		} else {
			$user->createFormErrorSessions("Username is already taken,please use a different Username");			
			header("Refresh:0");
			die();
		}
	}
 ?>
<html>
<head>
	<title>Title goes here</title>
	<script type="text/javascript" src="validate.js"></script>
	<link rel="stylesheet" type="text/css" href="css/validate.css">
</head>
<body>
	<div class="userform">
		<form name="user_details" id="user_details" onsubmit="return validateForm()" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
			<table align="center">
				<tr>
					<td>
						<div id="form-errors">
							<?php 
								session_start();
								if (!empty($_SESSION['form_errors'])) {
									echo " ".$_SESSION['form_errors'];
									unset($_SESSION['form_errors']);
								}
							 ?>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="text" name="first_name" required placeholder="First Name"> </td>
				</tr>
				<tr>
					<td><input type="text" name="last_name" placeholder="Last Name"></td>
				</tr>
				<tr>
					<td><input type="text" name="city_name" placeholder="City"></td>
				</tr>
				<tr>
					<td><input type="text" name="username" placeholder="Username"></td>
				</tr>
				<tr>
					<td><input type="password" name="password" placeholder="Password"></td>
				</tr>
				<tr>
					<td><button type="submit" name="btn_save"><strong>SAVE</strong></button></td>
				</tr>
				<tr>
					<td><a href="login.php">Login</a></td>
				</tr>
		</table>
		</form>
	</div>
	
<div class="usersdisplay">
	<?php 

	if (isset($_POST['btn_save'])){
		$result = $user->readAll();
		echo "<table align='center'>";
		echo "<thead>Display Database data</thead>";

		while($row = mysqli_fetch_assoc($result)){
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['first_name']."</td>";
			echo "<td>".$row['last_name']."</td>";
			echo "<td>".$row['user_city']."</td>";
			echo "<td>".$row['username']."</td>";
			echo "<td>".$row['password']."</td>";
			echo "</tr>";
    		// echo "<br>";
		}

		echo "</table>";
	}
		$con->closeDatabase();
 	?>
</div>		
</body>
</html>