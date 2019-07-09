<!DOCTYPE html>
<?php
    session_start();

    if ($_SESSION["user"] == null){
        header('Location:login.php');
    }

    require("config/loadProfile.php");

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modifica tu perfil</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body onload="cargarDatosPerfil()">
        <form class="access" method="post" action="">
            <h1 class="access-title">Modifica tu perfil</h1>
            <input type="text" name="name" class="access-input" placeholder="Usuario" value="" id="name" autofocus>
            <input type="password" name="new_password" class="access-input" id="password" value="" placeholder="Nueva Contraseña">
            <input type="text" class="access-input" name="email" id="email" value="" placeholder="Email">
            <select class="access-input" id="gender" name="gender" value="">
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Ewok">Ewok</option>
                <option value="Ser de luz iridiscente">Ser de luz iridiscente</option>
                <option value="Sin especificar">Sin especificar</option>
            </select>
            <input type="date" class="access-input" id="birthdate" value="" name="birthdate" placeholder="Fecha de Nacimiento">
            <input type="text" name="image" id="image" class="access-input" value="" placeholder="Ruta de la imagen">
            <h3 class="division">Introduce tu contraseña para guardar los cambios</h3>
            <h5 class="division">(la vieja contraseña si la has modificado)</h5>
            <input type="password" class="access-input" name="old_password" placeholder="Contraseña" required>
            <input type="submit" name="submit" value="Guardar cambios" class="access-register-button">
            <button class="access-login-button" onclick="goSite('app')">Salir</button>
        </form>
    </body>
</html>



