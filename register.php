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

	<?php
		include 'includes/header_notlogged.php';

		if(!empty($message)): ?>
			<p><div style="color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6; padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;text-align: center;"><?= $message?></div></p>
	<?php endif; ?>

    <div class="grid">
        <form action="register.php" method="post" class="form login">
            <header class="register__header">
                <h3 class="register__title">Register</h3>
            </header>
            <div class="register__body">
                <div class="form__field">
                    <input type="text" placeholder="Name" name="name" required>
                </div>
                <div class="form__field">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="form__field">
                    <input type="text" placeholder="Course" name="course_name" required>
                </div>
                <div class="form__field">
                    <input type="text" placeholder="Institution" name="institution_name" required>
                </div>
                <div class="form__field">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="form__field">
                    <input type="password" placeholder="Confirm password" name="confirm_password" required>
                </div>
            </div>
            <footer class="register__footer">
                <input type="submit" value="Register">
                <p>Have a account? <a href="login.php">Login now.</a></p>
            </footer>
        </form>

    </div>
</body>
</html>