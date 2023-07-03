<?php
if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}

//$filtro = "";
//$orden = "";

//$limite = 10; // CANTIDAD DE PRODUCTOS POR PÁGINA

//$urlProductosFiltrado = $urlProductos . "&buscar=" . $filtro . "&orden=" . $orden;

list($filtro, $pagina, $orden, $categoria, $marca, $limite) = getFiltroPaginaOrdenCategoriaLimite();

$cantidad_productos = $dbProductos->countProductos($conexion, $filtro);

$paginas_total = ceil($cantidad_productos / $limite);

$urlProductos = "?m=panel&mod=productos";

$urlProductosFiltrado = "?m=panel&mod=productos&limite=" . $limite . "&pag=" . $pagina . "&buscar=" . $filtro;

$urlProductosFiltradoOrden = "?m=panel&mod=productos&limite=" . $limite . "&orden=" . $orden . "&pag=" . $pagina . "&buscar=" . $filtro;

?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i> Home </a>
    <a href="#" title="Estas justo aqui" class="active"><i class="bi bi-box-seam"></i> Productos</a>
</div>

<?php
// Valido que haya una accion por GET
if (isset($_GET["action"])) {
    $action = $_GET["action"];
    $id = $_GET["id"];

    switch ($action) {
        case 'destacado':
            $dbProductos->UpdateProductoDestacado($conexion, $id, '1');
            //header('location: ?m=panel&mod=productos');
            alertaResponDialog("msj-ok", "Producto destacado", "bi-check-circle");
            break;

        case 'noDestacado':
            $dbProductos->UpdateProductoDestacado($conexion, $id, '0');
            //header('location: ?m=panel&mod=productos');
            alertaResponDialog("msj-warning", "Producto no destacado", "bi-exclamation-circle");
            break;
    }
}
if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
        case '0x10':
            $msj = "Producto agregado correctamente!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check-circle";
            break;
        case '0x11':
            $msj = "Producto agregado, pero hubo un error al tratar de guardar la imagen!";
            $typeMsj = "msj-warning";
            $iconoAlert = "bi-exclamation-circle";
            break;
        case '0x20':
            $msj = "Producto actualizado correctamente!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check2-circle";
            break;
        case '0x21':
            $msj = "Producto actualizado, pero hubo un error al tratar de guardar la imagen!";
            $typeMsj = "msj-warning";
            $iconoAlert = "bi-wrench-adjustable-circle";
            break;
        case '0x30':
            $msj = "Producto eliminado!";
            $typeMsj = "msj-alert";
            $iconoAlert = "bi-info-circle";
            break;
        case '0x400':
            $msj = "Hubo un error al intentar realizar la operación!";
            $typeMsj = "msj-error";
            $iconoAlert = "bi-bug";
            break;
    }
    alertaResponDialog($typeMsj, $msj, $iconoAlert);
}
?>

<h3>Productos </h3>

<div class="numm">
    <div class="f1">
        <div class="filtrador">
            <div class="filtrador_boton">
                <button onclick="verCategoria()" class="dropbtnCategoria">Categorias</button>
                <div id="myDropdown-c" class="filtrador-content filtrador-content-c">
                    <?php
                    $categorias = $dbProductos->selectCategorias($conexion);
                    foreach ($categorias as $categoria) {
                        $nombreCa = $categoria["Nombre"]; ?>
                        <a href="<?= $urlProductos ?>&buscar=<?= $nombreCa ?>"><?= $nombreCa ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="f2">
        <div class="filtrador">
            <div class="filtrador_boton">
                <button onclick="verMarca()" class="dropbtnMarca">Marcas</button>
                <div id="myDropdown-m" class="filtrador-content filtrador-content-m">
                    <?php
                    $marcas = $dbProductos->selectMarcas($conexion);
                    foreach ($marcas as $marca) {
                        $nombreMa = $marca["Nombre"]; ?>
                        <a href="<?= $urlProductos ?>&buscar=<?= $nombreMa ?>"><?= $nombreMa ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="numm">

    <div class="f1">
        <form class="from_input" action="" method="GET">
            <!-- para agregar la vista de ?m=productos en la url -->
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="productos">
            <!-- concatenando el valor a buscar -->
            <input type="text" name="buscar" placeholder="Buscar?todos...">
            <!-- <input type="submit" value="BUSCAR"> -->
            <button class="btn-buscador" type="submit"><i class="bi-search"></i></button>
        </form>
        <span class="f-s"><?= $cantidad_productos ?> </span>
    </div>
    <div class="f2">
        <div class="filtros_botones">
            <?php if ($orden == "") { ?>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=mayor-precio" title="Filtrar por precio mayor"><i class=" abi bi-sort-numeric-down"></i></a>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=z-a" title="Filtrar Z - A"><i class="bi-sort-alpha-down"></i></a>
            <?php  }
            if ($orden == "menor-precio") { ?>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=mayor-precio" title="Filtrar por precio mayor"><i class="bi-sort-numeric-down"></i></a>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=z-a" title="Filtrar A - Z"><i class="bi-sort-alpha-down"></i></a>
            <?php }
            if ($orden == "mayor-precio") { ?>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=menor-precio" title="Filtrar por precio menor"><i class="bi bi-sort-numeric-down-alt"></i></a>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=a-z" title="Filtrar A - Z"><i class="bi-sort-alpha-down"></i></a>
            <?php }
            if ($orden == "a-z") { ?>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=mayor-precio" title="Filtrar por precio mayor"><i class="bi-sort-numeric-down"></i></a>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=z-a" title="Filtrar Z - A"><i class="bi-sort-alpha-down"></i></a>
            <?php }
            if ($orden == "z-a") { ?>
                <a class="btn_filtrador" href="<?= $urlProductosFiltrado ?>&orden=mayor-precio" title="Filtrar por precio mayor"><i class="bi-sort-numeric-down"></i></a>
                <a class="btn_filtrador " href="<?= $urlProductosFiltrado ?>&orden=a-z" title="Filtrar A - Z"><i class="bi-sort-alpha-down-alt"></i></a>
            <?php } ?>
        </div>
        <a href="?m=panel&mod=producto&action=add" class="button-link f-e">
            <i class="abi bi bi-plus-square"></i><span>Nuevo producto</span>
        </a>
        <div class="formFiltro"><!--formulario escondido-->
            <form class="btn-filtro-alfabeto" action="" method="GET">
                <input type="hidden" name="m" value="panel">
                <input type="hidden" name="mod" value="productos">
                <input type="hidden" name="buscar" value="<?= $filtro ?>">
                <input type="hidden" id="orden" name="orden" value="z-a">
                <button onclick="filtrardorAlfabeto()" title="Filtro de Alfabeto" class="btn-filtro" type="submit">
                    <i id="icono_alfabeto" class="class_alfabeto bi-sort-alpha-down"></i>
                </button>
            </form>
            <form class="btn-filtro-precio" action="" method="GET">
                <input type="hidden" name="m" value="panel">
                <input type="hidden" name="mod" value="productos">
                <input type="hidden" name="buscar" value="<?= $filtro ?>">
                <input type="hidden" id="orden" name="orden" value="menor-precio">
                <button onclick="filtrardorPrecio()" title="Filtro del Precio" class="btn-filtro" type="submit">
                    <i id="icono_precio" class="class_precio bi-sort-numeric-down"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<!-- tabla productos -->
<div class="contenido-tabla">
    <table class="resp">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Marca</th>
                <th>Categoria</th>
                <th>Presentacion</th>
                <th>Stock</th>
                <th>Destacado</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $productos = $dbProductos->selectProductos($conexion, $filtro, $orden, $categoria, $marca, $pagina, $limite);
            foreach ($productos as $producto) {
                $imagen = $producto['Imagen'];
                $id = $producto['idProducto'];
                $nombre = $producto['Nombre'];
                $precio = $producto['Precio'];
                $marca = $producto["Marca"];
                $categoria = $producto["Categoria"];
                $presentacion = $producto["Presentacion"];
                $stock = $producto["Stock"];
                $destacado = $producto["Destacado"];
            ?>
                <tr>
                    <?php if (!empty($imagen)) : ?>
                        <td><img src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>"></td>
                    <?php else : ?>
                        <td><img src="img/pemtry.png"></td>
                    <?php endif; ?>
                    <td><?= $nombre ?></td>
                    <td>S/. <?= $precio ?></td>
                    <td><?= $marca ?></td>
                    <td><?= $categoria ?></td>
                    <td><?= $presentacion ?></td>
                    <td><?= $stock ?></td>
                    <td>
                        <?php if ($destacado) {
                            $status = "checked";
                        ?> <a href="<?= $urlProductosFiltradoOrden ?>&action=noDestacado&id=<?= $id ?>" title="Des fijar"><i class="bi bi-shield-x" style="color: rgb(8, 164, 8); font-size: 30px;"></i>
                                <p>Destacado</p>
                            </a>
                        <?php } else {
                            $status = null; ?>
                            <a href="<?= $urlProductosFiltradoOrden ?>&action=destacado&id= <?= $id ?>" title="Fijar"><i class="bi bi-shield-check" style="color: red; font-size: 30px;"></i>
                                <p>No Destacado</p>
                            </a>
                        <?php } ?>
                        <input type="checkbox" <?= $status ?> name="status" value="destacado" id="destacado">
                    </td>
                    <td>
                        <a href="?m=panel&mod=producto&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square" ><b> </i></a>
                        <a href="?m=panel&mod=producto&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash" ><b></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="piePagina">
    <div class="derecha">
        <form class="num_paginas--filtro" action="" method="GET">
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="productos">
            <input type="hidden" name="buscar" value="<?= $filtro ?>">
            <input type="hidden" name="orden" value="<?= $orden ?>">
            <select class="form-select" name="limite">
                <option <?= ($limite == '15') ? 'selected' : ''; ?> value="15">15</option>
                <option <?= ($limite == '10') ? 'selected' : ''; ?> value="10">10</option>
                <option <?= ($limite == '5') ? 'selected' : ''; ?> value="5">5</option>
            </select>
            <button onclick="filtrardorAlfabeto()" title="Numero de productos" class="btn-filtro-num" type="submit">
                <i class="bi bi-sliders"></i>
            </button>
        </form>
    </div>
    <div class="izquierda">
        <?php
        createPaginationLogueado($paginas_total, $pagina, $filtro, $orden, $limite, "productos");
        ?>
    </div>
</div>



<script>
    /*function filtrardorAlfabeto() {
        const inputOrder = document.getElementById("orden");
        const icono_alfabeto = document.getElementById("icono_alfabeto");
        //const inputOrder = document.getElementById("orden");
        if (localStorage.getItem('class_alfabeto') === 'bi-sort-alpha-down') {
            localStorage.setItem('class_alfabeto', 'bi-sort-alpha-down-alt');
            icono_alfabeto.classList.replace("bi-sort-alpha-down", "bi-sort-alpha-down-alt");
        } else {
            localStorage.setItem('class_alfabeto', 'bi-sort-alpha-down');
            icono_alfabeto.classList.replace("bi-sort-alpha-down-alt", "bi-sort-alpha-down");
        }
        if (inputOrder.value === "a-z") {
            inputOrder.value = "z-a";
            localStorage.setItem('orden', 'z-a');
        } else {
            inputOrder.value = "a-z";
            localStorage.setItem('orden', 'a-z');
        }
    }*/

    function filtrardorAlfabeto() {
        const formAlfabeto = document.querySelector('.btn-filtro-alfabeto');
        const inputOrder = formAlfabeto.querySelector('input[name="orden"]');
        const icono_alfabeto = document.getElementById("icono_alfabeto");
        if (localStorage.getItem('class_alfabeto') === 'bi-sort-alpha-down') {
            localStorage.setItem('class_alfabeto', 'bi-sort-alpha-down-alt');
            icono_alfabeto.classList.replace("bi-sort-alpha-down", "bi-sort-alpha-down-alt");
        } else {
            localStorage.setItem('class_alfabeto', 'bi-sort-alpha-down');
            icono_alfabeto.classList.replace("bi-sort-alpha-down-alt", "bi-sort-alpha-down");
        }
        if (inputOrder.value === "a-z") {
            inputOrder.value = "z-a";
            localStorage.setItem('orden', 'z-a');
        } else {
            inputOrder.value = "a-z";
            localStorage.setItem('orden', 'a-z');
        }
    }
    /*
        function filtrardorPrecio() {
            const inputOrder = document.getElementById("orden");
            const icono_precio = document.getElementById("icono_precio");
            //const inputOrder = document.getElementById("orden");
            if (localStorage.getItem('class_precio') === 'bi-sort-numeric-up-alt') {
                localStorage.setItem('class_precio', 'bi-sort-numeric-down');
                icono_precio.classList.replace("bi-sort-numeric-up-alt", "bi-sort-numeric-down");
            } else {
                localStorage.setItem('class_precio', 'bi-sort-numeric-up-alt');
                icono_precio.classList.replace("bi-sort-numeric-down", "bi-sort-numeric-up-alt");
            }
            if (inputOrder.value === "menor-precio") {
                inputOrder.value = "mayor-precio";
                localStorage.setItem('orden', 'mayor-precio');
            } else {
                inputOrder.value = "menor-precio";
                localStorage.setItem('orden', 'menor-precio');
            }
        }*/


    function filtrardorPrecio() {
        const formPrecio = document.querySelector('.btn-filtro-precio');
        const inputOrder = formPrecio.querySelector('input[name="orden"]');
        const icono_precio = document.getElementById("icono_precio");
        if (localStorage.getItem('class_precio') === 'bi-sort-numeric-up-alt') {
            localStorage.setItem('class_precio', 'bi-sort-numeric-down');
            icono_precio.classList.replace("bi-sort-numeric-up-alt", "bi-sort-numeric-down");
        } else {
            localStorage.setItem('class_precio', 'bi-sort-numeric-up-alt');
            icono_precio.classList.replace("bi-sort-numeric-down", "bi-sort-numeric-up-alt");
        }
        if (inputOrder.value === "menor-precio") {
            inputOrder.value = "mayor-precio";
            localStorage.setItem('orden', 'mayor-precio');
        } else {
            inputOrder.value = "menor-precio";
            localStorage.setItem('orden', 'menor-precio');
        }
    }

    window.onload = function() {
        const class_alfabeto = localStorage.getItem('class_alfabeto');
        //const icono_alfabeto = document.querySelector('.class_alfabeto');
        const icono_alfabeto = document.getElementById("icono_alfabeto");
        if (class_alfabeto) {
            icono_alfabeto.className = class_alfabeto;
        }
        const class_precio = localStorage.getItem('class_precio');
        const icono_precio = document.getElementById("icono_precio");
        //const icono_precio = document.querySelector('.class_precio');
        if (class_precio) {
            icono_precio.className = class_precio;
        }

        const inputOrder = document.getElementById("orden");
        const orderValue = localStorage.getItem('orden');
        if (orderValue) {
            inputOrder.value = orderValue;
        }
    }
    /*
    window.onload = function() {
        const icono_precio = document.getElementById("icono_precio");
        const className_precio = localStorage.getItem('icono_alfabeto');
        icono_precio.className = className_precio;

        const icono_alfabeto = document.getElementById("icono_alfabeto");
        const className_alfabeto = localStorage.getItem('icono_alfabeto');
        icono_alfabeto.className = className_alfabeto;

        const inputOrder = document.getElementById("orden");
        const orderValue = localStorage.getItem('orden');
        inputOrder.value = orderValue;
    }*/


    /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
    function verMarca() {
        document.getElementById("myDropdown-m").classList.toggle("show");
        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtnMarca')) {
                var dropdowns = document.getElementsByClassName("filtrador-content-m");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    }



    function verCategoria() {
        document.getElementById("myDropdown-c").classList.toggle("show");
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtnCategoria')) {
                var dropdowns = document.getElementsByClassName("filtrador-content-c");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    }
</script>