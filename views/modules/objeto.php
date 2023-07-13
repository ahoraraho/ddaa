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
            $affectedRows = $dbObjetos->InsertObjeto($nombre);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':

            $msj = "0x20";
            $affectedRows = $dbObjetos->UpdateObjeto($id, $nombre);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbObjetos->DeleteObjeto($id) > 0) {
                //unlink("img/productos/" . $imagenActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=objetos&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {

        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbObjetos->MayorIdObjeto();
            foreach ($maxid as $iddd) {
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $objeto = array(
                "idObjeto" => $id,
                "nombre" => ""
            );

            $botonView = 1;
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $objeto = $dbObjetos->selectObjeto($id);

            $botonView = 1;
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $objeto = $dbObjetos->selectObjeto($id);

            $botonView = 1;
            break;
        case 'view':
            $id = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
            $status = "disabled";
            $objeto = $dbObjetos->selectObjeto($id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "btn-delete";
        $hacer = "Eliminar Objeto";
        break;
    case 'Agregar':
        $style = "btn-add";
        $hacer = "Agregar Objeto";
        break;
    case 'Actualizar':
        $style = "btn-update";
        $hacer = "Actualizar Objeto";
        break;
    case 'Ver':
        $style = "";
        $hacer = "Ver Objeto";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=objetos" title="Ir a Objetos">Objetos</a>
    <a href="#" title="Estas justo aqui" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Objeto</h3>
        <div class="main">
            <div class="formm">

                <form action="?m=panel&mod=objeto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $objeto["idObjeto"]; ?>">
                    <b> # Objeto</b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $objeto["idObjeto"] ?>" <?= $status ?>>
                    <b> Objeto </b>
                    <input required type="text" name="nombre" value="<?= $objeto["nombre"] ?>" <?= $status ?>>
                    <br><br>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" class="btn-actions <?= $style ?>"><?= $btn; ?></button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>