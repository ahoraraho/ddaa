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
