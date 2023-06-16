<?php
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
            $affectedRows = $dbContactos->UpdateContacto($id,$dni,$nombre,$email,$celular,$cargo);
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
            $contacto = $dbContactos->selectContacto($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $contacto = $dbContactos->selectContacto($id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Contacto";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Contacto";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Contacto";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Contactos">Contactos</a>
    <a href="#" title="Estás aquí" class="active">Contacto</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>CONTACTO</h3>
        <div class="main">
            <div class="formm">
               
                <form action="?m=panel&mod=contacto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $contacto["idContacto"] ?>">
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $contacto["idContacto"] ?>" <?= $status ?>>
                    <span> DNI </span>
                    <input required type="text" name="dni" value="<?= $contacto["dni"] ?>"<?= $status ?>>
                    <span> Nombre </span>
                    <input required type="text" name="nombre" value="<?= $contacto["nombre"] ?>"<?= $status ?>>
                    <span> Email </span>
                    <input required type="email" name="email" value="<?= $contacto["email"] ?>"<?= $status ?>>
                    <span> Celular </span>
                    <input required type="text" name="celular" value="<?= $contacto["celular"] ?>"<?= $status ?>>
                    </i><span> Cargo </span>
                    <input required type="text" name="cargo" value="<?= $contacto["cargo"] ?>"<?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
