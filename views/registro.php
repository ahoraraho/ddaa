<?php

$resultado = "";
$error = "";
$coo = "";

if (isset($_POST["registrar"])) {
	$check = isset($_POST['checkbox']) ? "checked" : "unchecked";

	if ($check == "checked") {
		$usuario = [
			"DNI" => $_POST["dni"],
			"Nombre" => $_POST["nombre"],
			"Apellido" => $_POST["apellido"],
			"Email" => $_POST["email"],
			"Telefono" => $_POST["telefono"],
			"Direccion" => $_POST["direccion"],
			"Cargo" => "Especialista",
			"Pass" => $_POST["pass"],
		];

		if (!$dbUsuarios->existMailUsuario($_POST["email"])) {
			if ($dbUsuarios->insertUsuario(0, $usuario)) {
				// insertado correctamente
				header('Location: ?m=ingreso&mesage=ok');
			} else {
				// error!!
				$error = "Ups! Error de conexión. Por favor reintente en unos instantes";
			}
		} else {
			// mail ya existe
			header('Location: ?m=ingreso&mesage=nok');
		}
	} else {
		$error = "Tiene que aceptar los términos y condiciones";
		alertaResponDialog("msj-error", "Deve de aceptar los terminos", "bi-slash-circle");
	}
}

?>
<div class="conten">
	<div class="center-small">
		<h1 class="form_title">Registro Especialista</h1>
		<form action="" method="POST" class="form">
			<div class="form_group">
				<input type="number" id="dni" name="dni" class="form_input" placeholder=" " autocomplete="off" required autofocus>
				<label for="dni" class="form_label"><i class="bi bi-person-vcard"></i><span>DNI</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="text" id="nombre" name="nombre" class="form_input" placeholder=" " autocomplete="off" required >
				<label for="nombre" class="form_label"><i class="bi bi-person-lines-fill"></i><span>Nombre</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="text" id="apellido" name="apellido" class="form_input" placeholder=" " autocomplete="off" required>
				<label for="apellido" class="form_label"><i class="bi bi-credit-card-2-front"></i><span>Apellido</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="email" id="email" name="email" class="form_input" placeholder=" " autocomplete="off" required>
				<label for="email" class="form_label"><i class="bi bi-envelope"></i><span>Correo</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="number" id="telefono" name="telefono" class="form_input" placeholder=" " autocomplete="off" required maxlength="9">
				<label for="telefono" class="form_label"><i class="bi bi-phone"></i><span>Celular</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="text" id="direccion" name="direccion" class="form_input" placeholder=" " autocomplete="off" required>
				<label for="direccion" class="form_label"><i class="bi bi-pin-map"></i><span>Direccion</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="password" id="txtPassword" name="pass" class="form_input" placeholder=" " required>
				<label for="password" class="form_label form_label-pass"><i class="bi bi-shield-lock"></i><span>Contraseña</span><sup>*</sup></label>
				<div class="eyePass">
					<i id="iconoEye" class="bi bi-eye"></i>
				</div>
			</div>
			<div class="form_guardar-cuenta">
				<?php
				if ($error) {
					echo "<div class='error'>" . $error . "</div>";
					$coo = "errorAll";
				}
				if ($resultado) {
					$coo = "null";
					echo "<div class='resultado'>" . $resultado . "</div>";
				}
				?>
				<label class="control control-checkbox <?= $coo ?>"> Acepto los  <a target="_blank" href="?m=terminos">Terminos y condiciones </a>
					<input type="checkbox" id="checkbox" name="checkbox">
					<div class="control_indicator "></div>
				</label>
			</div>
			<button type="submit" name="registrar" id="registrar" class="form_singup-disabled">Registrarse</button>
		</form><br>
		<a class="crear-cuenta" href="?m=ingreso">Iniciar Sesion</a>
	</div>

</div>