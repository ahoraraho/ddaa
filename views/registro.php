<?php

$resultado = "";
$error = "";
$coo = "";

if (isset($_POST["registrar"])) {
	$check = isset($_POST['checkbox']) ? "checked" : "unchecked";

	if ($check == "checked") {
		$usuario = [
			"Nombre" => $_POST["nombre"],
			"Apellido" => $_POST["apellido"],
			"Direccion" => "",
			"Telefono" => $_POST["telefono"],
			"Email" => $_POST["email"],
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
		<h1 class="form_title">Sing Up</h1>
		<form action="" method="POST" class="form">
			<div class="form_group">
				<input type="text" id="nombre" name="nombre" class="form_input" placeholder=" " autocomplete="off" required autofocus>
				<label for="nombre" class="form_label"><i class="bi bi-person-lines-fill"></i><span>Name</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="text" id="apellido" name="apellido" class="form_input" placeholder=" " autocomplete="off" required>
				<label for="apellido" class="form_label"><i class="bi bi-credit-card-2-front"></i><span>last name</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="email" id="email" name="email" class="form_input" placeholder=" " autocomplete="off" required>
				<label for="email" class="form_label"><i class="bi bi-envelope"></i><span>Email</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="number" id="telefono" name="telefono" class="form_input" placeholder=" " autocomplete="off" required maxlength="9">
				<label for="telefono" class="form_label"><i class="bi bi-phone"></i><span>Telefono</span><sup>*</sup></label>
			</div>
			<div class="form_group">
				<input type="password" id="txtPassword" name="pass" class="form_input" placeholder=" " required>
				<label for="password" class="form_label form_label-pass"><i class="bi bi-shield-lock"></i><span>Password</span><sup>*</sup></label>
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
				<label class="control control-checkbox <?= $coo ?>"> I agree the <a target="_blank" href="?m=terminos">Terminos y condiciones </a>
					<input type="checkbox" id="checkbox" name="checkbox">
					<div class="control_indicator "></div>
				</label>
			</div>
			<button type="submit" name="registrar" id="registrar" class="form_singup-disabled">Login</button>
		</form><br>
		<a class="crear-cuenta" href="?m=ingreso">Registro</a>
	</div>

</div>