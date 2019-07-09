<?php
    session_start();
    mostrarPaginas();
    function mostrarPaginas(){
        header('application/json');
        require_once "datos_conexion.php";
        require_once "GestorSQL_PDO.php";
        $BBDD = new GestorSQL_PDO(BBDD_HOST, BBDD_USER, BBDD_PASS, BBDD_NAME);
        $objeto = new stdClass(); // Creo el objeto vacío
        $objeto->Paginas = 0; // Creo e inicializo un atributo "Páginas" que será numérico
        $paginas = $BBDD->selectCount("publicaciones", "id");
        
        foreach ($paginas as $col){
            $objeto->Paginas = conteoPaginas($col[0]);
        }
        $_SESSION["totalPages"] = $objeto->Paginas;
        echo json_encode($objeto);
        
    }
    function conteoPaginas($num){
        $resultado = $num / 5;
        return ceil($resultado);
    }


?>
