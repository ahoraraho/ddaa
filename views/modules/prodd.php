<?php
validacionIicioSesion();

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

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbProdds->InsertProdd($nombre);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':
            $msj = "0x20";
            $affectedRows = $dbProdds->UpdateProdd($id, $nombre);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbProdds->DeleteProdd($id) > 0) {
                //unlink("img/productos/" . $imagenActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=prodds&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbProdds->MayorIdProdd();
            $id = $maxid + 1;
            $btn = "Agregar";
            $status = null;
            $prodd = array(
                "idActual" => $id,
                "nombre" => ""
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $prodd = $dbProdds->selectProdd($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $prodd = $dbProdds->selectProdd($id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Tipo Actualización";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Tipo Actualización";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Tipo Actualización";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=actualizaciones" title="Ir a Actulizaciones">Actualizaciones</a>
    <a href="?m=panel&mod=prodds" title="Ir a Tipos de Actualizaciones">Tipos de Actualizaciones</a>
    <a href="#" title="Estas justo aqui" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Tipos de Actualizaciones</h3>
        <div class="main">
            <div class="formm">

                <form action="?m=panel&mod=prodd&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $prodd["idActual"]; ?>">
                    <b> Id </b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $prodd["idActual"] ?>" <?= $status ?>>
                    <b> Nombre </b>
                    <input required type="text" name="nombre" value="<?= $prodd["nombre"] ?>" <?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>