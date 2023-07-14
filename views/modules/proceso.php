<?php
validacionIicioSesion();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Validar qué tipo de petición invoca al módulo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí se deben procesar los datos del formulario ejecutado
    $numProceso = $_POST["numProceso"];
    $entidad = $_POST["entidad"];
    $nomenclatura = $_POST["nomenclatura"];
    $nombreClave = $_POST["nombreClave"];
    $consultas = $_POST["consultas"];
    $integracion = $_POST["integracion"];
    $presentacion = $_POST["presentacion"];
    $buenaPro = $_POST["buenaPro"];
    $valorReferencial = $_POST["valorReferencial"];
    $postores = $_POST["postores"];
    $encargado = $_POST["encargado"];
    $objeto = $_POST["objeto"];
    $observaciones = $_POST["observaciones"];

    switch ($action) {
        case 'add':
            $msj = "0x1000";
            $affectedRows = $dbProcesos->insertarProceso($entidad, $nomenclatura, $nombreClave, $consultas, $integracion, $presentacion, $buenaPro, $valorReferencial, $postores, $encargado, $objeto, $observaciones);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':
            $msj = "0x20";
            $affectedRows = $dbProcesos->updateProceso($numProceso, $entidad, $nomenclatura, $nombreClave, $consultas, $integracion, $presentacion, $buenaPro, $valorReferencial, $postores, $encargado, $objeto, $observaciones);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbProcesos->deleteProceso($numProceso) > 0) {
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=procesos&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            // Obtener el id mayor de la tabla procesos
            $maxid = $dbProcesos->MayorIdProceso();
            foreach ($maxid as $iddd) {
                $numProceso = $iddd["maxId"];
            }
            $numProceso = ($numProceso + 1);
            $btn = "Agregar";
            $status = null;
            $proceso = array(
                "numProceso" => $numProceso,
                "entidad" => "",
                "nomenclatura" => "",
                "nombreClave" => "",
                "consultas" => "",
                "integracion" => "",
                "presentacion" => "",
                "buenaPro" => "",
                "valorReferencial" => "",
                "postores" => "",
                "encargado" => "",
                "objeto" => "",
                "observaciones" => ""
            );
            $botonView = 1;
            break;

        case 'update':
            $numProceso = $_GET["id"];
            $botonView = 1;
            $btn = "Actualizar";
            $status = null;
            $proceso = $dbProcesos->selectProceso($numProceso);
            break;

        case 'delete':
            $numProceso = $_GET["id"];
            $botonView = 1;
            $btn = "Eliminar";
            $status = "disabled";
            $proceso = $dbProcesos->selectProceso($numProceso);
            break;
        case 'view':
            $numProceso = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
            $status = "disabled";
            $proceso = $dbProcesos->selectProceso($numProceso);
            break;
    }
}
?>

<?php
switch ($btn) {
    case 'Eliminar':
        $style = "btn-delete";
        $hacer = "Eliminar Proceso";
        break;
    case 'Agregar':
        $style = "btn-add";
        $hacer = "Agregar Proceso";
        break;
    case 'Actualizar':
        $style = "btn-update";
        $hacer = "Actualizar Proceso";
        break;
    case 'Ver':
        $style = "";
        $hacer = "Ver Proceso";
        break;
    default:
        # code...
        break;
}
?>


<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=procesos" title="Ir a Procesos">Procesos</a>
    <a href="#" title="Estas justo aqui" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Proceso</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=proceso&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="numProceso" value="<?= $proceso["numProceso"]; ?>">
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="numProceso" value="<?= $proceso['numProceso']; ?>" <?= $status ?>>

                    <b>Entidad</b>
                    <input required type="text" name="entidad" value="<?= $proceso["entidad"]; ?>" <?= $status ?>>

                    <b>Nomenclatura</b>
                    <input required type="text" name="nomenclatura" value="<?= $proceso["nomenclatura"]; ?>" <?= $status ?>>

                    <b>Nombre Clave</b>
                    <input required type="text" name="nombreClave" value="<?= $proceso["nombreClave"]; ?>" <?= $status ?>>

                    <b>Consultas</b>
                    <input required type="date" name="consultas" value="<?= $proceso["consultas"]; ?>" <?= $status ?>>

                    <b>Integración</b>
                    <input required type="date" name="integracion" value="<?= $proceso["integracion"]; ?>" <?= $status ?>>

                    <b>Presentación</b>
                    <input required type="date" name="presentacion" value="<?= $proceso["presentacion"]; ?>" <?= $status ?>>

                    <b>Buena Pro</b>
                    <input required type="date" name="buenaPro" value="<?= $proceso["buenaPro"]; ?>" <?= $status ?>>

                    <b>Valor Referencial S/.</b>
                    <input required type="number" name="valorReferencial" value="<?= $proceso["valorReferencial"]; ?>" <?= $status ?>>
                    <b>Postores</b>
                    <div class="custom-select">
                        <select name="postores" <?= $status ?>>
                            <option>Seleccionar una Empresa...</option>
                            <?php
                            $empresas = $dbEmpresas->selectEmpresas();
                            foreach ($empresas as $empresa) {
                                $idEmpresa = $empresa["idEmpresa"];
                                $nombre = $empresa["nombreEmpresa"];

                                $postor = $proceso["postores"]; ?>
                                <option value="<?= $idEmpresa ?>" <?= ($idEmpresa == $postor) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></apan> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <b>Encargado</b>
                    <div class="custom-select">
                        <select name="encargado" <?= $status ?>>
                            <option>Seleccionar un Encargado...</option>
                            <?php
                            $especialistas = $dbEspecialistas->selectEspecialistas();
                            foreach ($especialistas as $especialista) {
                                $idEspecialista = $especialista["idEspecialista"];
                                $nombre = $especialista["nombre"];

                                $encargado = $proceso["encargado"]; ?>
                                <option value="<?= $idEspecialista ?>" <?= ($idEspecialista == $encargado) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></span> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <b>Objeto</b>
                    <div class="custom-select">
                        <select name="objeto" <?= $status ?>>
                            <option><i>Seleccionar un Objeto...</i></option>
                            <?php
                            $objetos = $dbObjetos->selectObjetos();
                            foreach ($objetos as $objeto) {
                                $idObjeto = $objeto["idObjeto"];
                                $nombre = $objeto["nombre"];

                                $obje = $proceso["objeto"]; ?>
                                <option value="<?= $idObjeto ?>" <?= ($idObjeto == $obje) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></span> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <b>Observaciones</b>
                    <textarea required type="text" name="observaciones" value="" <?= $status ?>><?= $proceso["observaciones"]; ?></textarea>
                    <br><br>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" class="btn-actions <?= $style ?>"><?= $btn ?></button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>