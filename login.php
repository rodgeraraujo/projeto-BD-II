<?php
    include 'includes/header_session.php';

    if(!isset($_SESSION)){
        session_start();
    }

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

	<?php
        include 'includes/header_notlogged.php';

		if(!empty($message)): ?>
			<p><?= $message ?></p>
	<?php endif; ?>
    <div class="grid">

        <form action="login.php" method="post" class="form login">
            <header class="login__header">
                <h3 class="login__title">Login</h3>
            </header>
            <div class="login__body">
                <div class="form__field">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="form__field">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
            </div>
            <footer class="login__footer">
                <input type="submit" value="Login">
                <p>Don't have a account? <a href="register.php">Register here.</a></p>
            </footer>
        </form>
    </div>
</body>
</html>