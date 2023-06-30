<?php
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Validar qué tipo de petición invoca al módulo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos del formulario ejecutado
    $idEspecialista = $_POST["id"];
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $estado = $_POST["estado_actual"];

    switch ($action) {
        case 'add':
            $msj = "0x1000";
            $affectedRows = $dbEspecialistas->insertEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena, $estado);
            if ($affectedRows) {
                $msj = "0x10";
            }
            break;

        case 'update':
            $msj = "0x1000";
            $affectedRows = $dbEspecialistas->updateEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena, $estado);
            if ($affectedRows) {
                $msj = "0x20";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            $affectedRows = $dbEspecialistas->deleteEspecialista($idEspecialista);
            if ($affectedRows) {
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=usuarios&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            // Obtener el id mayor de la tabla especialista
            $maxid = $dbEspecialistas->MayorIdEspecialista();
            foreach ($maxid as $iddd) {
                $idEspecialista = $iddd["maxId"];
            }
            $idEspecialista = ($idEspecialista + 1);
            $btn = "Agregar";
            $status = null;
            $especialista = array(
                "idEspecialista" => $idEspecialista,
                "dni" => "",
                "nombre" => "",
                "apellido" => "",
                "direccion" => "",
                "telefono" => "",
                "Email" => "",
                "Contrasena" => "",
                "Estado" => "",
            );
            break;

        case 'update':
            $idEspecialista = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $especialista = $dbEspecialistas->selectEspecialista($idEspecialista);
            break;

        case 'delete':
            $idEspecialista = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $especialista = $dbEspecialistas->selectEspecialista($idEspecialista);
            break;
    }
}
?>

<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color: crimson";
        $styleImage = "display: none !important;";
        $hacer = "Eliminar Usuario";
        break;
    case 'Agregar':
        $style = "background-color: rgb(0, 176, 26)";
        $hacer = "Agregar Usuario";
        break;
    case 'Actualizar':
        $style = "background-color: rgb(9, 109, 149)";
        $hacer = "Actualizar Usuario";
        break;
    default:
        # code...
        break;
}
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=usuarios" title="Ir a Usuarios">Usuarios</a>
    <a href="#" title="Estás justo aquí" class="active">Usuario</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>USUARIO</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=usuario&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $especialista['idEspecialista'] ?>">
                    <span>Id</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id"
                        value="<?= $especialista['idEspecialista'] ?>"<?= $status ?>>
                    <span>DNI</span>
                    <input required type="text" min="0" name="dni" value="<?= $especialista['dni'] ?>"<?= $status ?>>
                    <span>Nombre</span>
                    <input required type="text" name="nombre" value="<?= $especialista['nombre'] ?>"<?= $status ?>>
                    <span>Apellido</span>
                    <input required type="text" min="0" name="apellido" value="<?= $especialista['apellido'] ?>"<?= $status ?>>
                    <span>Dirección</span>
                    <input required type="text" min="0" name="direccion" value="<?= $especialista['direccion'] ?>"<?= $status ?>>
                    <span>Teléfono</span>
                    <input required type="text" min="0" name="telefono" value="<?= $especialista['telefono'] ?>"<?= $status ?>>
                    <span>Email</span>
                    <input required type="text" min="0" name="email" value="<?= $especialista['Email'] ?>"<?= $status ?>>
                    <span>Contraseña</span>
                    <input required type="password" min="0" name="contrasena" value=""<?= $status ?>>
                    <span>Estado</span>
                    <select name="estado" <?= $status ?> onchange="updateEstadoActual(this)">
                        <option value="1" <?= ($especialista['Estado'] == 1) ? 'selected' : '' ?>>Habilitado</option>
                        <option value="0" <?= ($especialista['Estado'] == 0) ? 'selected' : '' ?>>Inhabilitado</option>
                    </select>
                    <input type="text" name="estado_actual" id="estado_actual" value="<?= $especialista['Estado'] ?>">
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateEstadoActual(select) {
        document.getElementById("estado_actual").value = select.value;
    }
</script>