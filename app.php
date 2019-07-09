<!DOCTYPE html>
<?php
    session_start();
    
    require_once 'config/resources.php';
    require_once 'config/app_config.php';

    if ($_SESSION["user"] == null){
        header('Location:login.php');
    }
    if (!isset($_SESSION["page"])){
        $_SESSION["page"] = 1;
    }

?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Aplicación</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="emoji/css/emoji.css" rel="stylesheet">
        
        <!-- Mi hoja de estilos y Javascript personal -->
        <script src="js/script.js"></script>
        <script src="js/ajax.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <!--  -->
    </head>
    <body onload="cargarEmojis(), peticionCuantasPaginas('POST', 'config/showTotalPages.php', cargarPaginas), peticionPagina('POST', 'config/showThisPage.php', <?php echo $_SESSION["page"] ?>, cargarPosts)">
        <div class="card card_session">
            <img class="img_session card-img-top" src="<?php echo $_SESSION["img"] ?>" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"><?php echo $_SESSION["user"] ?></h5>
                <a href="#" class="btn btn-primary btn-block btn-responsive enlace" onclick="goSite('modify_profile')">Modificar perfil</a>
                <a href="#" class="btn btn-warning btn-block btn-responsive enlace" onclick="goSite('login')">Cerrar sesión</a>
            </div>
        </div>
        <div class="cuerpo container" id="cuerpo">
            <form class="text_area_form" method="post" onsubmit="return false">
                <textarea class="form-control text_area" name="text_area" id="text_area" rows="5" maxlength="1000" placeholder="¿En qué estás pensando?" data-emojiable="true"></textarea>
                <input type="submit" name="submit" value="Enviar" class="send-text-area submit_enviar" onclick="peticionPagina('POST', 'config/showThisPage.php', <?php echo $_SESSION["page"] ?>,cargarPosts), peticionCuantasPaginas('POST', 'config/showTotalPages.php', cargarPaginas)">
            </form>
            <div class="container" id="posts_container"></div>
        </div>
        <footer class="page-footer footer" id="footer"></footer>
    </body>
</html>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="emoji/js/config.js"></script>
<script src="emoji/js/util.js"></script>
<script src="emoji/js/jquery.emojiarea.js"></script>
<script src="emoji/js/emoji-picker.js"></script>
