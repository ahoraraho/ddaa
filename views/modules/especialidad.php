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
            $botonView = 1;
            break;

        case 'update':
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Actualizar";
            $status = null;
            $especialidad = $dbEspecialidades->selectEspecialidad($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Eliminar";
            $status = "disabled";
            $especialidad = $dbEspecialidades->selectEspecialidad($id);
            break;
        case 'view':
            $id = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
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
        $hacer = "Eliminar Especialidad";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Especialidad";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Especialidad";
        break;
    case 'Ver':
        $style = "";
        $hacer = "Ver Especialidad";
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
                    <b> Id Especialidad </b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="nombre" value="<?= $especialidad["idEspecialidad"]; ?>" <?= $status ?>>
                    <b> Nombre </b>
                    <input required type="text" name="nombre" value="<?= $especialidad["nombre"]; ?>" <?= $status ?>>
                    <br><br>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn ?></button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>