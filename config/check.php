<?php

    if(!isset($_SESSION)){ 
        session_start(); 
    }

    require_once "datos_conexion.php";
    require_once "GestorSQL_PDO.php";
    
    $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
    if(isset($_SESSION["error"])){
        $error = $_SESSION["error"];
        echo "<h1 style=\"position: fixed; top: 0; width: 100%; text-align: center; color: red; background-color: black; padding: 0.5vw; font-size: 2vw\" id=\"mensaje_error\">" . $error . "</h1>";
        unset($_SESSION["error"]);
    }else if(isset($_SESSION["mensaje"])){
        $mensaje = $_SESSION["mensaje"];
        echo "<h1 style=\"position: fixed; top: 0; width: 100%; text-align: center; color: red; background-color: black; padding: 0.5vw; font-size: 2vw\" id=\"mensaje_error\">" . $mensaje . "</h1>";
        unset($_SESSION["mensaje"]);
    }
    
    if(isset($_POST["submit"])){
        switch ($_POST["submit"]){
            case "Loguéate!":
                logeo();
                break;
            case "Regístrate!":
                registro();
                break;
        }
    }
    
    function registro(){
        global $BBDD;
        if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["birthdate"])){
            $name = $_POST["name"]; 
            $pass = $_POST["password"];
            $email = $_POST["email"];
            $birthdate = $_POST["birthdate"];
            $gender = $_POST["gender"];
            $image = $_POST["image"];
            $resultado = $BBDD->selectAll("usuarios", "","name LIKE '$name'");
            if ($resultado != false) {
                $_SESSION["error"] = "ERROR: El usuario ya se encuentra registrado, ¿me la quieres jugar?";
                header('Location:register');
            }else {
                unset($_SESSION["error"]);
                $_SESSION["user"] = $name;
                if($gender == "null"){
                    $gender = "Sin especificar";
                }
                $image = checkImagen($image);
                $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
                $resultado = $BBDD->Insert("usuarios", "",array("$name", "$pass_hash", "$email", "$gender", "$birthdate", "$image"));
                if($resultado != false){
                    $_SESSION["mensaje"] = "Usuario $name correctamente registrado.";
                    header('Location:login');
                }
            }
        }
    }
       
    
    function logeo(){
        global $BBDD;
        if (isset($_POST["name"]) && isset($_POST["password"])){
            $pass_verify = [];
            $name = $_POST["name"]; 
            $pass = $_POST["password"];
            $resultado = $BBDD->selectAll("usuarios", "","name LIKE '$name'");
            $pass_BBDD = $BBDD->selectBy("usuarios", array("password"), "" ,"WHERE name LIKE '$name'");
            if($pass_BBDD != false){
                foreach($pass_BBDD as $fila){
                    array_push($pass_verify, $fila[0]);
                }
                $check_password = password_verify($pass, $pass_verify[0]);
            }
            if ($resultado == false) {
                $_SESSION["error"] = "ERROR: El usuario no se encuentra registrado. Regístrate o te reviento.";
                header('Location:register');
            }else if($check_password == false){
                $_SESSION["error"] = "ERROR: Has introducido mal la contraseña parguela.";
                header('Location:login');
            }else {
                $img = [];
                $resultado = $BBDD->selectBy("usuarios", array("image"), "", "WHERE name LIKE '$name'");
                foreach($resultado as $fila){
                    array_push($img, $fila[0]);
                }
                $_SESSION["user"] = $name;
                checkImagen($img[0]);
                header('Location:app');
            }
        }
    }
    
    function checkImagen($img){
        switch ($img){
            case "":
                $_SESSION["img"] = "css\img\basic.png";
                return "Sin especificar";
                break;
            default:
                if (url_exists($img)){
                    $_SESSION["img"] = $img;
                    return $img;
                }else{
                    $_SESSION["img"] = "css\img\basic.png";
                    return "Sin especificar";
                }
                break;
        }
    }
    
    function url_exists($url) {
        $headers = @get_headers($url);
        if(strpos($headers[0], '200 OK')){
            return true;
        }else {
            return false;
        }
    }
  
?>