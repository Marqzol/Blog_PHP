<?php
    
    $_SESSION["page"] = $_POST["page"];

    insertarPost();
    insertarComentario();
    mostrarEstaPagina();
    
    function mostrarEstaPagina(){
        header('application/json');
        require_once "datos_conexion.php";
        require_once "GestorSQL_PDO.php";
        $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
        $objeto = new stdClass(); // Creo el objeto vacío
        $objeto->Posts = []; // Creo e inicializo un atributo "Posts" que será un array
        $numLimit = paginado();
        $posts = $BBDD->selectBy("publicaciones", array("publicaciones.id", "text", "fecha", "name"), "INNER JOIN usuarios ON publicaciones.id_usuario = usuarios.id", "ORDER BY fecha DESC LIMIT $numLimit[0],$numLimit[1]");
        foreach ($posts as $col){
            $propiedades = new stdClass(); // Creo un objeto vacío para almacenar las propiedades
            $propiedades->Texto = $col["text"]; // Le añado la propiedad "Texto"
            $propiedades->Fecha = $col["fecha"]; // Le añado la propiedad "Fecha"
            $propiedades->Usuario = $col["name"]; // Le añado la propiedad "Usuario" con el nombre del usuario que publicó
            
            //-------------------------COMENTARIOS -----------------------------
            $id_comentario = $col["id"];
            $comentarios = $BBDD->selectBy("comentarios", array("text", "fecha", "name"), "INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id", "WHERE comentarios.id_publicacion = $id_comentario ORDER BY fecha DESC");
            $propiedades->Comentarios = [];
            if ($comentarios != false) {
                foreach ($comentarios as $col_comentarios) {
                    $propiedades_comentarios = new stdClass();
                    $propiedades_comentarios->Texto = $col_comentarios["text"];
                    $propiedades_comentarios->Fecha = $col_comentarios["fecha"];
                    $propiedades_comentarios->Usuario = $col_comentarios["name"];
                    array_push($propiedades->Comentarios, $propiedades_comentarios);
                }
            }
            
            array_push($objeto->Posts, $propiedades); // Pusheo a la propiedad "Posts" un array un objeto con las 
            //propiedades Texto y Fecha
        }
        echo json_encode($objeto);
        
    }
    
    function insertarPost(){
        if (isset($_POST["textArea"])) {
            if (checkEmptyText($_POST["textArea"])) {
                session_start();
                require_once 'resources.php';
                require_once "datos_conexion.php";
                require_once "GestorSQL_PDO.php";
                $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
                $text = $_POST["textArea"];
                $user = $_SESSION["user"];
                $resultado = $BBDD->selectBy("usuarios", array("id"), "", "WHERE name LIKE '$user'");
                $id_usuario = getResult($resultado, 1);
                $BBDD->Insert("publicaciones", "id_usuario, text", array("$id_usuario", "$text"));
            }
        }   
    }
    
    function insertarComentario(){
        if (isset($_POST["textComentario"]) && isset($_POST["autorPost"]) && isset($_POST["fechaPost"])) {
            if (checkEmptyText($_POST["textComentario"])) {
                session_start();
                require_once 'resources.php';
                require_once "datos_conexion.php";
                require_once "GestorSQL_PDO.php";
                $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
                $text = $_POST["textComentario"];
                $fecha = $_POST["fechaPost"];
                $autorPost = $_POST["autorPost"];
                $user = $_SESSION["user"];
                $resultado = $BBDD->selectBy("usuarios", array("usuarios.id"), "", "WHERE name LIKE '$user'");
                $id_usuario = getResult($resultado, 1);
                $resultado = $BBDD->selectBy("publicaciones", array("publicaciones.id"), "INNER JOIN usuarios ON publicaciones.id_usuario = usuarios.id", "WHERE name LIKE '$autorPost' AND fecha LIKE '$fecha'");
                $id_post = getResult($resultado, 1);
                $BBDD->Insert("comentarios", "id_usuario, id_publicacion, text", array("$id_usuario", "$id_post", "$text"));
            }
        }   
    } 

    
    function paginado(){
        $resultado = [];
        $num = $_POST["page"];
        array_push($resultado, ($num * 5) - 5);
        array_push($resultado, 5);
        return $resultado;
    }
    
    function checkEmptyText($text){
        if(isset($text) && strlen(preg_replace("/\s+/u", "", $text)) != 0){
            return true;
        }else{
            return false;
        }
    }

?>
