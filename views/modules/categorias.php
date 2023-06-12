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
    $nombre = $_POST["Nombre"];

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbCategorias->InsertCategoria($conexion, $nombre, $hijo_de);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':

            $msj = "0x20";
            $affectedRows = $dbCategorias->UpdateCategoria($conexion, $id, $nombre, $hijo_de);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbCategorias->DeleteCategoria($conexion, $id) > 0) {
                //unlink("img/productos/" . $imagenActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=categorias&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbCategorias->MayorIdCategoira($conexion);
            foreach ($maxid as $iddd) {
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $categoria = array(
                "idCategoria" => $id,
                "Nombre" => "",
                "Hijo_de" => ""
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $categoria = $dbCategorias->selectCategoria($conexion, $id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $categoria = $dbCategorias->selectCategoria($conexion, $id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Categoria";
        $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Categoria";
        $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Categoria";
        $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i>Home</a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas"><i class="bi bi-tags"></i>Categorias</a>
    <a href="#" title="Estas justo aqui" class="active"><i class="<?= $icono ?>"></i><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Categoria</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=categoria&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $categoria["idCategoria"]; ?>">
                    <i class="bi bi-qr-code-scan"></i><span> Id Categoria</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="Nombre" value="<?= $categoria["idCategoria"] ?>" <?= $status ?>>
                    <i class="bi bi-grid-1x2"></i><span> Nombre </span>
                    <input required type="text" name="Nombre" value="<?= $categoria["Nombre"] ?>" <?= $status ?>>
                    <i class="bi bi-diagram-3"></i><span> Referencia de otra categoria </span>
                    <input required type="number" min="0" name="Hijo_de" value="<?= $categoria["Hijo_de"] ?>" <?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>