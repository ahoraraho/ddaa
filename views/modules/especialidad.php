<?php
validacionIicioSesion();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbEspecialidades->InsertEspecialidad($nombre);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':

            $msj = "0x20";
            $affectedRows = $dbEspecialidades->updateEspecialidad($id, $nombre);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':

            $msj = "0x1000";
            if ($dbEspecialidades->deleteEspecialidad($id) > 0) {
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=Especialidades&msj=' . $msj);
} else {
    switch ($action) {
        case 'add':
            $maxid = $dbEspecialidades->MayorIdEspecialidad();
            foreach ($maxid as $iddd) {
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $especialidad = array(
                "idEspecialidad" => $id,
                "nombre" => ""
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $especialidad = $dbEspecialidades->selectEspecialidad($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $especialidad = $dbEspecialidades->selectEspecialidad($id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Especialidad";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Especialidad";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Especialidad";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=especialidades" title="Ir a Especialidades">Especialidades</a>
    <a href="#" title="Estás justo aquí" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>ESPECIALIDAD</h3>
        <div class="main">
            <div class="formm">

                <form action="?m=panel&mod=especialidad&action=<?= $action; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $especialidad["idEspecialidad"]; ?>">
                    <span> Id Especialidad </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="nombre" value="<?= $especialidad["idEspecialidad"]; ?>" <?= $status ?>>
                    <span> Nombre </span>
                    <input required type="text" name="nombre" value="<?= $especialidad["nombre"]; ?>" <?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>