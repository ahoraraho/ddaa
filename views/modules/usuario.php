<?php
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Validar qué tipo de petición invoca al módulo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos del formulario ejecutado
    $id = $_POST["id"];
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $contrasena = $_POST["constrasena"];
    $estado = $_POST["estado"];
    $idEspecialista = $_POST['id'];

    switch ($action) {
        case 'add':
            $msj = "0x1000";
            $affectedRows = $dbEspecialistas->insertEspecialista($dni, $nombre, $apellido, $cargo, $direccion, $telefono, $email, $contrasena, $activacion, $idEspecialista);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':
            $msj = "0x20";
            $affectedRows = $dbEspecialistas->updateEspecialista($id, $dni, $nombre, $apellido, $cargo, $direccion, $telefono, $email, $contrasena, $activacion);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbEspecialistas->deleteEspecialista($id) > 0) {
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=empresas&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            // Obtener el id mayor de la tabla especialista
            $maxid = $dbEspecialistas->MayorIdEspecialista();
            foreach ($maxid as $iddd) {
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $especialista = array(
                "idEspecialista"=>$id,
                "dni" => "",
                "nombre" => "",
                "apellido" => "",
                "direccion" => "",
                "telefono" => "",
                "Email" => "",
                "Contrasena" => "",
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $especialista = $dbEspecialistas->selectEspecialista($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $especialista = $dbEspecialistas->selectEspecialista($id);
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
                <form action="?m=panel&mod=usuarios&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <span>Id</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="idEspecialista" value="<?= intval($especialista['idEspecialista']) ?>">
                    <span>DNI</span>
                    <input required type="text" min="0" name="dni" value="<?= $especialista['dni'] ?>">
                    <span>Nombre</span>
                    <input required type="text" name="nombre" value="<?= $especialista['nombre'] ?>">
                    <span>Apellido</span>
                    <input required type="text" min="0" name="apellido" value="<?= $especialista['apellido'] ?>">
                    <span>Dirección</span>
                    <input required type="text" min="0" name="direccion" value="<?= $especialista['direccion'] ?>">
                    <span>Teléfono</span>
                    <input required type="text" min="0" name="telefono" value="<?= $especialista['telefono'] ?>">
                    <span>Email</span>
                    <input required type="text" min="0" name="email" value="<?= $especialista['Email'] ?>">
                    <span>Contraseña</span>
                    <input required type="password" min="0" name="constrasena" value="<?= $especialista['Contrasena'] ?>">
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
