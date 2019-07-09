<?php
    mostrarEstaPagina();
    function mostrarEstaPagina(){
        header('application/json');
        require_once "datos_conexion.php";
        require_once "GestorSQL_PDO.php";
        $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
        $objeto = new stdClass(); // Creo el objeto vacío
        $objeto->Posts = []; // Creo e inicializo un atributo "Posts" que será un array
        $posts = $BBDD->selectBy("publicaciones", array("publicaciones.id", "text", "fecha", "name"), "INNER JOIN usuarios ON publicaciones.id_usuario = usuarios.id", "ORDER BY fecha DESC");
        foreach ($posts as $col){
            $propiedades = new stdClass(); // Creo un objeto vacío para almacenar las propiedades
            $propiedades->Texto = $col["text"]; // Le añado la propiedad "Texto"
            $propiedades->Fecha = $col["fecha"]; // Le añado la propiedad "Fecha"
            $propiedades->Usuario = $col["name"]; // Le añado la propiedad "Usuario" con el nombre del usuario que publicó
            array_push($objeto->Posts, $propiedades); // Pusheo a la propiedad "Posts" un array un objeto con las 
            //propiedades Texto y Fecha
            
            //-------------------------COMENTARIOS -----------------------------
            $id_comentario = $col["id"];
            $comentarios = $BBDD->selectBy("comentarios", array("text", "fecha", "name"), "INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id", "WHERE comentarios.id_publicacion = $id_comentario ORDER BY fecha DESC");
            $propiedades->Comentarios = [];
            $propiedades_comentarios = new stdClass();
            if ($comentarios != false) {
                foreach ($comentarios as $col_comentarios) {
                    $propiedades_comentarios->Texto = $col_comentarios["text"];
                    $propiedades_comentarios->Fecha = $col_comentarios["fecha"];
                    $propiedades_comentarios->Usuario = $col_comentarios["name"];
                    array_push($propiedades->Comentarios, $propiedades_comentarios);
                }
            }
            
            array_push($objeto->Posts, $propiedades); // Pusheo a la propiedad "Posts" un array un objeto con las 
            //propiedades Texto y Fecha
        }
        var_export($objeto);
        
    }

?>