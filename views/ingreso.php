<?php
// Verificar si la sesión está abierta y redirigir al módulo de proyectos si es un administrador
if (isset($_SESSION["Usuario"]) && $_SESSION["Usuario"]["Administrador"] == 1) {
	header('location: ?m=panel&mod=proyectos');
	exit;
}

$stylee = null;
$stylee2 = null;
$email = "";
$focus = "autofocus";
$focus2 = null;

// Mostrar mensajes de respuesta según los parámetros GET
if (isset($_GET["mesage"])) {
	$mesage = $_GET["mesage"];
	switch ($mesage) {
		case 'ok':
			alertaResponDialog("msj-ok", "Gracias por registrarte, Bienvenido!", "bi-check-lg");
			break;
		case 'nok':
			alertaResponDialog("msj-warning", "Ya existe una cuenta con ese email", "bi-exclamation-diamond");
			break;
		case 'resetOk':
			alertaResponDialog("msj-ok", "Cuenta restaurada correctamente", "bi-check2-all");
			break;
		default:
			alertaResponDialog("msj-warning", "Algo salió mal", "bi-dash-circle");
			break;
	}
}

// Procesar el formulario de inicio de sesión
if (isset($_POST['login'])) {
	if (!empty($_POST['email']) && !empty($_POST['pass'])) {
		$email = $_POST['email'];
		$pass = $_POST["pass"];
		$usuario = $dbUsuarios->loginUsuario($email);
		$verifiPass = $dbUsuarios->verificarPass($email, $pass);

		if (!$usuario) {
			alertaResponDialog("msj-error", "Email no encontrado", "bi-exclamation-octagon");
			$email = "";
			$stylee = "box-shadow: red 0px 0px 1px 2px;";
			$stylee2 = null;
			$focus = "autofocus";
			$focus2 = null;
		} elseif (!$verifiPass) {
			alertaResponDialog("msj-error", "Contraseña incorrecta", "bi-exclamation-triangle");
			$stylee2 = "box-shadow: red 0px 0px 1px 2px;";
			$stylee = null;
			$email = $_POST['email'];
			$focus = null;
			$focus2 = "autofocus";
		}

		if ($usuario && $verifiPass) {
			// Acceso correcto, iniciar sesión
			session_start();
			$_SESSION["Usuario"] = array(
				"Id" => $usuario["idUsuario"],
				"Nombre" => $usuario["Nombre"],
				"Apellido" => $usuario["Apellido"],
				"Email" => $usuario["Email"],
				"Administrador" => $usuario['Rol']
			);
			if ($usuario['Rol']) {
				header("location: ?m=panel&mod=proyectos");
			} else {
				header("location: ?m=panel&mod=empresas");
			}
			exit;
		}
	} else {
		alertaResponDialog("msj-warning", "Ningún campo puede estar vacío", "bi-info-circle");
	}
}
?>

<div class="conten">
	<div class="center-small">
		<img class="logo_login" src="svgs/logo_gold.svg" alt=""><br>
		<!-- <img class="logo_login-da" src="svgs/logo_dyaa-black.svg" alt=""> -->
		<h1 class="form_title">Inicio de sesión</h1>
		<form action="" method="POST" class="form">
			<div class="form_group">
				<input style="<?= $stylee ?>" type="email" id="email" name="email" class="form_input" placeholder=" " value="<?= $email ?>" required <?= $focus ?>>
				<label for="email" class="form_label"><i class="bi bi-envelope-paper"></i><span>Email</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input style="<?= $stylee2 ?>" type="password" id="txtPassword" name="pass" class="form_input" placeholder=" " required <?= $focus2 ?>>
				<label for="password" class="form_label form_label-pass"><i class="bi bi-shield-lock"></i><span>Contraseña</span><sup>*</sup></label>
				<div class="eyePass">
					<i id="iconoEye" class="bi bi-eye"></i>
				</div>
			</div><br>
			<!-- <div class="form_guardar-cuenta">
					<label class="control control-checkbox"> Mantener la sesion
						<input type="checkbox" name="recordar" onclick="" />
						<div class="control_indicator"></div>
					</label>
        		</div> -->
			<button name="login" class="form_login">Ingresar</button>
		</form><br>
		<!-- <a class="crear-cuenta" href="?m=reset">¿Olvidaste tu contraseña?</a> -->
		<p class="nuevo-usuario">¿No tienes una cuenta?</p>
		<a href="?m=registro"><button class="form_singup">Registrate</button></a>
	</div>
</div>