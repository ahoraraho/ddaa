<?php
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
            break;

        case 'update':
            $numProceso = $_GET["id"];
            $btn = "Modificar";
            $status = null;
            $proceso = $dbProcesos->selectProceso($numProceso);
            break;

        case 'delete':
            $numProceso = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $proceso = $dbProcesos->selectProceso($numProceso);
            break;
    }
}
?>

<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Proceso";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Proceso";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Proceso";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>


<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas">Procesos</a>
    <a href="#" title="Estas justo aqui" class="active">Proceso</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>PROCESO</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=proceso&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="numProceso" value="<?= $proceso["numProceso"]; ?>">
                    
                    <span>Número de Proceso:</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="numProceso" value="<?= $proceso['numProceso']; ?>"<?= $status ?>>
                    
                    <span>Entidad:</span>
                    <input required type="text" name="entidad" value="<?= $proceso["entidad"]; ?>" <?= $status ?>>
                    
                    <span>Nomenclatura:</span>
                    <input required type="text" name="nomenclatura" value="<?= $proceso["nomenclatura"]; ?>"<?= $status ?>>
                    
                    <span>Nombre Clave:</span>
                    <input required type="text" name="nombreClave" value="<?= $proceso["nombreClave"]; ?>"<?= $status ?>>
                    
                    <span>Consultas:</span>
                    <input required type="text" placeholder="aaaa-mm-dd" name="consultas" value="<?= $proceso["consultas"]; ?>"<?= $status ?>>
                    
                    <span>Integración:</span>
                    <input required type="text" placeholder="aaaa-mm-dd" name="integracion" value="<?= $proceso["integracion"]; ?>"<?= $status ?>>
                    
                    <span>Presentación:</span>
                    <input required type="text" placeholder="aaaa-mm-dd" name="presentacion" value="<?= $proceso["presentacion"]; ?>"<?= $status ?>>
                    
                    <span>Buena Pro:</span>
                    <input required type="text" placeholder="aaaa-mm-dd" name="buenaPro" value="<?= $proceso["buenaPro"]; ?>"<?= $status ?>>
                    
                    <span>Valor Referencial:</span>
                    <input required type="text" name="valorReferencial" value="<?= $proceso["valorReferencial"]; ?>"<?= $status ?>>
                    
                    <span>Postores:</span>
                    <select name="postores" value="<?= $proceso["postores"]; ?>"<?= $status ?>>
                            <?php
                            $empresas = $dbEmpresas->selectEmpresas();
                            foreach ($empresas as $empresa) {
                                $selected = ($empresa["idObjeto"] == $proceso["postores"]) ? "selected" : ""; ?>
                                <option value="<?= $empresa["idEmpresa"] ?>" <?= $selected ?>><?= $empresa["nombreEmpresa"] ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    
                    <span>Encargado:</span>
                    <select name="encargado" value="<?= $proceso["encargado"]; ?>"<?= $status ?>>
                            <?php
                            $especialistas = $dbEspecialistas->selectEspecialistas();
                            foreach ($especialistas as $especialista) {
                                $selected = ($especialista["idEspecialista"] == $proceso["encargado"]) ? "selected" : ""; ?>
                                <option value="<?= $especialista["idEspecialista"] ?>" <?= $selected ?>><?= $especialista["nombre"] ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    
                    <span>Objeto:</span>
                    <select name="objeto" value="<?= $proceso["objeto"]; ?>"<?= $status ?>>
                            <?php
                            $objetos = $dbObjetos->selectObjetos();
                            foreach ($objetos as $objeto) {
                                $selected = ($objeto["idObjeto"] == $proceso["objeto"]) ? "selected" : ""; ?>
                                <option value="<?= $objeto["idObjeto"] ?>" <?= $selected ?>><?= $objeto["nombre"] ?></option>
                            <?php
                            }
                            ?>
                    </select>

                    <span>Observaciones:</span>
                    <input required type="text" name="observaciones" value="<?= $proceso["observaciones"]; ?>"<?= $status ?>>
                    
                    <br><br>
                    
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
