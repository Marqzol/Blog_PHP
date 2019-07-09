<?php

    if(isset($_SESSION["error"])){
        $error = $_SESSION["error"];
        echo "<h1 style=\"position: fixed; top: 0; width: 100%; text-align: center; color: red; background-color: black; padding: 0.5vw; font-size: 2vw\" id=\"mensaje_error\">" . $error . "</h1>";
        unset($_SESSION["error"]);
    }

    if ($_SESSION["user"] == null){
        header('Location:login.php');
    }

    require_once "datos_conexion.php";
    require_once "GestorSQL_PDO.php";
    
    $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
    
    $user = $_SESSION["user"];
    $datos_user_array = $BBDD->selectBy("usuarios", array("name, email, gender, birthdate, image") ,"", "WHERE name LIKE '$user'")->fetchAll(\PDO::FETCH_ASSOC);
    $datos_user_string = implode(",", $datos_user_array[0]);
    echo "<input type='text' hidden='hidden' name='$datos_user_string' id='datosUser'>";
    
    if(isset($_POST["submit"]) && $_POST["submit"] == "Guardar cambios"){
        if(isset($_POST["old_password"])){
            comprobarCambios($user);
        }
    }
    

    function comprobarNick($nick){
        global $BBDD;
        $resultado = $BBDD->selectBy("usuarios", array("name") ,"", "WHERE name LIKE '$nick'");
        if($resultado != false){
            return true;
        }else{
            return false;
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
    
    function checkExtension($img){
        $extension = substr($img, strlen($img) - 3);
        if($extension == "jpg" || $extension == "png" || $extension == "svg" || $extension == "gif"){
            return true;
        }else{
            return false;
        }
        
    }
    
    function comprobarImagen($img){
        checkExtension($img);
        if (url_exists($img) && checkExtension($img)){
            $_SESSION["img"] = $img;
            return $img;
        }else{
            $_SESSION["img"] = "css\img\basic.png";
            return "Sin especificar";
        }
    }
    
    function comprobarPassword($password){
        global $BBDD, $user;
        $pass_verify = [];
        $pass_BBDD = $BBDD->selectBy("usuarios", array("password"), "" ,"WHERE name LIKE '$user'");
        if($pass_BBDD != false){
            foreach($pass_BBDD as $fila){
                array_push($pass_verify, $fila[0]);
            }
            $check_password = password_verify($password, $pass_verify[0]);
            if($check_password == false){
                $_SESSION["error"] = "ERROR: Has introducido mal la contraseña parguela.";
                header('Location:modify_profile.php');
            }else{
                return true;
            }
        }
    }
    
    function comprobarCambios($user){
        global $BBDD;
        $name = $_POST["name"]; 
        $pass = $_POST["new_password"];
        $email = $_POST["email"];
        $birthdate = $_POST["birthdate"];
        $gender = $_POST["gender"];
        $image = comprobarImagen($_POST["image"]);
        $password_old = $_POST["old_password"];
        
        checkEmptyText($name, $email, $birthdate, $gender);
        
        if(comprobarPassword($password_old)){
            switch ($name){
                case $name == $user:
                    $resultado = $BBDD->Update("usuarios", "email = '$email',birthdate = '$birthdate',gender = '$gender', image = '$image'", 
                    "name LIKE '$user'");
                    break;
                case $name != $user:
                    if(!comprobarNick($name)){
                        $resultado = $BBDD->Update("usuarios", "name = '$name',email = '$email',birthdate = '$birthdate',gender = '$gender', image = '$image'", 
                        "name LIKE '$user'");
                    }else{
                        $_SESSION["error"] = "ERROR: El nick de usuario $name ya se encuentra registrado. Búscate otro, pringadus.";
                        header('Location:modify_profile.php');
                    }
                    break;
            }
            header('Location:app.php');
            
        }
    }
    
    function checkEmptyText(&$name, &$email, &$birthdate, &$gender){
        global $datos_user_string;
        $keys = array_keys($_POST);
        $datos_user = explode(',',$datos_user_string);
        foreach ($keys as $valor) {
            if (!empty($_POST[$valor])) {
            } else {
                switch($valor){
                    case "name":
                        $name = $datos_user[0];
                        break;
                    case "email":
                        $email = $datos_user[1];
                        break;
                    case "gender":
                        $gender = $datos_user[2];
                        break;
                    case "birthdate":
                        $birthdate = $datos_user[3];
                        break;
                }
            }
        } 
    }


?>
