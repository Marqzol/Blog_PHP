<!DOCTYPE html>
<?php

    require("config/check.php");

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
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
                <h1 class="access-title">Inserta tus datos de registro</h1>
                <input type="text" class="access-input" name="name" placeholder="Usuario" autofocus required minlength="3" maxlength="20">
                <input type="password" class="access-input" name="password" placeholder="Contraseña" required>
                <input type="email" class="access-input" name="email" placeholder="Email" required>
                <input type="date" class="access-input" name="birthdate" placeholder="Fecha de Nacimiento" required>
                <select class="access-input" name="gender">
                    <option value="null">Seleccione su sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Ewok">Ewok</option>
                    <option value="Ser de luz iridiscente">Ser de luz iridiscente</option>
                    <option value="Masculino">Sin especificar</option>
                </select>
                <input type="text" name="image" id="image" class="access-input" value="" placeholder="Ruta de la imagen">
                <input type="submit" name="submit" value="Regístrate!" class="access-register-button">
                <h3 class="division">¿Ya tienes cuenta?</h3>
            </form>
            <button class="access-login-button" onclick="goSite('login')">Loguéate!</button>
        </div>
    </body>
</html>