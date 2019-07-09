<?php

    require_once "datos_conexion.php";
    require_once "GestorSQL_PDO.php";
    require_once "resources.php";

    $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
    $user = $_SESSION["user"];
    
    if(isset($_POST["submit"])){
        switch ($_POST["submit"]){
            case "Enviar":
                enviarPublicacion();
                break;
            case "Regístrate!":
                registro();
                break;
        }
    }
    
    function enviarPublicacion(){
        global $BBDD, $user;
        if (checkEmptyText($_POST["text_area"])){
            $text = $_POST["text_area"];
            $resultado = $BBDD->selectBy("usuarios", array("id"), "", "WHERE name LIKE '$user'");
            $id_usuario = getResult($resultado, 1);
            $BBDD->Insert("publicaciones", "id_usuario, text", array("$id_usuario", "$text"));
        }
    }

    function checkEmptyText($text){
        if(isset($text) && strlen(preg_replace("/\s+/u", "", $text)) != 0){
            return true;
        }else{
            return false;
        }
    }

?>

