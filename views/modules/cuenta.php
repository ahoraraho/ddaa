<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Configuración</a>
</div>

<?php
validacionIicioSesion();

// recupero el id del usuario que inicio la sesion
$id = $_SESSION["Usuario"]["Id"];

// Valido que tipo de peticion invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aca se deben procesar los datos del formulario ejecutado
    $user = array(
        "Id" => $_POST["id"],
        "Rol" => $_POST["rol"],
        "IdCliente" => $_POST["idCliente"],
        "Nombre" => $_POST["nombre"],
        "Apellido" => $_POST["apellido"],
        "Cargo" => $_POST["cargo"],
        "Direccion" => $_POST["direccion"],
        "Telefono" => $_POST["telefono"],
        "Email" => $_POST["email"],
        "DNI" => $_POST["dni"]
    );
    if (isset($_POST['update'])) {
        $msj = "0x1000";
        if ($dbUsuarios->UpdateUsuario($user) > 0) {
            $msj = "ok";
            // reinicio sesión
            session_start();

            $_SESSION["Usuario"] = array(
                "Id" => $user["Id"],
                "IdCliente" => $user["IdCliente"],
                "Nombre" => $user["Nombre"],
                "Apellido" => $user["Apellido"],
                "Cargo" => $user["Cargo"],
                "Email" => $user["Email"],
                "Administrador" => $user['Rol']
            );
        }
        header('location: ?m=panel&mod=cuenta&msj=' . $msj);
    }
    if (isset($_POST['delete'])) {
        $msj = "dok";
        if ($dbUsuarios->DeleteUsuario($user) > 0) {
            //msj = "0x30";
            // cierro la sesión
            unset($_SESSION);
            session_destroy();
            header('location: ./');
        }
        header('location: ?m=panel&mod=cuenta&msj=' . $msj);
    }
} else {
    $user = $dbUsuarios->SelectUsuario($id);
    $rol = $user["Rol"];
    $idCliente = $user["IdCliente"];
    $nombre = $user["Nombre"];
    $apellido = $user["Apellido"];
    $cargo = $user["Cargo"];
    $direccion = $user["Direccion"];
    $telefono = $user["Telefono"];
    $email = $user["Email"];
    $dni = $user["DNI"];
}

if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
        case 'okpas':
            $msj = "Contraseña actualizada correctamente!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check-lg";
            break;
        case 'ok':
            $msj = "Cuenta actualizada correctamente!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check2-circle";
            break;
        case 'dok':
            $msj = "Hubo un error al intentar realizar la operación!";
            $typeMsj = "msj-error";
            $iconoAlert = "bi-bug";
            break;
        default:
            $msj = "No hubo modificaciones!";
            $typeMsj = "msj-error";
            $iconoAlert = "bi-bug";
            break;
    }
    alertaResponDialog($typeMsj, $msj, $iconoAlert);
}
?>

<div class="formularios">
    <div class="entradas">
        <h3>Configuración</h3>
        <div class="numm">
            <div class="f1">

            </div>
            <div class="f2">
                <a href="?m=panel&mod=cuentaReset" class="button-link f-e">
                    <i class="abi bi bi-gear-wide-connected"></i><span>Cambiar contraseña</span>
                </a>
            </div>
        </div>
        <form action="?m=panel&mod=cuenta" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="rol" value="<?= $rol ?>">
            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
            <input type="hidden" name="email" value="<?= $email ?>">
            <?php if ($rol == 0) { ?>
                <div>
                    <i class="bi bi-person-vcard"></i><span>DNI </span>
                    <input type="number" name="dni" value="<?= $dni ?>">
                </div>
            <?php } ?>
            <div>
                <i class="bi bi-person-lines-fill"></i></i><span>Nombre </span>
                <input type="text" name="nombre" value="<?= $nombre ?>">
            </div>
            <div>
                <i class="bi bi-credit-card-2-front"></i><span>Apellido </span>
                <input type="text" name="apellido" value="<?= $apellido ?>">
            </div>
            <div>
                <i class="bi bi-phone"></i><span>Celular </span>
                <input type="text" name="telefono" value="<?= $telefono ?>">
            </div>
            <div>
                <i class="bi bi-envelope"></i><span>Email </span>
                <input type="email" name="email" value="<?= $email ?>">
            </div>
            <div>
                <i class="bi bi-pin-map"></i><span>Dirección </span>
                <input type="text" name="direccion" value="<?= $direccion ?>">
            </div>
            <div>
                <i class="bi bi-building"></i><span>Cargo </span>
                <input type="text" name="cargo" value="<?= $cargo ?>">
            </div>
            <div><br><br>
                <button type="submit" name="update" id="actualizar" class="btn-actions btn-update">Modificar y guardar cambios</button>
            </div><br>
            <?php if ($rol == 0) { ?>
                <div>
                    <button type="submit" name="delete" id="eliminar-cuenta" class="btn-actions btn-delete">Eliminar cuenta</button>
                </div><br><br>
            <?php } ?>
        </form><br>
        <div class="numm">
            <div class="f1">

            </div>
            <div class="f2">
                <a href="?m=panel&sesion=cerrar"" class=" button-link f-e">
                    <i class="abi bi bi-power"></i><span>Cerrar Sesión</span>
                </a>
            </div>
        </div><br><br>
    </div>

</div>