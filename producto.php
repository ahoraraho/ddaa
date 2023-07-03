<?php
// Valido que el usuario sea administrador
if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}

// Valido que haya una accion a realizar, sino se irá a crear un nuevo producto
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Valido que tipo de peticion invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aca se deben procesar los datos del formulario ejecutado
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio =  $_POST["precio"];
    $marca =  $_POST["marca"];
    $categoria =  $_POST["categoria"];
    $presentacion =  $_POST["presentacion"];
    $descripcion = $_POST["descripcion"];
    $stock =  $_POST["stock"];
    $destacado =  $_POST["destacado"];
    $tendencia =  $_POST["tendencia"];

    $imagen = $_FILES["imagen"];
    $imagenNombre = $imagen["name"];

    $imagenActual = $_POST["imgAgtual"];

    $directorio = "img/productos/" . $imagenNombre;

    switch ($action) {
        case 'add':
            $msj = "0x400"; //BUG
            $affectedRows = $dbProductos->InsertProducto($conexion, $nombre, $precio, $marca, $categoria, $presentacion, $descripcion, $stock, $imagenNombre, $destacado, $tendencia);
            if ($affectedRows > 0) {
                $msj = "0x10";
                if (!empty($imagenNombre)) {
                    if (move_uploaded_file($imagen["tmp_name"], $directorio) == false) {
                        $msj = "0x11";
                    }
                }
            }
            break;
        case 'update':
            if (!empty($imagenNombre)) {
                if (move_uploaded_file($imagen["tmp_name"], $directorio) == true) {
                    $sqlImagen = $imagenNombre;
                    unlink("img/productos/" . $imagenActual);
                } else {
                    $msj = "0x21";
                }
            } else {
                $sqlImagen = $imagenActual;
            }
            $affectedRows = $dbProductos->UpdateProducto($conexion, $id, $nombre, $precio, $marca, $categoria, $presentacion, $descripcion, $stock, $sqlImagen, $destacado, $tendencia);
            if ($affectedRows == 0) {
                $msj = "0x400";
            }
            $msj = "0x20";
            break;
        case 'delete':
            $msj = "0x400";
            if ($dbProductos->DeleteProducto($conexion, $id) > 0) {
                unlink("img/productos/" . $imagenActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=productos&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            $maxid = $dbProductos->MayorIdProducto($conexion);
            $id = ($maxid["maxId"] + 1);
            $btn = "Agregar";
            $status = null;
            $producto = array(
                "idProducto" => $id,
                "Nombre" => "",
                "Precio" => "",
                "Marca" => "",
                "Categoria" => "",
                "Presentacion" => "",
                "Descripcion" => "",
                "Stock" => "",
                "Destacado" => "0",
                "Tendencia" => "0",
                "Imagen" => ""
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $producto = $dbProductos->selectProducto($conexion, $id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $producto = $dbProductos->selectProducto($conexion, $id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Producto";
        $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Producto";
        $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Producto";
        $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i> Home</a>
    <a href="?m=panel&mod=productos" title="Ir a Productos"><i class="bi bi-box-seam"></i> Productos</a>
    <a href="#" title="Estas justo aqui" class="active"><i class="<?= $icono ?>"></i> <?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Producto</h3>
        <div class="main">
            <div class="form">
                <form action="?m=panel&mod=producto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $producto["idProducto"] ?>">
                    <input type="hidden" name="imgAgtual" value="<?= $producto["Imagen"] ?>">

                    <i class="bi bi-upc-scan"></i><span> Id Producto </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" value="<?= $producto["idProducto"] ?>" <?= $status ?>>
                    <i class="bi bi-collection"></i><span> Nombre </span>
                    <input required type="text" name="nombre" value="<?= $producto["Nombre"] ?>" <?= $status ?>>
                    <i class="bi bi-cash-coin"></i><span>Precio S/.</span>
                    <input required type="number" min="0" step="0.5" name="precio" value="<?= $producto["Precio"] ?>" <?= $status ?>>
                    <i class="bi bi-m-button-fill"></i><span> Marca </span>
                    <select name="marca" required <?= $status; ?>>
                        <option value="">Elija una marca...</option>
                        <?php
                        $marcas = $dbProductos->selectMarcas($conexion);
                        foreach ($marcas as $marca) {
                            $idMarca = $marca["idMarca"];
                            $nombre = $marca["Nombre"];
                            $marca = $producto["Marca"];
                        ?>
                            <option value="<?= $idMarca ?>" <?= ($idMarca == $marca) ? "selected" : null ?>> <?= $nombre ?> </option>
                        <?php } ?>
                    </select>

                    <i class="bi bi-grid-1x2"></i><span> Categoria </span>
                    <select name="categoria" required <?= $status; ?>>
                        <option value="">Elija una categoria...</option>
                        <?php
                        $categorias = $dbProductos->selectCategorias($conexion);
                        foreach ($categorias as $categoria) {
                            $idCategoria = $categoria["idCategoria"];
                            $nombre = $categoria["Nombre"];
                            $categoria = $producto["Categoria"];
                        ?>
                            <option value="<?= $idCategoria ?>" <?= ($idCategoria == $categoria) ? "selected" : null ?>> <?= $nombre ?> </option>
                        <?php } ?>
                    </select>

                    <i class="bi bi-chat-square-dots"></i><span> Presentacion </span>
                    <input required type="text" name="presentacion" value="<?= $producto["Presentacion"]; ?>" <?= $status ?>>
                    <i class="bi bi-body-text"></i><span> Descripcion </span>
                    <textarea required type="text" name="descripcion" value="" <?= $status ?>><?= $producto["Descripcion"]; ?></textarea>
                    <i class="bi bi-sort-numeric-up"></i><span>Stock</span>
                    <input required type="number" min="0" name="stock" value="<?= $producto["Stock"]; ?>" <?= $status ?>>
                    <i class="bi bi-pin-angle"></i><span> Destacado </span>
                    <input required type="number" min="0" name="destacado" value="<?= $producto["Destacado"] ? '1' : '0'; ?>" <?= $status ?>>
                    <i class="bi bi-pin-angle"></i><span> Tendencia </span>
                    <input required type="number" min="0" name="tendencia" value="<?= $producto["Tendencia"] ? '1' : '0'; ?>" <?= $status ?>>

                    <input type="file" name="imagen" id="selectImg" accept="image/*" <?= $status ?>>
                    <div style="text-align: center;">
                        <label for="selectImg" name="addImg" id="addImg" style="<?= $styleImage ?>" class="form_login">Elegir imagen</label>
                    </div>

                    <div class="center">
                        <div class="previewImg">
                            <?php if (!empty($producto["Imagen"])) : ?>
                                <img id="previewImg" src="img/productos/<?= $producto["Imagen"]; ?>" style="max-width:100%">
                            <?php else : ?>
                                <img id="previewImg" src="" style="max-width:100%">
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>