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
            $affectedRows = $dbDocumentos->updateDocumento($idDocumento, $idProyecto, $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales, $anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbDocumentos->deleteDocumento($idDocumento, $idProyecto) > 0) {
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
                    <!-- <div class="contenido-tabla"> -->
                    <table class="tabla-responsive">
                        <thead>
                            <tr>
                                <th style="text-align: start;"></th>
                                <th style="width: 150px;"></th>
                                <th style="width: 5px;"></th>
                                <th style="width: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody style="text-align: star;">
                            <?php
                            // $documento = $dbDocumentos->selectDocumento();

                            // $id = $documento['idDocumento'];
                            // $nom_proyecto = $documento['nombre_proyecto'];
                            // $acta_de_recepcion = $documento['acta_de_recepcion'];
                            // $resolucion_de_obra = $documento['resolucion_de_obra'];
                            // $resolucion_deductivos = $documento['resolucion_deductivos'];
                            // $resolucion_adicionales = $documento['resolucion_adicionales'];
                            // $anexo_de_promesa_de_consorcio = $documento['anexo_de_promesa_de_consorcio'];
                            // $constancia = $documento['constancia'];
                            // $contrato_de_consorcio = $documento['contrato_de_consorcio'];
                            // $contrato = $documento['contrato'];

                            $id = 1;
                            $nom_proyecto = "nfodo";
                            $acta_de_recepcion = "fasdf.pdf";
                            $resolucion_de_obra = "fjkljoi.pdf";
                            $resolucion_deductivos = "mecanismos.pdf";
                            $resolucion_adicionales = "cero.pdf";
                            $anexo_de_promesa_de_consorcio = null;
                            $constancia = null;
                            $contrato_de_consorcio = null;
                            $contrato = null;
                            ?>
                            <tr>
                                <td>Acta de Recepcion</td>
                                <td>
                                    <!-- <input id="achivo-1" type="file" name="acta_de_recepcion">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-1" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                    </div> -->
                                    <input id="archivo-1" type="file" min="0" name="resolucion_de_obra">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-1" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $acta_de_recepcion ?>" class="btn-action-doc" <?= $status ?>>
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $acta_de_recepcion ?>" class="btn-action-doc" <?= $status ?>>
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Resolución de Obra</td>
                                <td>
                                    <input id="archivo-2" type="file" min="0" name="resolucion_de_obra">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-2" name="addPdf-2" id="addPdf-2">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $resolucion_de_obra ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $resolucion_de_obra ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Resolución de Deductivos</td>
                                <td>
                                    <input id="archivo-3" type="file" min="0" name="resolucion_deductivos">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-3" name="addPdf-3" id="addPdf-3">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $resolucion_deductivos ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $resolucion_deductivos ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Resolución Adicionales</td>
                                <td>
                                    <input id="archivo-4" type="file" min="0" name="resolucion_adicionales">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-4" name="addPdf-4" id="addPdf-4">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $resolucion_adicionales ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $resolucion_adicionales ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Anexo de Promesa de Consorcio</td>
                                <td>
                                    <input id="archivo-5" type="file" min="0" name="anexo_de_promesa_de_consorcio">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-5" name="addPdf-5" id="addPdf-5">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $anexo_de_promesa_de_consorcio ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $anexo_de_promesa_de_consorcio ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Acta de Recepcion</td>
                                <td>
                                    <input id="archivo-6" type="file" min="0" name="acta_de_recepcion">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-6" name="addPdf-6" id="addPdf-6">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $acta_de_recepcion ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $acta_de_recepcion ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Constancia</td>
                                <td>
                                    <input id="archivo-7" type="file" min="0" name="constancia">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-7" name="addPdf-7" id="addPdf-7">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $constancia ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $constancia ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Contrato de Consorcio</td>
                                <td>
                                    <input id="archivo-8" type="file" min="0" name="contrato_de_consorcio">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-8" name="addPdf-8" id="addPdf-8">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $contrato_de_consorcio ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $contrato_de_consorcio ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Contrato</td>
                                <td>
                                    <input id="archivo-9" type="file" min="0" name="contrato" ?>
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-9" name="addPdf-9" id="addPdf-9">Cargar PDF</label>
                                    </div>
                                </td>
                                <td>
                                    <a title="Descargar" href="?m=actuall&file=<?= $contrato ?>" class="btn-action-doc">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                                <td>
                                    <a title="Ver" target="_blank" href="files/<?= $contrato ?>" class="btn-action-doc">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <!-- <span>Acta de Recepción</span>
                    <input required type="file" min="0" name="acta_de_recepcion" value="<?= $documento["acta_de_recepcion"] ?>" <?= $status ?>>
                    <span>Resolución de Obra</span>
                    <input required type="file" min="0" name="resolucion_de_obra" value="<?= $documento["resolucion_de_obra"] ?>" <?= $status ?>>
                    <span>Resolución de Deductivos</span>
                    <input required type="file" min="0" name="resolucion_deductivos" value="<?= $documento["resolucion_deductivos"] ?>" <?= $status ?>>
                    <span>Resolución Adicionales</span>
                    <input required type="file" min="0" name="resolucion_adicionales" value="<?= $documento["resolucion_adicionales"] ?>" <?= $status ?>>
                    <span>Anexo de Promesa de Consorcio</span>
                    <input required type="file" min="0" name="anexo_de_promesa_de_consorcio" value="<?= $documento["anexo_de_promesa_de_consorcio"] ?>" <?= $status ?>>
                    <span>Constancia</span>
                    <input required type="file" min="0" name="constancia" value="<?= $documento["constancia"] ?>" <?= $status ?>>
                    <span>Contrato de Consorcio</span>
                    <input required type="file" min="0" name="contrato_de_consorcio" value="<?= $documento["contrato_de_consorcio"] ?>" <?= $status ?>>
                    <span>Contrato</span>
                    <input required type="file" min="0" name="contrato" value="<?= $documento["contrato"] ?>" <?= $status ?>>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button> -->
            </form>
        </div>
    </div>
</div>
<?php
?>
</div>