<?php
$stylee = null;
$stylee2 = null;
// Valido que se haya iniciado sesión

if (!$_SESSION["Usuario"]) {
    header('location: ./');
    exit;
}
// recupero el id del usuario que inicio la sesion
$id = $_SESSION["Usuario"]["Id"];

// Valido que tipo de peticion invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $oldPass = $_POST["oldPass"];
    $newPass = $_POST["newPass"];
    $passOk = $_POST["passOk"];
    if (isset($_POST['resetPassUser'])) {
        $mj = "bug";
        if (!$dbUsuarios->validarPassReset($id, $email, $oldPass)) {
            $mj = "nul";
            //header('location: ?m=panel&mod=cuentaReset&msj=' . $mj);
            exit(header('location: ?m=panel&mod=cuentaReset&msj=' . $mj));
        } elseif ($newPass != $passOk) {
            $mj = "nok";
        } else {
            if ($dbUsuarios->ResetPassUsers($id, $email, $passOk)) {
                $mj = "okpas";
                exit(header('location: ?m=panel&mod=cuenta&msj=' . $mj));
            }
        }
        header('location: ?m=panel&mod=cuentaReset&msj=' . $mj);
    }
} else {
    $user = $dbUsuarios->SelectUsuario($id);
    $rol = $user["Rol"];
    $idCliente = $user["IdCliente"];
    $email = $user["Email"];
}
?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=cuenta" title="Ir al configuracion">Configuración</a>
    <a href="#" title="Estas justo aqui" class="active">Reset Pass</a>
</div>
<?php
if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
            // case 'ok':
            //     alertaResponDialog("msj-ok", "Contraseña actulizada", "bi-check-lg");
            //     break;
        case 'nok':
            alertaResponDialog("msj-error", "Las contraseñas no coinciden",  "bi-exclamation-circle");
            $stylee = null;
            $stylee2 = "box-shadow: red 0px 0px 1px 3px;";
            break;
        case 'nul':
            alertaResponDialog("msj-error", "La contraseña no es correcta",  "bi-exclamation-circle");
            $stylee = "box-shadow: red 0px 0px 1px 3px;";
            $stylee2 = null;
            break;
        case 'bug':
            alertaResponDialog("msj-alert", "Ocurrio un error",  "bi-exclamation-circle");
            break;
    }
    //alertaResponDialog($typeMsj, $msj, $iconoAlert);
}
?>
<div class="formularios">
    <div class="entradas">
        <h3>Cambio de contraseña</h3>
        <form action="?m=panel&mod=cuentaReset" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <!-- <input type="hidden" name="idCliente" value="<?= $idCliente ?>"> -->
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="rol" value="<?= $rol ?>">
            <div class="form_logueado">
                <i class="bi bi-envelope"></i><span>Email </span>
                <input type="email" id="email" name="email" class="m_form_input" value="<?= $_SESSION["Usuario"]["Email"] ?>" required disabled>
                <input type="hidden" name="email" value="<?= $_SESSION["Usuario"]["Email"] ?>">
            </div>
            <div class="form_logueado">
                <i class="bi bi-shield-lock"></i><span>Contraseña Actual </span>
                <input style="<?= $stylee ?>" type="password" id="txtPasswordOdl" name="oldPass" class="m_form_input" required autofocus>
                <div class="eyePass">
                    <i id="iconoEyeOdl" class="bi bi-eye"></i>
                </div>
            </div><br><br><br><br>
            <div class="form_logueado">
                <i class="bi bi-shield-lock"></i><span>Nueva contraseña </span>
                <input style="<?= $stylee2 ?>" type="password" id="txtPassword" name="newPass" class="m_form_input" required>
                <div class="eyePass">
                    <i id="iconoEye" class="bi bi-eye"></i>
                </div>
            </div>
            <div class="form_logueado">
                <i class="bi bi-shield-lock"></i><span>Confirmar contraseña </span>
                <input style="<?= $stylee2 ?>" type="password" id="txtPasswordOk" name="passOk" class="m_form_input" required>
                <div class="eyePass">
                    <i id="iconoEyeOk" class="bi bi-eye"></i>
                </div>
            </div><br><br>
            <button type="submit" name="resetPassUser" id="resetPassUser" class="form_login">Restaurar contraseña</button>
        </form><br>
    </div>
</div>