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
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $celular = $_POST["celular"];
    $cargo = $_POST["cargo"];

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbContactos->InsertarContacto($dni, $nombre, $email, $celular, $cargo);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':

            $msj = "0x20";
            $affectedRows = $dbContactos->UpdateContacto($id, $dni, $nombre, $email, $celular, $cargo);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbContactos->deleteContacto($id) > 0) {
                //unlink("img/productos/" . $imagenActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=contactos&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbContactos->MayorContacto();
            foreach ($maxid as $iddd) {
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $botonView = 1;
            $contacto = array(
                "idContacto" => $id,
                "dni" => "",
                "nombre" => "",
                "email" => "",
                "celular" => "",
                "cargo" => ""
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $botonView = 1;
            $contacto = $dbContactos->selectContacto($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Eliminar";
            $status = "disabled";
            $contacto = $dbContactos->selectContacto($id);
            break;
        case 'view':
            $id = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
            $status = "disabled";
            $contacto = $dbContactos->selectContacto($id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "btn-delete";
        $hacer = "Eliminar Contacto";
        break;
    case 'Agregar':
        $style = "btn-add";
        $hacer = "Agregar Contacto";
        break;
    case 'Actualizar':
        $style = "btn-update";
        $hacer = "Actualizar Contacto";
        break;
    case 'Ver':
        $style = "";
        $hacer = "Ver Contacto";
        break;
    default:
        # code...
        break;
}
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=contactos" title="Ir a Contactos">Contactos</a>
    <a href="#" title="Estás aquí" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Contacto</h3>
        <div class="main">
            <div class="formm">

                <form action="?m=panel&mod=contacto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $contacto["idContacto"] ?>">
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $contacto["idContacto"] ?>" <?= $status ?>>
                    <strong> DNI </strong>
                    <input required type="number" oninput="validateLength(this, 8)" name="dni" value="<?= $contacto["dni"] ?>" <?= $status ?>>
                    <strong> Nombres y Apellidos </strong>
                    <input required type="text" name="nombre" value="<?= $contacto["nombre"] ?>" <?= $status ?>>
                    <strong> Email </strong>
                    <input required type="email" name="email" value="<?= $contacto["email"] ?>" <?= $status ?>>
                    <strong> Celular </strong>
                    <input required type="number" oninput="validateLength(this, 9)" name="celular" value="<?= $contacto["celular"] ?>" <?= $status ?>>
                    <strong> Cargo </strong>
                    <div class="custom-select">
                        <select name="cargo" <?= $status ?>>
                            <option value="Dueño de negocio" <?= ($contacto["cargo"] == 'Dueño de negocio') ? 'selected' : '' ?>>Dueño de negocio</option>
                            <option value="Gerente" <?= ($contacto["cargo"] == 'Gerente') ? 'selected' : '' ?>>Gerente</option>
                            <option value="Otros" <?= ($contacto["cargo"] == 'Otros') ? 'selected' : '' ?>>Otros</option>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></apan> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <br><br>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" class="btn-actions <?= $style ?>"><?= $btn ?></button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>