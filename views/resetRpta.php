<?php
$resetEmail = "use*****il.com";
if (isset($_POST['restaurar'])) {
    if (isset($_POST['email']) && isset($_POST['telefono'])) {
        $dataInput = array(
            "phone" => $_POST["telefono"],
            "mail" => $_POST["email"]
        );
        $exiss = $dbUsuarios->existMailUsuario($dataInput["mail"]); //USAMOS LA FUNCION
        if (!$exiss) {
            header('location: ?m=reset&mesage=noMail');
        }
        $dataUser = $dbUsuarios->validarEmail($dataInput["mail"]);
        $dataReset = array(
            "Id" => $dataUser["idUsuario"],
            "Rol" => $dataUser['rol']
        );

        $data = $dbUsuarios->recuperarDatos($dataReset);

        $_telefono = $data["Telefono"];
        $_email = $data["Email"];

        if ($dataInput["mail"] != $_email) {
            header('location: ?m=reset&mesage=noMailf');
        } elseif ($dataInput["phone"] != $_telefono) {
            header('location: ?m=reset&mesage=noPhone');
        } else {
            alertaResponDialog("msj-info", "Email encontrado!", "bi-check-circle");
            $mensaje = "Restaurar contraseña del siguiente correo electronico: " . $_email;
            $resetId = $dataReset["Id"];
            $resetEmail = $data["Email"];
        }
        //$esValidado = validarRestauracion($dataReset, $dataInput);
    }
}
if (isset($_POST['resetaPass'])) {
    if (isset($_POST['pass']) && isset($_POST['passOk'])) {
        $dir = array(
            "Id" => $_POST["id"],
            "Email" => $_POST["email"],
            "Pass" => $_POST["pass"],
            "PassOk" => $_POST["passOk"]
        );
        if ($dir["Pass"] == $dir["PassOk"]) {
            if ($dbUsuarios->ResetPassUsers($dir["Id"], $dir["Email"], $dir["PassOk"])) {
                $mensaje = null;
                header('location: ?m=ingreso&mesage=resetOk');
            }   
        } else {
            alertaResponDialog("msj-error", "Las contraseñas no coinciden",  "bi-exclamation-circle");
            $resetId = $dir["Id"];
            $resetEmail = $dir["Email"];
            //die("diefsafdfads.");
        }
    }
}

?>
<div class="conten">
    <div class="center-small">
        <h1 class="form_title">Restaurar contraseña</h1>
        <!-- <div class="notaReset">
            <p><?= $mensaje ?></p>
        </div> -->
        <form action="#" method="post" class="form">
            <input type="hidden" name="id" value="<?= $resetId ?>">
            <div class="form_group">
                <input type="email" id="email" name="email" class="form_input" value="<?= $resetEmail ?>" required disabled>
                <input type="hidden" name="email" value="<?= $resetEmail ?>">
                <label for="email" class="form_label"><i class="bi bi-envelope-paper"></i><span>Email</span><sup>*</sup></label>
            </div>
            <div class="form_group">
                <input type="password" id="txtPassword" name="pass" class="form_input" required autofocus>
                <label for="password" class="form_label form_label-pass"><i class="bi bi-shield-lock"></i><span>Nueva contraseña</span><sup>*</sup></label>
                <div class="eyePass">
                    <i id="iconoEye" class="bi bi-eye"></i>
                </div>
            </div>
            <div class="form_group">
                <input type="password" id="txtPasswordOk" name="passOk" class="form_input" required>
                <label for="password" class="form_label form_label-pass"><i class="bi bi-shield-lock"></i><span>Confirmar Nueva contraseña</span><sup>*</sup></label>
                <div class="eyePass">
                    <i id="iconoEyeOk" class="bi bi-eye"></i>
                </div>
            </div><br><br>
            <button type="submit" name="resetaPass" id="resetaPass" class="form_login">Restaurar contraseña</button>
        </form><br>
        <a class="crear-cuenta" href="?m=ingreso">ó, Iniciar Sesion</a><br>
    </div>
</div>