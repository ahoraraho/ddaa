<?php
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Validar qué tipo de petición invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí se deben procesar los datos del formulario ejecutado
    $idDocumento = $_POST["idDocumento"];
    $idProyecto = $_POST["idProyecto"];
    $acta_de_recepcion = $_POST["acta_de_recepcion"];
    $resolucion_de_obra = $_POST["resolucion_de_obra"];
    $resolucion_deductivos = $_POST["resolucion_deductivos"];
    $resolucion_adicionales = $_POST["resolucion_adicionales"];
    $anexo_de_promesa_de_consorcio = $_POST["anexo_de_promesa_de_consorcio"];
    $constancia = $_POST["constancia"];
    $contrato_de_consorcio = $_POST["contrato_de_consorcio"];
    $contrato = $_POST["contrato"];

    switch ($action) {
        case 'add':
            $msj = "0x1000";
            $affectedRows = $dbDocumentos->insertDocumento($idDocumento, $idProyecto, $nombre_proyecto, $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales, $anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':
            $msj = "0x20";
            $affectedRows = $dbDocumentos->updateDocumento($idDocumento, $idProyecto , $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales, $anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbDocumentos->deleteDocumento($idDocumento,$idProyecto) > 0) {
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=documentos&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            // Obtener el id mayor de la tabla documentos
            $maxid = $dbDocumentos->MayorDocumento();
            foreach ($maxid as $iddd) {
                $idDoc = $iddd["maxId"];
            }
            $idDoc = ($idDoc + 1);
            $btn = "Agregar";
            $status = null;
            $documento = array(
                "idDocumento" => $idDoc,
                "idDoc" => $idDoc,
                "idProyecto" => "",
                "acta_de_recepcion" => "",
                "resolucion_de_obra" => "",
                "resolucion_deductivos" => "",
                "resolucion_adicionales" => "",
                "anexo_de_promesa_de_consorcio" => "",
                "constancia" => "",
                "contrato_de_consorcio" => "",
                "contrato" => ""
            );
            break;

        case 'update':
            $idDoc = $_GET["idDocumento"];
            $btn = "Actualizar";
            $status = null;
            $documento = $dbDocumentos->selectDocumento($idDoc);
            break;

        case 'delete':
            $idDocumento = $_GET["idDocumento"];
            $btn = "Eliminar";
            $status = "disabled";
            $documento = $dbDocumentos->selectDocumento($idDocumento);
            break;
    }
}
?>

<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color: crimson";
        $styleImage = "display: none !important;";
        $hacer = "Eliminar Documento";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color: rgb(0, 176, 26)";
        $hacer = "Agregar Documento";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color: rgb(9, 109, 149)";
        $hacer = "Actualizar Documento";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=documentos" title="Ir a Marcas">Documentos</a>
    <a href="#" title="Estás justo aquí" class="active">Documento</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>DOCUMENTO</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=documento&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idDocumento" value="<?= $documento["idDocumento"]; ?>">
                    <span>ID Documento</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" value="<?= $documento["idDocumento"] ?>" <?= $status ?>>
                    <span>Nombre de Proyecto</span>
                    <select name="idProyecto" <?= $status ?>>
                        <?php
                        $proyectos = $dbProyectos->selectProyectos();
                        foreach ($proyectos as $proyecto) {
                            $selected = ($proyecto['idProyecto'] == $documento["idProyecto"]) ? "selected" : ""; ?>
                            <option value="<?= $proyecto['idProyecto'] ?>" <?= $selected ?>><?= $proyecto['nombre_proyecto']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span>Acta de Recepción</span>
                    <input required type="file" min="0" name="acta_de_recepcion" value="<?= $documento["acta_de_recepcion"] ?>" <?= $status ?>>
                    <span>Resolución de Obra</span>
                    <input required type="text" min="0" name="resolucion_de_obra" value="<?= $documento["resolucion_de_obra"] ?>" <?= $status ?>>
                    <span>Resolución de Deductivos</span>
                    <input required type="text" min="0" name="resolucion_deductivos" value="<?= $documento["resolucion_deductivos"] ?>" <?= $status ?>>
                    <span>Resolución Adicionales</span>
                    <input required type="text" min="0" name="resolucion_adicionales" value="<?= $documento["resolucion_adicionales"] ?>" <?= $status ?>>
                    <span>Anexo de Promesa de Consorcio</span>
                    <input required type="text" min="0" name="anexo_de_promesa_de_consorcio" value="<?= $documento["anexo_de_promesa_de_consorcio"] ?>" <?= $status ?>>
                    <span>Constancia</span>
                    <input required type="text" min="0" name="constancia" value="<?= $documento["constancia"] ?>" <?= $status ?>>
                    <span>Contrato de Consorcio</span>
                    <input required type="text" min="0" name="contrato_de_consorcio" value="<?= $documento["contrato_de_consorcio"] ?>" <?= $status ?>>
                    <span>Contrato</span>
                    <input required type="text" min="0" name="contrato" value="<?= $documento["contrato"] ?>" <?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
    <?php
    ?>
</div>
