<?php
if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
    exit;
}

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

    $contrasenaActual = $_POST["passActual"];

    $contrasena = $_POST["contrasena"];
    if (is_null($contrasena)) {
        $contrasena = $contrasenaActual;
    } else {
        $contrasena = $_POST["contrasena"];
    }
    $estado = $_POST["estado"];
    $idUsuario = $_POST['idUsuario'];
    $email = $_POST["email"];
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
            $affectedRows = $dbEspecialistas->updateEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $estado);
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
            $botonView = 1;
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
            $tipo = "password";
            break;

        case 'update':
            $idEspecialista = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $botonView = 1;
            $especialista = $dbEspecialistas->selectEspecialista($idEspecialista);
            $tipo = "hidden";
            break;

        case 'delete':
            $idEspecialista = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $botonView = 1;
            $especialista = $dbEspecialistas->selectEspecialista($idEspecialista);
            break;
        case 'view':
            $idEspecialista = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
            $status = "disabled";
            $especialista = $dbEspecialistas->selectEspecialista($idEspecialista);
            $tipo = "hidden";
            break;
    }
}
?>

<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color: crimson";
        $hacer = "Eliminar Especialista";
        break;
    case 'Agregar':
        $style = "background-color: rgb(0, 176, 26)";
        $hacer = "Agregar Especialista";
        break;
    case 'Actualizar':
        $style = "background-color: rgb(9, 109, 149)";
        $hacer = "Actualizar Especialista";
        break;
    case 'Ver':
        $style = "";
        $hacer = "Ver Especialista";
        break;
    default:
        # code...
        break;
}
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=usuarios" title="Ir a Usuarios">Usuarios</a>
    <a href="#" title="Estás justo aquí" class="active">
        <?= $hacer ?>
    </a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>USUARIO</h3>
        <div class="numm">
            <div class="f1">
            </div>
            <div class="f2">
                <a href="?m=panel&mod=usuarioReset&id=<?= $especialista['idEspecialista'] ?>" class="button-link f-e">
                    <i class="abi bi bi-gear-wide-connected"></i><span>Cambiar contraseña</span>
                </a>
            </div>
        </div>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=usuario&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $especialista['idEspecialista'] ?>">
                    <b>Id</b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id"
                        value="<?= $especialista['idEspecialista'] ?>" <?= $status ?>>
                    <b>DNI</b>
                    <input required type="text" min="0" name="dni" value="<?= $especialista['dni'] ?>" <?= $status ?>>
                    <b>Nombre</b>
                    <input required type="text" name="nombre" value="<?= $especialista['nombre'] ?>" <?= $status ?>>
                    <b>Apellido</b>
                    <input required type="text" min="0" name="apellido" value="<?= $especialista['apellido'] ?>"
                        <?= $status ?>>
                    <b>Dirección</b>
                    <input required type="text" min="0" name="direccion" value="<?= $especialista['direccion'] ?>"
                        <?= $status ?>>
                    <b>Teléfono</b>
                    <input required type="text" min="0" name="telefono" value="<?= $especialista['telefono'] ?>"
                        <?= $status ?>>
                    <b>Email</b>
                    <input required type="text" min="0" name="email" value="<?= $especialista['Email'] ?>" <?= $status ?>>
                    <input required type="hidden" min="0" name="passActual" value="<?= $especialista['Contrasena'] ?>"
                        <?= $status ?>>
                    <b>Contrasena</b>
                    <input type="<?= $tipo ?>" name="contrasena">
                    <b>Estado</b>
                    <div class="custom-select">
                        <select name="estado" <?= $status ?> onchange="updateEstadoActual(this)">
                            <option value="1" <?= ($especialista['Estado'] == 1) ? 'selected' : '' ?>>Habilitado</option>
                            <option value="0" <?= ($especialista['Estado'] == 0) ? 'selected' : '' ?>>Inhabilitado</option>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></apan>
                            <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <input type="hidden" name="estado_actual" id="estado_actual" value="<?= $especialista['Estado'] ?>">
                    <br><br>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn ?></button>
                    <?php } ?>
                    <br><br>
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