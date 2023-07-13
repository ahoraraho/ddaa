<?php
validacionIicioSesion();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// descarga el archivo
if (isset($_GET['file'])) {
    $cod = $_GET['cod'];
    $archivo = $_GET['file'];

    $ruta_archivo = "pdfsProyectos/files" . $cod . "/" . $archivo;

    // Verificar que el archivo exista en el servidor
    if (file_exists($ruta_archivo)) {
        // Enviar el archivo al navegador// Descargar archivo PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');

        readfile($ruta_archivo);
    } else {
        $msj = "El archivo no existe en el servidor.";
        $typeMsj = "msj-error";
        $iconoAlert = "bi-bug";
        alertaResponDialog($typeMsj, $msj, $iconoAlert);
    }
}

// Valido que tipo de peticion invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aca se deben procesar los datos del formulario ejecutado
    $id = $_POST["idProyecto"];
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

    //REGISTROS DE LA TABLA ARCHIVOS DE PROYECTOS
    $archivos = [
        "acta_de_recepcion" => $_FILES["acta_de_recepcion"],
        "resolucion_de_obra" => $_FILES["resolucion_de_obra"],
        "resolucion_deductivos" => $_FILES["resolucion_deductivos"],
        "resolucion_adicionales" => $_FILES["resolucion_adicionales"],
        "anexo_de_promesa_de_consorcio" => $_FILES["anexo_de_promesa_de_consorcio"],
        "constancia" => $_FILES["constancia"],
        "contrato_de_consorcio" => $_FILES["contrato_de_consorcio"],
        "contrato" => $_FILES["contrato"]
    ];

    switch ($action) {
        case 'add':

            $msj = "0x000";
            $DEok = $dbProyectos->InsertProyecto($nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad);
            if ($DEok > 0) {
                $lastId = $dbProyectos->getUltimoRegistroId();
                $carpeta = "pdfsProyectos/files" . $lastId;

                if (!is_dir($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }

                $affectedRowsFiles = $dbProyectos->InsertArchivosProyecto(
                    $lastId,
                    $archivos["acta_de_recepcion"]["name"],
                    $archivos["resolucion_de_obra"]["name"],
                    $archivos["resolucion_deductivos"]["name"],
                    $archivos["resolucion_adicionales"]["name"],
                    $archivos["anexo_de_promesa_de_consorcio"]["name"],
                    $archivos["constancia"]["name"],
                    $archivos["contrato_de_consorcio"]["name"],
                    $archivos["contrato"]["name"]
                );
                $AEok = 0;
                if ($affectedRowsFiles > 0) {
                    foreach ($archivos as $nombre => $archivo) {
                        $pdfNombre = $archivo["name"];
                        $directorio = $carpeta . "/" . $pdfNombre;

                        if (!empty($pdfNombre) && move_uploaded_file($archivo["tmp_name"], $directorio)) {
                            $AEok++;
                        }
                    }
                }

                if ($AEok > 0 && $DEok > 0) {
                    $msj = "0x10";
                } elseif ($DEok > 0) {
                    $msj = "0x11";
                } elseif ($AEok > 0) {
                    $msj = "0x12";
                } else {
                    $msj = "0x13";
                }
            }
            break;
        case 'update':
            $msj = "0x000";
            $AEok = 0;
            $DEok = 0;
            $affectedRowsFiles = 0;

            /**DATOS EMPRESA */
            $DEok = $dbProyectos->updateProyecto($id, $nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad);
            /**ARCHIVOS QUE ESTAN EN LA BASE DA DATOS */
            $archivosActual = [
                "acta_de_recepcion" => $_POST["acta_de_recepcion_actual"],
                "resolucion_de_obra" => $_POST["resolucion_de_obra_actual"],
                "resolucion_deductivos" => $_POST["resolucion_deductivos_actual"],
                "resolucion_adicionales" => $_POST["resolucion_adicionales_actual"],
                "anexo_de_promesa_de_consorcio" => $_POST["anexo_de_promesa_de_consorcio_actual"],
                "constancia" => $_POST["constancia_actual"],
                "contrato_de_consorcio" => $_POST["contrato_de_consorcio_actual"],
                "contrato" => $_POST["contrato_actual"]
            ];

            // Obtener los nombres de los archivos nuevos y actuales
            $archivosNombres = [
                "acta_de_recepcion" => $archivos["acta_de_recepcion"]["name"],
                "resolucion_de_obra" => $archivos["resolucion_de_obra"]["name"],
                "resolucion_deductivos" => $archivos["resolucion_deductivos"]["name"],
                "resolucion_adicionales" => $archivos["resolucion_adicionales"]["name"],
                "anexo_de_promesa_de_consorcio" => $archivos["anexo_de_promesa_de_consorcio"]["name"],
                "constancia" => $archivos["constancia"]["name"],
                "contrato_de_consorcio" => $archivos["contrato_de_consorcio"]["name"],
                "contrato" => $archivos["contrato"]["name"]
            ];

            $carpetaActual = "pdfsProyectos/files" . $id;
            foreach ($archivosNombres as $nombre => $nombreArchivo) {
                $pdfNombre = $nombreArchivo;

                $directorio = $carpetaActual . "/" . $pdfNombre;

                // Verificar si el archivo debe actualizarse o no dentro del for
                if (!empty($pdfNombre)) {
                    if (move_uploaded_file($archivos[$nombre]["tmp_name"], $directorio) == true) {
                        $sqlpdf = $pdfNombre;
                        if (file_exists($directorio)) {
                            unlink($carpetaActual . "/" . $archivosActual[$nombre]);
                        }
                    } else {
                        $msj = "0x23";
                    }
                } else {
                    $sqlpdf = $archivosActual[$nombre];
                }
                $affectedRowsFiles = $dbProyectos->UpdateArchivosProyecto($id, $nombre, $sqlpdf);
                if ($affectedRowsFiles > 0) {
                    $AEok++;
                }
            }

            if ($AEok > 0 && $DEok > 0) {
                $msj = "0x20";
            } elseif ($DEok > 0) {
                $msj = "0x21";
            } elseif ($AEok > 0) {
                $msj = "0x22";
            } else {
                $msj = "0x23";
            }
            break;
        case 'delete':
            $msj = "0x000";
            $AEok = 0;
            $DEok = 0;

            /**ARCHIVOS EMPRESA */
            $AEok = $dbProyectos->DeleteArchivosProyecto($id);

            if ($AEok > 0) {
                // unlink("pdfsActualizaciones/" . $pdfActual);
                $carpeta = "pdfsEmpresas/files" . $id;
                if (eliminarCarpeta($carpeta)) {
                    $DEok = $dbProyectos->DeleteProyecto($id);
                }
            }

            if ($AEok > 0 && $DEok > 0) {
                $msj = "0x30";
            } elseif ($DEok > 0) {
                $msj = "0x31";
            } elseif ($AEok > 0) {
                $msj = "0x32";
            } else {
                $msj = "0x33";
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
                $id = $iddd["maxId"];
            }
            $id = ($id + 1);
            $btn = "Agregar";
            $status = null;
            $botonView = 1;
            $proyecto = array(
                "idProyecto" => $id,
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

            $archivosProyecto = array(
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
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Actualizar";
            $status = null;
            $proyecto = $dbProyectos->selectProyecto($id);
            $archivosProyecto = $dbProyectos->selectArchivosProyecto($id);
            break;
        case 'delete':
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Eliminar";
            $status = "disabled";
            $proyecto = $dbProyectos->selectProyecto($id);
            $archivosProyecto = $dbProyectos->selectArchivosProyecto($id);
            break;
        case 'view':
            $id = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
            $status = "disabled";
            $proyecto = $dbProyectos->selectProyecto($id);
            $archivosProyecto = $dbProyectos->selectArchivosProyecto($id);
            break;
    }
}
switch ($btn) {
    case 'Eliminar':
        $style = "btn-delete";
        $hacer = "Eliminar Proyecto";
        break;
    case 'Agregar':
        $style = "btn-add";
        $hacer = "Agregar Proyecto";
        break;
    case 'Actualizar':
        $style = "btn-update";
        $hacer = "Actualizar Proyecto";
        break;
    case 'Ver':
        $hacer = "Ver Proyecto";
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
        <h3>Proyecto</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=proyecto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idProyecto" value="<?= $proyecto["idProyecto"]; ?>">
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="idProyecto" value="<?= $proyecto["idProyecto"]; ?>" <?= $status ?>>
                    <b> Nombre Empresa </b>
                    <div class="custom-select">
                        <select name="nombreEmpresa" <?= $status ?> required>
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
                    <input required type="date" placeholder=""  name="fechaFirma" value="<?= $proyecto["fecha_firma"]; ?>" <?= $status ?>>
                    <b> Monto Contrato Original S/.</b>
                    <input required type="text" name="montoContratoOriginal" value="<?= $proyecto["monto_contrato_original"]; ?>" <?= $status ?>>
                    <b> Porcentaje de Participación %</b>
                    <input required type="number" name="porcentajeParticipacion" value="<?= $proyecto["porcentaje_de_participacion"]; ?>" <?= $status ?>>
                    <b> Adicionales de la Obra S/.</b>
                    <input required type="number" name="adicionalesObra" value="<?= $proyecto["adicionales_de_la_obra"]; ?>" <?= $status ?>>
                    <b> Deductivos de Obra S/. </b>
                    <input required type="number" name="deductivosObra" value="<?= $proyecto["deductivos_de_obra"]; ?>" <?= $status ?>>
                    <b> Monto Final del Contrato S/.</b>
                    <input required type="number" name="montoFinalContrato" value="<?= $proyecto["monto_final_del_contrato"]; ?>" <?= $status ?>>
                    <b> Miembro del Consorcio </b>
                    <input required type="text" name="miembroConsorcio" value="<?= $proyecto["miembro_del_consorcio"]; ?>" <?= $status ?>>
                    <b> Observaciones </b>
                    <textarea required type="text" name="observaciones" value="" <?= $status ?>><?= $proyecto["observaciones"]; ?></textarea>
                    <b> Contacto </b>
                    <div class="custom-select">
                        <select name="contacto" <?= $status ?> required>
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
                        <select name="objeto" <?= $status ?> required>
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
                        <select name="especialidad" <?= $status ?> required>
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

                                $archivosHabilitados = array(
                                    "acta_de_recepcion" => array(
                                        "btn" => "b1",
                                        "valor" => isset($archivosProyecto["acta_de_recepcion"]) ? $archivosProyecto["acta_de_recepcion"] : null
                                    ),
                                    "resolucion_de_obra" => array(
                                        "btn" => "b2",
                                        "valor" => isset($archivosProyecto["resolucion_de_obra"]) ? $archivosProyecto["resolucion_de_obra"] : null
                                    ),
                                    "resolucion_deductivos" => array(
                                        "btn" => "b3",
                                        "valor" => isset($archivosProyecto["resolucion_deductivos"]) ? $archivosProyecto["resolucion_deductivos"] : null
                                    ),
                                    "resolucion_adicionales" => array(
                                        "btn" => "b4",
                                        "valor" => isset($archivosProyecto["resolucion_adicionales"]) ? $archivosProyecto["resolucion_adicionales"] : null
                                    ),
                                    "anexo_de_promesa_de_consorcio" => array(
                                        "btn" => "b5",
                                        "valor" => isset($archivosProyecto["anexo_de_promesa_de_consorcio"]) ? $archivosProyecto["anexo_de_promesa_de_consorcio"] : null
                                    ),
                                    "constancia" => array(
                                        "btn" => "b6",
                                        "valor" => isset($archivosProyecto["constancia"]) ? $archivosProyecto["constancia"] : null
                                    ),
                                    "contrato_de_consorcio" => array(
                                        "btn" => "b7",
                                        "valor" => isset($archivosProyecto["contrato_de_consorcio"]) ? $archivosProyecto["contrato_de_consorcio"] : null
                                    ),
                                    "contrato" => array(
                                        "btn" => "b8",
                                        "valor" => isset($archivosProyecto["contrato"]) ? $archivosProyecto["contrato"] : null
                                    )
                                );

                                foreach ($archivosHabilitados as $campo => $archivo) {
                                    $btnn = $archivo["btn"];
                                    $valor = $archivo["valor"];
                                    ${"b" . substr($btnn, 1)} = empty($valor) ? 'disabled-button' : null;
                                    ${$campo} = $valor;
                                }
                                ?>

                                <tr>
                                    <td class="description">Acta de Recepción</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="acta_de_recepcion_actual" value="<?= $acta_de_recepcion ?>">
                                        <input type="text" id="des1" value="<?= $acta_de_recepcion ?>">
                                    </td>
                                    <td>
                                        <input id="archivo1" type="file" min="0" name="acta_de_recepcion" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo1" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $acta_de_recepcion ?>" class="btn1 btn-action-doc <?= $b1 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $acta_de_recepcion ?>" class="btn1 btn-action-doc <?= $b1 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Resolución de Obra</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="resolucion_de_obra_actual" value="<?= $resolucion_de_obra ?>">
                                        <input type="text" id="des2" value="<?= $resolucion_de_obra ?>">
                                    </td>
                                    <td>
                                        <input id="archivo2" type="file" min="0" name="resolucion_de_obra" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo2" name="addPdf-2" id="addPdf-2">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $resolucion_de_obra ?>" class="btn2 btn-action-doc <?= $b2 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $resolucion_de_obra ?>" class="btn2 btn-action-doc <?= $b2 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Resolución de Deductivos</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="resolucion_deductivos_actual" value="<?= $resolucion_deductivos ?>">
                                        <input type="text" id="des3" value="<?= $resolucion_deductivos ?>">
                                    </td>
                                    <td>
                                        <input id="archivo3" type="file" min="0" name="resolucion_deductivos" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo3" name="addPdf-3" id="addPdf-3">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $resolucion_deductivos ?>" class="btn3 btn-action-doc <?= $b3 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $resolucion_deductivos ?>" class="btn3 btn-action-doc <?= $b3 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Resolución Adicionales</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="resolucion_adicionales_actual" value="<?= $resolucion_adicionales ?>">
                                        <input type="text" id="des4" value="<?= $resolucion_adicionales ?>">
                                    </td>
                                    <td>
                                        <input id="archivo4" type="file" min="0" name="resolucion_adicionales" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo4" name="addPdf-4" id="addPdf-4">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $resolucion_adicionales ?>" class="btn4 btn-action-doc <?= $b4 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $resolucion_adicionales ?>" class="btn4 btn-action-doc <?= $b4 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Anexo de Promesa de Consorcio</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="anexo_de_promesa_de_consorcio_actual" value="<?= $anexo_de_promesa_de_consorcio ?>">
                                        <input type="text" id="des5" value="<?= $anexo_de_promesa_de_consorcio ?>">
                                    </td>
                                    <td>
                                        <input id="archivo5" type="file" min="0" name="anexo_de_promesa_de_consorcio" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo5" name="addPdf-5" id="addPdf-5">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $anexo_de_promesa_de_consorcio ?>" class="btn5 btn-action-doc <?= $b5 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $anexo_de_promesa_de_consorcio ?>" class="btn5 btn-action-doc <?= $b5 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Constancia</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="constancia_actual" value="<?= $constancia ?>">
                                        <input type="text" id="des6" value="<?= $constancia ?>">
                                    </td>
                                    <td>
                                        <input id="archivo6" type="file" min="0" name="constancia" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo6" name="addPdf-6" id="addPdf-6">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $constancia ?>" class="btn6 btn-action-doc <?= $b6 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $constancia ?>" class="btn6 btn-action-doc <?= $b6 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Contrato de Consorcio</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="contrato_de_consorcio_actual" value="<?= $contrato_de_consorcio ?>">
                                        <input type="text" id="des7" value="<?= $contrato_de_consorcio ?>">
                                    </td>
                                    <td>
                                        <input id="archivo7" type="file" min="0" name="contrato_de_consorcio" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo7" name="addPdf-7" id="addPdf-7">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $contrato_de_consorcio ?>" class="btn7 btn-action-doc <?= $b7 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $contrato_de_consorcio ?>" class="btn7 btn-action-doc <?= $b7 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Contrato</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="contrato_actual" value="<?= $contrato ?>">
                                        <input type="text" id="des8" value="<?= $contrato ?>">
                                    </td>
                                    <td>
                                        <input id="archivo8" type="file" min="0" name="contrato" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo8" name="addPdf-8" id="addPdf-8">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=proyecto&cod=<?= $id ?>&file=<?= $contrato ?>" class="btn8 btn-action-doc <?= $b8 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsProyectos/files<?= $id ?>/<?= $contrato ?>" class="btn8 btn-action-doc <?= $b8 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" class="btn-actions <?= $style ?>"><?= $btn ?></button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>