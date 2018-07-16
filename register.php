<?php
include 'includes/error_report.php';

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: index.php");
}

require 'includes/config.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$sql = "INSERT INTO users (name, email, course, institution, password) 
			VALUES (:name, :email, :course, :institution, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':course', $_POST['course_name']);
	$stmt->bindParam(':institution', $_POST['institution_name']);
	$stmt->bindValue(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">

	
</head>
<body>

	<?php
		include 'includes/header.php';

		if(!empty($message)): ?>
			<p><?= $message ?></p>
	<?php endif; ?>

	<br>
	<h1><strong>Sign Up.</strong> It's free.</h1>
	<div id="c2">
		<form action="register.php" method="POST">
					<p><input type="text" placeholder="Name" name="name" required></p>
					<p><input type="text" placeholder="E-mail" name="email" required></p>
					<p><input type="text" placeholder="Course" name="course_name" required></p>
					<p><input type="text" placeholder="Institution" name="institution_name" required></p>
					<p><input type="password" placeholder="Password" name="password" required></p>
					<p><input type="password" placeholder="Confirm password" name="confirm_password" required></p>
					<p class="register">Have a account? <a href="login.php">Login here.</a></p>
					<p><input type="submit" value="Login"></p>
		</form>
	</div>
</body>
</html>