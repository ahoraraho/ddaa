<?php
validacionIicioSesion();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Valido que tipo de peticion invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aca se deben procesar los datos del formulario ejecutado
    $id = $_POST["id"];
    $nombreEmpresa = $_POST["nombreEmpresa"];
    $ruc = $_POST["ruc"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $numeroPartida = $_POST["numeroPartida"];
    $mipe = $_POST["mipe"];

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbEmpresas->InsertEmpresa($nombreEmpresa,$ruc,$telefono,$email,$numeroPartida,$mipe);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':

            $msj = "0x20";
            $affectedRows = $dbEmpresas->UpdateEmpresa($id, $nombreEmpresa, $ruc, $telefono, $email, $numeroPartida, $mipe);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbEmpresas->DeleteEmpresa($id) > 0) {
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=empresas&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbEmpresas->MayorIdEmpresa();
            foreach ($maxid as $iddd) {
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $empresa = array(
                "idEmpresa" => $id,
                "nombreEmpresa" => "",
                "ruc" => "",
                "telefono" => "",
                "email" => "",
                "numeroPartida" => "",
                "mipe" => ""
            );
            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $empresa = $dbEmpresas->selectEmpresa($id);
            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $empresa = $dbEmpresas->selectEmpresa($id);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Empresa";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Empresa";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Empresa";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=empresas" title="Ir a Empresas">Empresas</a>
    <a href="#" title="Estas justo aqui" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>EMPRESA</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=empresa&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $empresa["idEmpresa"]; ?>">
                    <b> ID Empresa</b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $empresa["idEmpresa"] ?>" <?= $status ?>>
                    <b> Nombre Empresa</b>
                    <input required type="text" name="nombreEmpresa" value="<?= $empresa["nombreEmpresa"] ?>" <?= $status ?>>
                    <b> RUC </b>
                    <input required type="number" min="0" name="ruc" value="<?= $empresa["ruc"] ?>"<?= $status ?>>
                    <b> Telefono </b>
                    <input required type="number" min="0" name="telefono" value="<?= $empresa["telefono"] ?>"<?= $status ?>>
                    <b> Email </b>
                    <input required type="text" min="0" name="email" value="<?= $empresa["email"] ?>"<?= $status ?>>
                    <b> Numero de Partida </b>
                    <input required type="text" min="0" name="numeroPartida" value="<?= $empresa["numeroPartida"] ?>"<?= $status ?>>
                    <b> MIPE </b>
                    <input required type="text" min="0" name="mipe" value="<?= $empresa["mipe"] ?>"<?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
    <?php
    ?>
</div>
