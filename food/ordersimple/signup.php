<?php
	session_start();

$servername="localhost";
$serverusername="root";
$password="";
$database_name="canteen_login";
$message="";

	
	try{
		$conn= new PDO("mysql:host=$servername; dbname=$database_name", $serverusername);

		$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if (isset($_POST['signup_button'])) {
			$name= test_input($_POST['name']);
			$email_id= test_input($_POST['email_id']);
			$designation= test_input($_POST['designation']);
			$username= test_input($_POST['username']);
			$password= test_input($_POST['password']);
			$password1= test_input($_POST['password1']);
			$stmt= $conn->query("SELECT * FROM `users` WHERE `username`='$username';");
			$stmt->execute();

			if (empty($name)) {
				$message="Name Cannot be Empty";
			}
			elseif (empty($username)) {
				$message="username cannot be Empty";
			}
			elseif (empty($password)) {
				$message="password Cannot be Empty";
			}
			elseif ($password!=$password1) {
				$message="The two passwords do not match";
			}
			elseif (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email_id))
			{
				$message="Invalid_Email";
			}
			elseif ($stmt->rowCount()!=0) {
				$message="Username already exists";
			}
			else
			{
				$sql=$conn->query("INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `designation`, `email_id`) VALUES ('NULL', '$name', '$username', '$password', '$designation', '$email_id');");
					header("location:signup.php");
				if ($designation=="Student_Convener") {
						session_start();
						$_SESSION["username"]=$username;
						$_SESSION["designation"]=$designation;
						header("location:home.php");
					}
					else if($designation=="Faculty_Convener"){
						session_start();
						$_SESSION["username"]=$username;
						$_SESSION["designation"]=$designation;
						header("location:home.php");
					}
					else if($designation=="Reviewer(P)" || $designation=="Reviewer(O)" ){
						session_start();
						$_SESSION["username"]=$username;
						$_SESSION["designation"]=$designation;
						header("location:home.php");
					}
					else{
						session_start();
						$_SESSION["username"]=$username;
						$_SESSION["designation"]=$designation;
						header("location:home.php");
					}
			}
		}
			


	}
	catch(PDOException $e){
		echo "Error: ".$e->getMessage() ;
	}

	function test_input($data){
		$date= trim($data);
		$data=stripcslashes($data);
		$data= htmlentities($data);
		return $data;
	}



?>




<!DOCTYPE html>
<html>
<head>
	<title> Signup @Canteen2.0 </title>
</head>
<body align = center background="title1.jpg">
<body align ="center">
	<div class="header">
		<h1>login to Canteen2.0</h1>
	</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">

		<?php echo $message; ?>

		<table align="center">
			<tr>
				<td> Name:</td>
				<td><input type="text" name="name" class="textInput"></td>
			</tr>
			<tr>
				<td> Email-ID:</td>
				<td><input type="text" name="email_id" class="textInput"></td>
			</tr>
			<tr>
				<td> Designation:</td>
				<td>
					<select name="designation">
						<option value="Faculty_Convener">Faculty </option>
						<option value="Student_Convener">Student </option>	
						<option value="Reviewer(P)">Canteen </option>
						<option value="Reviewer(O)">Worker </option>	
						<option value="Participant">Others </option>			
					</select>
				</td>
			</tr>
			<tr>
				<td> Username:</td>
				<td><input type="text" name="username" class="textInput"></td>
			</tr>
			<tr>
				<td> Password:</td>
				<td><input type="password" name="password" class="textInput"></td>
			</tr>
			<tr>
				<td> Password Again :</td>
				<td><input type="password" name="password1" class="textInput"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="signup_button" value="signup"></td>
			</tr>

		</table>
	</form>


</body>
</html>