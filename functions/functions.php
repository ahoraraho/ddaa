<?php
function alertaResponDialog($typeMesaje, $mesaje, $icono1)
{
    $alerta = "
	<div id='conten-mensaje'>
		<div class='cajaMsj $typeMesaje'>$mesaje
			<div class='iconoMesaje'>
				<i class='bi $icono1'></i>
			</div>
			<div class='iconoClose'>
				<i id='ocultar-mostrar' class='bi bi-x-lg'></i>
			</div>
		</div>
	</div>";
    echo $alerta;
}
//FUNCION QUE VALIDA QUE LA SECION HAYA SIDO CREADA CORRECTAMENTE SINO MANDA AL INICIO
function validacionIicioSesion()
{
    if (!$_SESSION["Usuario"]) {
        header('location: ./');
        exit;
    }
}
//FUNCION PARA INPRIMIR QUE ACCION ES LA QUE SE ESTA HACIENDO
function mensaje($modulo, $pul = 'o')
{

    if (isset($_GET['msj'])) {
        $msj = $_GET['msj'];
        $typeMsj = "";
        switch ($msj) {
            case '0x10':
                $msj = $modulo . " Agregad" . $pul . "!";
                $typeMsj = "msj-ok";
                $iconoAlert = "bi-check-circle";
                break;
            case '0x11':
                $msj = "Noticia agregada, pero hubo un error al tratar de guardar la imagen!";
                $typeMsj = "msj-warning";
                $iconoAlert = "bi-exclamation-circle";
                break;
            case '0x20':
                $msj = $modulo . " Actualizad" . $pul . "!";
                $typeMsj = "msj-ok";
                $iconoAlert = "bi-check2-circle";
                break;
            case '0x21':
                $msj = "noticia actualizada, pero hubo un error al tratar de guardar la imagen!";
                $typeMsj = "msj-warning";
                $iconoAlert = "bi-wrench-adjustable-circle";
                break;
            case '0x22':
                $msj = "Contraseña actualizada";
                $typeMsj = "msj-warning";
                $iconoAlert = "bi-wrench-adjustable-circle";
                break;
            case '0x30':
                $msj = $modulo . " Eliminad" . $pul . "!";
                $typeMsj = "msj-warning";
                $iconoAlert = "bi-info-circle";
                break;
            case '0x1000':
                $msj = "Hubo un error al intentar realizar la operación!";
                $typeMsj = "msj-error";
                $iconoAlert = "bi-bug";
                break;
        }
        alertaResponDialog($typeMsj, $msj, $iconoAlert);
    }
}

function eliminarCarpeta($ruta) {
    // Verificar si la ruta es una carpeta
    if (!is_dir($ruta)) {
        return false;
    }

    // Abrir el directorio
    $directorio = opendir($ruta);

    // Recorrer los archivos y subcarpetas dentro de la carpeta
    while (($archivo = readdir($directorio)) !== false) {
        if ($archivo != '.' && $archivo != '..') {
            // Obtener la ruta completa del archivo o subcarpeta
            $rutaCompleta = $ruta . '/' . $archivo;

            // Verificar si es un archivo o una carpeta
            if (is_file($rutaCompleta)) {
                // Eliminar el archivo
                unlink($rutaCompleta);
            } elseif (is_dir($rutaCompleta)) {
                // Llamar a la función recursivamente para eliminar la subcarpeta
                eliminarCarpeta($rutaCompleta);
            }
        }
    }

    // Cerrar el directorio
    closedir($directorio);

    // Eliminar la carpeta vacía
    return rmdir($ruta);
}





//*FUNCIONES QUE TODABIA NO SE ESTAN USANDO */

function createPaginationLogueado($paginas_total, $pagina, $filtro, $orden, $limite, $mod)
{
    if ($paginas_total > 1) {
        echo "<ul class='paginador'>";
        if ($pagina != 1) {
            echo "<li><a href='?m=panel&mod=$mod&buscar=$filtro&limite=$limite" . (($orden == '') ? '' : '&order=' . $orden) . "&pag=" . ($pagina - 1) . "'><i class='bi bi-arrow-left-circle'></i></a></li>";
        }
        for ($i = 1; $i <= $paginas_total; $i++) {
            echo "<li><a class='" . (($pagina == $i) ? 'active' : '') . "' href='?m=panel&mod=$mod&buscar=$filtro&limite=$limite" . (($orden == '') ? '' : '&order=' . $orden) . "&pag=$i'>$i</a></li>";
        }
        if ($pagina != $paginas_total) {
            echo "<li><a href='?m=panel&mod=$mod&buscar=$filtro&limite=$limite" . (($orden == '') ? '' : '&order=' . $orden) . "&pag=" . ($pagina + 1) . "'><i class='bi bi-arrow-right-circle'></i></a></li>";
        }
        echo "</ul>";
    }
}

function createPagination($paginas_total, $pagina, $filtro, $orden, $limite)
{
    if ($paginas_total > 1) {
        $base_url = "?m=productos&buscar=$filtro&limite=$limite" . (($orden == '') ? '' : '&order=' . $orden) . "&pag=";
        echo "<ul class='paginador'>";
        if ($pagina != 1) {
            echo "<li><a href='$base_url" . ($pagina - 1) . "'><i class='bi bi-arrow-left-circle'></i></a></li>";
        }
        for ($i = 1; $i <= $paginas_total; $i++) {
            echo "<li><a class='" . (($pagina == $i) ? 'active' : '') . "' href='$base_url$i'>$i</a></li>";
        }
        if ($pagina != $paginas_total) {
            echo "<li><a href='$base_url" . ($pagina + 1) . "'><i class='bi bi-arrow-right-circle'></i></a></li>";
        }
        echo "</ul>";
    }
}


function getFiltroPaginaOrdenCategoriaLimite()
{
    $filtro = 'all';
    $pagina = 1;
    $orden = '';
    $categoria = '';
    $marca = '';
    $limite = 10;

    if (isset($_GET['buscar'])) {
        $filtro = $_GET['buscar'];
        if ($filtro == '') {
            $filtro = 'all';
        }
    }

    if (isset($_GET['pag'])) {
        $pagina = $_GET['pag'];
    }

    if (isset($_GET['orden'])) {
        $orden = $_GET['orden'];
    }

    if (isset($_GET['categoria'])) {
        $categoria = $_GET['categoria'];
        $filtro = $categoria;
    }

    if (isset($_GET['marca'])) {
        $marca = $_GET['marca'];
        $filtro = $marca;
    }

    if (isset($_GET['limite'])) {
        $limite = $_GET['limite'];
    }

    return array($filtro, $pagina, $orden, $categoria, $marca, $limite);
}


// function procesarAddCarrito($id, $idCliente)
// {
//     $carrito = SelectCarrito($idCliente);
//     if ($carrito) {
//         $productoExist = false;
//         $cantidadActual = 0;
//         foreach ($carrito as $item) {
//             if ($item["idProducto"] == $id) {
//                 $productoExist = true;
//                 $cantidadActual = $item["cantidad"];
//             }
//         }
//         if ($productoExist) {
//             //UpdateCarrito($idCliente, $id, ($cantidadActual + 1));
//         } else {
//             //InsertCarrito($idCliente, $id, 1);
//         }
//     } else {
//         //InsertCarrito($idCliente, $id, 1);
//     }
//     //alertaResponDialog("msj-ok", "Producto añadifo al carrito", "bi-check");
//     //header('location: ?m=home&mesage=ok');
// }
