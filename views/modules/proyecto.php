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
    $idProyecto = $_POST["idProyecto"];
    $nombre_empresa = $_POST["nombreEmpresa"];
    $nombre_proyecto = $_POST["nombreProyecto"];
    $numero_contrato = $_POST["numeroContrato"];
    $entidad = $_POST["entidad"];
    $fecha_firma = $_POST["fechaFirma"];
    $monto_contrato_original = $_POST["montoContratoOriginal"];
    $porcentaje_de_participacion = $_POST["porcentajeParticipacion"];
    $adicionales_de_la_obra = $_POST["adicionalesObra"];
    $deductivos_de_obra = $_POST["deductivosObra"];
    $monto_final_del_contrato = $_POST["montoFinalContrato"];
    $miembro_del_consorcio = $_POST["miembroConsorcio"];
    $observaciones = $_POST["observaciones"];
    $contacto = $_POST["contacto"];
    $objeto = $_POST["objeto"];
    $especialidad = $_POST["especialidad"];

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbProyectos->InsertProyecto($nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad);
            if ($affectedRows > 0) {
                $msj = "0x10";
            }
            break;

        case 'update':
            $msj = "0x20";
            $affectedRows = $dbProyectos->updateProyecto($idProyecto, $nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x1000";
            if ($dbProyectos->deleteProyecto($idProyecto) > 0) {
                //unlink("img/productos/" . $imagenActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=proyectos&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbProyectos->MayorIdProyecto();
            foreach ($maxid as $iddd) {
                $idProyecto = $iddd["maxId"];
            }
            $idProyecto = ($idProyecto + 1);
            $btn = "Agregar";
            $status = null;
            $proyecto = array(
                "idProyecto" => $idProyecto,
                "nombre_empresa" => "",
                "nombre_proyecto" => "",
                "numero_contrato" => "",
                "entidad" => "",
                "fecha_firma" => "",
                "monto_contrato_original" => "",
                "porcentaje_de_participacion" => "",
                "adicionales_de_la_obra" => "",
                "deductivos_de_obra" => "",
                "monto_final_del_contrato" => "",
                "miembro_del_consorcio" => "",
                "observaciones" => "",
                "contacto" => "",
                "objeto" => "",
                "especialidad" => ""
            );
            break;

        case 'update':
            $idProyecto = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $proyecto = $dbProyectos->selectProyecto($idProyecto);
            break;

        case 'delete':
            $idProyecto = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $proyecto = $dbProyectos->selectProyecto($idProyecto);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Proyecto";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Proyecto";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Proyecto";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=proyectos" title="Ir a Proyectos">Proyectos</a>
    <a href="#" title="Estás aquí" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>PROYECTO</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=proyecto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idProyecto" value="<?= $proyecto["idProyecto"]; ?>">
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="idProyecto" value="<?= $proyecto["idProyecto"]; ?>" <?= $status ?>>
                    <b> Nombre Empresa </b>
                    <div class="custom-select">
                        <select name="nombreEmpresa" <?= $status ?>>
                            <option>Seleccionar una Empresa...</option>
                            <?php
                            $empresas = $dbEmpresas->selectEmpresas();
                            foreach ($empresas as $empresa) {
                                $idEmpresa = $empresa["idEmpresa"];
                                $nombre = $empresa["nombreEmpresa"];
                                $empres = $proyecto["nombre_empresa"]; ?>
                                <option value="<?= $idEmpresa ?>" <?= ($idEmpresa == $empres) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></apan> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <b> Nombre Proyecto </b>
                    <input required type="text" name="nombreProyecto" value="<?= $proyecto["nombre_proyecto"]; ?>" <?= $status ?>>
                    <b> Número de Contrato </b>
                    <input required type="text" name="numeroContrato" value="<?= $proyecto["numero_contrato"]; ?>" <?= $status ?>>
                    <b> Entidad </b>
                    <input required type="text" name="entidad" value="<?= $proyecto["entidad"]; ?>" <?= $status ?>>
                    <b> Fecha de Firma </b>
                    <input required type="text" placeholder="aaaa-mm-dd" name="fechaFirma" value="<?= $proyecto["fecha_firma"]; ?>" <?= $status ?>>
                    <b> Monto Contrato Original </b>
                    <input required type="text" name="montoContratoOriginal" value="<?= $proyecto["monto_contrato_original"]; ?>" <?= $status ?>>
                    <b> Porcentaje de Participación </b>
                    <input required type="text" name="porcentajeParticipacion" value="<?= $proyecto["porcentaje_de_participacion"]; ?>" <?= $status ?>>
                    <b> Adicionales de la Obra </b>
                    <input required type="text" name="adicionalesObra" value="<?= $proyecto["adicionales_de_la_obra"]; ?>" <?= $status ?>>
                    <b> Deductivos de Obra </b>
                    <input required type="text" name="deductivosObra" value="<?= $proyecto["deductivos_de_obra"]; ?>" <?= $status ?>>
                    <b> Monto Final del Contrato </b>
                    <input required type="text" name="montoFinalContrato" value="<?= $proyecto["monto_final_del_contrato"]; ?>" <?= $status ?>>
                    <b> Miembro del Consorcio </b>
                    <input required type="text" name="miembroConsorcio" value="<?= $proyecto["miembro_del_consorcio"]; ?>" <?= $status ?>>
                    <b> Observaciones </b>
                    <input required type="text" name="observaciones" value="<?= $proyecto["observaciones"]; ?>" <?= $status ?>>
                    <b> Contacto </b>
                    <div class="custom-select">
                        <select name="contacto" <?= $status ?>>
                            <option><i>Seleccionar un Contacto...</i></option>
                            <?php
                            $contactos = $dbContactos->selectContactos();
                            foreach ($contactos as $contacto) {
                                $idContacto = $contacto["idContacto"];
                                $nombre = $contacto["nombre"];
                                $contac = $proyecto["contacto"]; ?>
                                <option value="<?= $idContacto ?>" <?= ($idContacto == $contac) ? "selected" : null ?>><?= $nombre ?></option>
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
                                $obje = $proyecto["objeto"]; ?>
                                <option value="<?= $idObjeto ?>" <?= ($idObjeto == $obje) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></span> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <b> Especialidad </b>
                    <div class="custom-select">
                        <select name="especialidad" <?= $status ?>>
                            <option><i>Seleccionar una Especialidad...</i></option>
                            <?php
                            $especialidades = $dbEspecialidades->selectEspecialidades();
                            foreach ($especialidades as $especialidad) {
                                $idEspecialidad = $especialidad["idEspecialidad"];
                                $nombre = $especialidad["nombre"];
                                $especial = $proyecto["especialidad"]; ?>
                                <option value="<?= $idEspecialidad ?>" <?= ($idEspecialidad == $especial) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></span> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>

                    <div class="contenedor_pdf">
                        <!-- <div class="contenido-tabla"> -->
                        <table class="tabla-responsive">
                            <!-- <thead>
                            <tr>
                                <th style="text-align: start;"></th>
                                <th style="width: 150px;"></th>
                                <th style="width: 5px;"></th>
                                <th style="width: 10px;"></th>
                            </tr>
                        </thead> -->
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
                                    <td class="description">Acta de Recepcion</td>
                                    <td>
                                        <!-- <input id="achivo-1" type="file" name="acta_de_recepcion">
                                    <div class="btn-add-pdf">
                                        <label title="Carcar archivo PDF" for="archivo-1" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                    </div> -->
                                        <input id="archivo-1" type="file" min="0" name="resolucion_de_obra" accept=".pdf">
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
                                    <td class="description">Resolución de Obra</td>
                                    <td>
                                        <input id="archivo-2" type="file" min="0" name="resolucion_de_obra" accept=".pdf">
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
                                    <td class="description">Resolución de Deductivos</td>
                                    <td>
                                        <input id="archivo-3" type="file" min="0" name="resolucion_deductivos" accept=".pdf">
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
                                    <td class="description">Resolución Adicionales</td>
                                    <td>
                                        <input id="archivo-4" type="file" min="0" name="resolucion_adicionales" accept=".pdf">
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
                                    <td class="description">Anexo de Promesa de Consorcio</td>
                                    <td>
                                        <input id="archivo-5" type="file" min="0" name="anexo_de_promesa_de_consorcio" accept=".pdf">
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
                                    <td class="description">Constancia</td>
                                    <td>
                                        <input id="archivo-7" type="file" min="0" name="constancia" accept=".pdf">
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
                                    <td class="description">Contrato de Consorcio</td>
                                    <td>
                                        <input id="archivo-8" type="file" min="0" name="contrato_de_consorcio" accept=".pdf">
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
                                    <td class="description">Contrato</td>
                                    <td>
                                        <input id="archivo-9" type="file" min="0" name="contrato" accept=".pdf">
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
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>