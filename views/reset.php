<?php

if (isset($_GET["mesage"])) {
    $mesage = $_GET["mesage"];
    switch ($mesage) {
        case 'noMail':
            alertaResponDialog("msj-error", "Correo no encontrado",  "bi-exclamation-circle");
            break;
        case 'noPhone';
            alertaResponDialog("msj-error", "Telefono no encontrado",  "bi-exclamation-circle");
            break;
        default:
            alertaResponDialog("msj-warning", "Algo salio mal", "bi-dash-circle");
            break;
    }
}

?>

<div class="conten">
    <div class="center-small">
        <h1 class="form_title">Recuperar cuenta</h1>
        <form action="?m=resetRpta" method="post" class="form">
            <div class="form_group">
                <input type="email" id="email" name="email" class="form_input" placeholder=" " required autofocus>
                <label for="email" class="form_label"><i class="bi bi-envelope-paper"></i><span>Email</span><sup>*</sup></label>
            </div>
            <div class="form_group">
				<input type="number" id="telefono" name="telefono" class="form_input" placeholder=" " autocomplete="off" required maxlength="9" >
				<label for="telefono" class="form_label"><i class="bi bi-phone"></i><span>Telefono</span><sup>*</sup></label>
			</div><br><br>
            <button type="submit" name="restaurar" id="restaurar" class="form_login">Validar datos</button>
        </form><br>
        <a class="crear-cuenta" href="?m=ingreso">ó, Iniciar Sesion</a><br>
    </div>
</div>