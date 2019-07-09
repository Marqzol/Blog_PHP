<!DOCTYPE html>
<?php

    require("config/check.php");
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Logeo</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container-fluid access">
            <form method="post" action="">
                <h1 class="access-title">¿Quién eres?</h1>
                <input type="text" name="name" class="access-input" placeholder="Usuario" autofocus required>
                <input type="password" name="password" class="access-input" placeholder="Contraseña" required>
                <input type="submit" name="submit" value="Loguéate!" class="access-login-button btn-responsive">
                <h3 class="division">¿No tienes cuenta?</h3>
            </form>
            <button class="access-register-button btn-responsive" onclick="goSite('register')">Regístrate!</button>
        </div>
    </body>
</html>