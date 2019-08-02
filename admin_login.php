<?php 
	ob_start();
	session_start(); // starting session as we'll be using vars between mult pages
	$_SESSION["logged_in"] = 0;
	$_SESSION["logged_in_admin"] = 0;
	
	// define connection variables
	$settings = parse_ini_file('settings.ini.php');
	include("utils.php");

	// /***
	// Create connection
	$conn = new mysqli(
		$settings['db_host'], 
		$settings['db_user'], 
		$settings['db_pass'], 
		$settings['db_name']);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	// ***/

	// define form variables and set to empty values
	$telnum = $pswd = $type = "";

	// cheking for sent method
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$telnum = sanitise($_POST["telnum"]);    // hashing input using below function
		$pswd = sanitise($_POST["pswd"]);

		if(isset($_POST['login_user']))     // not empty
		{
			$checkQuery = "SELECT * from users WHERE telnum='$telnum' AND pswd='$pswd' AND admin='admin'"; //AND confirmed='confirmed'
			$results = mysqli_query($conn, $checkQuery);
			if (mysqli_num_rows($results) == 1)
			{
				echo "login successful";
				$_SESSION["logged_in_admin"] = 1; // admin
				$_SESSION["logged_in"] = 1; // user
				$_SESSION["phone_num"] = $telnum;
				header('Location: admin_dashboard.php');
			}else
			{
				echo "login unsuccessful";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<base href="index.php">
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-light navbar-light">
	  <ul class="navbar-nav">
		<li class="nav-item active">
		  <a class="nav-link" href="index.php">Home</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="#">Link</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="#">Link</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link disabled" href="#">Disabled</a>
		</li>
	  </ul>
	</nav>
	<br>
	<br>
	<br>
	<div class="container">
		<div class="card">
		  <div class="card-header">
			  ADMIN LOGIN
		  </div>
		  <div class="card-body">
			<form 
				method="post"
				action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			  <div class="form-group">
				<label for="phone">Phone</label>
				<input type="phone" name="telnum" class="form-control" type="number"  required>
			  </div>
			  <div class="form-group">
				<label for="pwd">Password:</label>
				<input type="password" name="pswd" class="form-control" id="pwd" required>
			  </div>
			  <button type="submit" class="btn btn-primary" name="login_user">LOGIN</button>
			</form>
		  </div>
		</div>

	</div>

</body>
</html>