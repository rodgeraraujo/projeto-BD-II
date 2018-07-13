<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: index.php");
}

require 'includes/config.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: index.php");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<?php
		include 'includes/header.php';

		if(!empty($message)): ?>
			<p><?= $message ?></p>
	<?php endif; ?>

		<h1><strong>Login.</strong></h1>
		<form action="login.php" method="POST">
				<!-- <fieldset> -->
					<p><input type="text" placeholder="E-mail" name="email" required></p>
					<p><input type="password" placeholder="Password" name="password" required></p>
					<p class="register">Don't have a account? <a href="register.php">Register here.</a></p>
					<p><input type="submit" value="Login"></p>
				<!-- </fieldset> -->
		</form>
	<!-- <form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="and password" name="password">

		<input type="submit">

	</form> -->

</body>
</html>