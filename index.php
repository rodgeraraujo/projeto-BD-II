<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

session_start();

require 'includes/config.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,name, course, institution, password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome...</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
	<style>
		body{
			width: 100%;
			height:auto;
			top: 0px;
			left: 0px;
			z-index: -1;
			position: absolute; 
			background-image: url("assets/images/bg1.jpg");
			background-color: #cccccc;
			background-repeat: no-repeat;
  			background-size: 100%;
		}
		#map {
			height: 85%;
			margin-left: 50px;
			border: 1px solid #ddd;
		}
		
		.map {
			position: absolute;
			width: 700px;
			height: 100px;
		}

		.criareventos{
			position: relative;
			margin-left: 1800px;
		}
		
		input[type="submit"] {
			background-color: #0095C7;
			border: none;
			border-radius: 3px;
			color: #f4f4f4;
			cursor: pointer;
			font-family: inherit;
			height: 50px;
			text-transform: uppercase;
			width: 300px;
			-webkit-appearance:none;
		}
	</style>	
</head>
<body>
	<?php
		include 'includes/header.php';
		
		if( !empty($user) ): ?>

		<header id="header" class="header1">
			<ul style="position: fixed; top: 0; right: 0; z-index: 10; padding: 0.75rem;">
			<li><a href="logout.php" class="small button">Logout?</a></li>
			</ul>
	 	 </header>
	  

		<p>Welcome <b><?= $user['name']; ?></b>!</p>
		<p><b>Course: </b><?= $user['course']; ?></p>
		<p><b>Institution: </b><?= $user['institution']; ?></p>
		<p><b>Email: </b><?= $user['email']; ?></p>

	<?php else: ?>
		<div id="login">

		<h1><strong>Welcome.</strong> Please login.</h1>
		<form action="login.php" method="POST">
					<p><input type="text" placeholder="E-mail" name="email" required></p>
					<p><input type="password" placeholder="Password" name="password" required></p>
					<p class="register">Don't have a account? <a href="register.php">Register here.</a></p>
					<p><input type="submit" value="Login"></p>
		</form>

	<?php endif; ?>

</body>
</html>