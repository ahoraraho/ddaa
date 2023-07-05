<?php
if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $idEspecialista=$_POST["idEspecialista"];
    $idUsuario = $_POST["idUsuario"];
    $email = $_POST["email"];
    $newPass = $_POST["newPass"];

    $msj = "0x1000";
    $affectedRows = $dbEspecialistas->updateContrasena($idUsuario, $email, $newPass);
    if ($affectedRows){
        $msj = "0x22";
    }
    header('location: ?m=panel&mod=usuarios&msj=' . $msj);
} else {
    $idEspecialista = $_GET["id"];
    $status = null;
    $especialista = $dbEspecialistas->selectEspecialista($idEspecialista);
}
?>

<?php
$style = "background-color: rgb(9, 109, 149)";
$hacer = "Actualizar contraseña";
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=usuarios" title="Ir a Usuarios">Usuarios</a>
    <a href="?m=panel&mod=usuario&action=update&id=<?= $id ?>" title="Ir a Usuario">Usuario</a>
    <a href="#" title="Estás justo aquí" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Cambiar contraseña</h3>
        <div class="main">
            <div class="form">
                <form action="?m=panel&mod=usuarioReset" method="POST">
                    <span>Id Especialista</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="idEspecialista" value="<?= $especialista['idEspecialista'] ?>" <?= $status ?>>
                    <input id="noEdid" title="No se puede modificar" disabled required type="hidden" name="idUsuario" value="<?= $especialista['idUsuario'] ?>" <?= $status ?>>
                    <input id="noEdid" title="No se puede modificar" disabled required type="hidden" name="email" value="<?= $especialista['Email'] ?>" <?= $status ?>>
                    
                    <input type="hidden" name="idEspecialista" value="<?= $especialista['idEspecialista'] ?>">
                    <input type="hidden" name="idUsuario" value="<?= $especialista['idUsuario'] ?>">
                    <input type="hidden" name="email" value="<?= $especialista['Email'] ?>">

                    <div class="form_logueado">
                        <b>Contraseña</b>
                        <input type="password" id="txtPassword" name="newPass" <?= $status ?>>
                        <div class="eyePass">
                            <i id="iconoEye" class="bi bi-eye"></i>
                        </div>
                    </div>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $hacer; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>