<?php
/*****************************************************************************
 * Archivo que redirecciona al contenido que se va incrustar dentro del main
 ******************************************************************************/
if (isset($_GET['m'])) {
    $pagina = 'views/' . $_GET['m'] . '.php'; //variable de pagina, redireccionadas
    if (file_exists($pagina)) {
        require_once($pagina);
    } else {
        require_once("views/404.php");
    }
} else {
    require_once('views/ingreso.php');
}
