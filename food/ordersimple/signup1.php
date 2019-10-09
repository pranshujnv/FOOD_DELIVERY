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

			$stmt= $conn->query("SELECT * FROM users WHERE `username`='$username';");
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
				 $sql="INSERT INTO users (user_id, name, username, password, designation, email_id) VALUES ('NULL', '$name', '$username', '$password', '$designation', '$email_id')";
				$result=$conn->query($sql);
				
				   if($result == TRUE) 
				   {
				   }
				   else
				   {
					   echo "ERROR" .$sql."<br>".$conn->error;
				   }	   
	
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
	<title> Signup @core2canteen </title>
</head>
<body align = center background="title1.jpg">
<style type="text/css">
	.button{
		font-size: 16px;
		padding: 2px 4px;
	}
</style>
<body align ="center" bgcolor="#DBE8F1">
	<div class="header" style="background-color:#DBE8F1">
		<br><h1>Register for Core2Canteen</h1><br>
	</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">

		<?php echo $message; ?>

		<table align="center">
			<tr>
				<th> Name:</th>
				<th><input type="text" name="name" class="textInput"></th>
			</tr><br><br><br><br><br>
			<tr>
				<th> Email-ID:</th>
				<th><input type="text" name="email_id" class="textInput"></th>
			</tr>
			<tr>
				<th> Designation:</th>
				<th>
					<select name="designation">
						<option value="Faculty_Convener"> Faculty </option>
						<option value="Student_Convener">Student </option>	
						<option value="Reviewer(P)">Canteen </option>
						<option value="Reviewer(O)">Workers </option>	
						<option value="Participant">Others </option>			
					</select>
				</th>
			</tr>
			<tr>
				<th> Username:</th>
				<th><input type="text" name="username" class="textInput"></th>
			</tr>
			<tr>
				<th> Password:</th>
				<th><input type="password" name="password" class="textInput"></th>
			</tr>
			<tr>
				<th> Reenter Password:</th>
				<th><input type="password" name="password1" class="textInput"></th>
			</tr>
			<tr>
				<th></th>
				<th><input class="button" type="submit" name="signup_button" value="SIGN UP"></th>
			</tr>

		</table>
	</form>


</body>
</html>