<?php

    session_start();
    
    $page = substr($_REQUEST["uri"], -5,-4); //Aquí pillo la dirección que se introdujo y extraigo el número
    
    if (is_numeric($page) && $page > 0 && $page <= $_SESSION["totalPages"]) {
        $_SESSION["page"] = $page;
    }
    
    header('Location: ../app.php');
?>

