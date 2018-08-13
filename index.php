
	<?php
    include 'includes/header_session.php';

    if( !empty($user) ): ?>
        <?php
        $title = "Add a event marker on map";
        $messageMap = '<b><p style="text-align: justify;">Clique no mapa para colocar um marcador, </p><p style="text-align: justify;">clique com o botão direito para remover.</p></b>';

        include 'includes/header_logged.php';

        include 'locations_model.php';

        include 'map_view.php';

    ?>

	<?php else: ?>
        <?php include 'includes/header_notlogged.php';  ?>

        <div class="container">
            <div class="grid">
                <form action="login.php" method="post" class="form login">
                    <header class="login__header">
                        <h3 class="login__title">Welcome, login now!</h3>
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
                        <p>Don't have a account?<br><a href="register.php">Register here.</a></p>
                    </footer>
                </form>
            </div>
            <div class="zoominbox"></div>
        </div>
	<?php endif; ?>

</body>
</html>