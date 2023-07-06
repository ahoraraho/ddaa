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

    $ruta_archivo = "pdfsEmpresas/files" . $cod . "/" . $archivo;

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
    // REGISTROS DE LA TABLA EMPRESA
    $id = $_POST["id"];
    $nombreEmpresa = $_POST["nombreEmpresa"];
    $ruc = $_POST["ruc"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $numeroPartida = $_POST["numeroPartida"];
    $mipe = $_POST["mipe"];

    //REGISTROS DE LA TABLA ARCHIVOS DE EMPRESA
    $archivos = [
        "ficha_ruc" => $_FILES["ficha_ruc"],
        "constancia_RNP" => $_FILES["constancia_RNP"],
        "constancia_mipe" => $_FILES["constancia_mipe"],
        "certificado_discapacitados" => $_FILES["certificado_discapacitados"],
        "planilla_discapasitados" => $_FILES["planilla_discapasitados"],
        "carnet_conadis" => $_FILES["carnet_conadis"]
    ];


    switch ($action) {
        case 'add':

            $msj = "0x000";
            $DEok = $dbEmpresas->InsertEmpresa($nombreEmpresa, $ruc, $telefono, $email, $numeroPartida, $mipe);
            if ($DEok > 0) {
                $lastId = $dbEmpresas->getUltimoRegistroId();
                $carpeta = "pdfsEmpresas/files" . $lastId;

                if (!is_dir($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }

                $affectedRowsFiles = $dbEmpresas->InsertArchivosEmpresa(
                    $lastId,
                    $archivos["ficha_ruc"]["name"],
                    $archivos["constancia_RNP"]["name"],
                    $archivos["constancia_mipe"]["name"],
                    $archivos["certificado_discapacitados"]["name"],
                    $archivos["planilla_discapasitados"]["name"],
                    $archivos["carnet_conadis"]["name"]
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
            $DEok = $dbEmpresas->UpdateEmpresa($id, $nombreEmpresa, $ruc, $telefono, $email, $numeroPartida, $mipe);

            /**ARCHIVOS */
            $archivosActual = [
                "ficha_ruc" => $_POST["ficha_ruc_actual"],
                "constancia_RNP" => $_POST["constancia_RNP_actual"],
                "constancia_mipe" => $_POST["constancia_mipe_actual"],
                "certificado_discapacitados" => $_POST["certificado_discapacitados_actual"],
                "planilla_discapasitados" => $_POST["planilla_discapasitados_actual"],
                "carnet_conadis" => $_POST["carnet_conadis_actual"]
            ];

            // Obtener los nombres de los archivos nuevos y actuales
            $archivosNombres = [
                "ficha_ruc" => $archivos["ficha_ruc"]["name"],
                "constancia_RNP" => $archivos["constancia_RNP"]["name"],
                "constancia_mipe" => $archivos["constancia_mipe"]["name"],
                "certificado_discapacitados" => $archivos["certificado_discapacitados"]["name"],
                "planilla_discapasitados" => $archivos["planilla_discapasitados"]["name"],
                "carnet_conadis" => $archivos["carnet_conadis"]["name"]
            ];

            $carpetaActual = "pdfsEmpresas/files" . $id;
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
                $affectedRowsFiles = $dbEmpresas->UpdateArchivosEmpresa($id, $nombre, $sqlpdf);
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
            $AEok = $dbEmpresas->DeleteArchivosEmpresa($id);

            if ($AEok > 0) {
                // unlink("pdfsActualizaciones/" . $pdfActual);
                $carpeta = "pdfsEmpresas/files" . $id;
                if (eliminarCarpeta($carpeta)) {
                    $DEok = $dbEmpresas->DeleteEmpresa($id);
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

            $archivosEmpresa = array(
                "ficha_ruc" => "",
                "constancia_RNP" => "",
                "constancia_mipe" => "",
                "certificado_discapacitados" => "",
                "planilla_discapasitados" => "",
                "carnet_conadis" => ""
            );

            break;

        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $empresa = $dbEmpresas->selectEmpresa($id);
            $archivosEmpresa = $dbEmpresas->selectArchivosEmpresa($id);

            break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $empresa = $dbEmpresas->selectEmpresa($id);
            $archivosEmpresa = $dbEmpresas->selectArchivosEmpresa($id);

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
        <h3>Empresa</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=empresa&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $empresa["idEmpresa"]; ?>">
                    <b> ID Empresa</b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $empresa["idEmpresa"] ?>" <?= $status ?>>
                    <b> Nombre Empresa</b>
                    <input required type="text" name="nombreEmpresa" value="<?= $empresa["nombreEmpresa"] ?>" <?= $status ?>>
                    <b> RUC </b>
                    <input required type="number" min="0" oninput="validateLength(this, 11)" name="ruc" value="<?= $empresa["ruc"] ?>" <?= $status ?>>
                    <b> Telefono </b>
                    <input required type="number" min="0" oninput="validateLength(this, 9)" name="telefono" value="<?= $empresa["telefono"] ?>" <?= $status ?>>
                    <b> Email </b>
                    <input required type="email" min="0" name="email" value="<?= $empresa["email"] ?>" <?= $status ?>>
                    <b> Numero de Partida </b>
                    <input required type="text" min="0" oninput="validateLength(this, 8)" name="numeroPartida" value="<?= $empresa["numeroPartida"] ?>" <?= $status ?>>
                    <b> MIPE </b>
                    <input required type="text" min="0" oninput="validateLength(this, 1)" name="mipe" value="<?= $empresa["mipe"] ?>" <?= $status ?>>
                    <br><br>
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
                                <tr>
                                    <?php
                                    $archivos = array(
                                        "ficha_ruc" => array(
                                            "btn" => "b1",
                                            "valor" => isset($archivosEmpresa["ficha_ruc"]) ? $archivosEmpresa["ficha_ruc"] : null
                                        ),
                                        "constancia_RNP" => array(
                                            "btn" => "b2",
                                            "valor" => isset($archivosEmpresa["constancia_RNP"]) ? $archivosEmpresa["constancia_RNP"] : null
                                        ),
                                        "constancia_mipe" => array(
                                            "btn" => "b3",
                                            "valor" => isset($archivosEmpresa["constancia_mipe"]) ? $archivosEmpresa["constancia_mipe"] : null
                                        ),
                                        "certificado_discapacitados" => array(
                                            "btn" => "b4",
                                            "valor" => isset($archivosEmpresa["certificado_discapacitados"]) ? $archivosEmpresa["certificado_discapacitados"] : null
                                        ),
                                        "planilla_discapasitados" => array(
                                            "btn" => "b5",
                                            "valor" => isset($archivosEmpresa["planilla_discapasitados"]) ? $archivosEmpresa["planilla_discapasitados"] : null
                                        ),
                                        "carnet_conadis" => array(
                                            "btn" => "b6",
                                            "valor" => isset($archivosEmpresa["carnet_conadis"]) ? $archivosEmpresa["carnet_conadis"] : null
                                        )
                                    );

                                    foreach ($archivos as $campo => $archivo) {
                                        $btn = $archivo["btn"];
                                        $valor = $archivo["valor"];
                                        ${"b" . substr($btn, 1)} = empty($valor) ? 'disabled-button' : null;
                                        ${$campo} = $valor;
                                    }
                                    ?>
                                    <td class="description">Fincha RUC</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="ficha_ruc_actual" value="<?= $ficha_ruc ?>">
                                        <input type="text" id="des1" value="<?= $ficha_ruc ?>">
                                    </td>
                                    <td>
                                        <input id="archivo1" type="file" min="0" name="ficha_ruc" accept=".pdf">
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo1" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=empresa&cod=<?= $id ?>&file=<?= $ficha_ruc ?>" id="btn1" class="btn1 btn-action-doc <?= $b1 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsEmpresas/files<?= $id ?>/<?= $ficha_ruc ?>" id="btn1" class="btn1 btn-action-doc <?= $b1 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Constancia de RNP</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="constancia_RNP_actual" value="<?= $constancia_RNP ?>">
                                        <input type="text" id="des2" value="<?= $constancia_RNP ?>">
                                    </td>
                                    <td>
                                        <input id="archivo2" type="file" min="0" name="constancia_RNP" accept=".pdf">
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo2" name="addPdf-3" id="addPdf-3">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=empresa&cod=<?= $id ?>&file=<?= $constancia_RNP ?>" id="btn2" class="btn2 btn-action-doc <?= $b2 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsEmpresas/files<?= $id ?>/<?= $constancia_RNP ?>" id="btn2" class="btn2 btn-action-doc <?= $b2 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Constancia MIPE</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="constancia_mipe_actual" value="<?= $constancia_mipe ?>">
                                        <input type="text" id="des3" value="<?= $constancia_mipe ?>">
                                    </td>
                                    <td>
                                        <input id="archivo3" type="file" min="0" name="constancia_mipe" accept=".pdf">
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo3" name="addPdf-3" id="addPdf-3">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=empresa&cod=<?= $id ?>&file=<?= $constancia_mipe ?>" id="btn3" class="btn3 btn-action-doc <?= $b3 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsEmpresas/files<?= $id ?>/<?= $constancia_mipe ?>" id="btn3" class="btn3 btn-action-doc <?= $b3 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Certificados de discapacitados</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="certificado_discapacitados_actual" value="<?= $certificado_discapacitados ?>">
                                        <input type="text" id="des4" value="<?= $certificado_discapacitados ?>">
                                    </td>
                                    <td>
                                        <input id="archivo4" type="file" min="0" name="certificado_discapacitados" accept=".pdf">
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo4" name="addPdf-4" id="addPdf-4">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=empresa&cod=<?= $id ?>&file=<?= $certificado_discapacitados ?>" id="btn4" class="btn4 btn-action-doc <?= $b4 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsEmpresas/files<?= $id ?>/<?= $certificado_discapacitados ?>" id="btn4" class="btn4 btn-action-doc <?= $b4 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Planilla de discapacitados</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="planilla_discapasitados_actual" value="<?= $planilla_discapasitados ?>">
                                        <input type="text" id="des5" value="<?= $planilla_discapasitados ?>">
                                    </td>
                                    <td>
                                        <input id="archivo5" type="file" min="0" name="planilla_discapasitados" accept=".pdf">
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo5" name="addPdf-5" id="addPdf-5">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=empresa&cod=<?= $id ?>&file=<?= $planilla_discapasitados ?>" id="btn5" class="btn5 btn-action-doc <?= $b5 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsEmpresas/files<?= $id ?>/<?= $planilla_discapasitados ?>" id="btn5" class="btn5 btn-action-doc <?= $b5 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Carnet de CONADIS</td>
                                    <td class="nombreArchivo">
                                        <input type="hidden" min="0" name="carnet_conadis_actual" value="<?= $carnet_conadis ?>">
                                        <input type="text" id="des6" value="<?= $carnet_conadis ?>">
                                    </td>
                                    <td>
                                        <input id="archivo6" type="file" min="0" name="carnet_conadis" accept=".pdf">
                                        <div class="btn-add-pdf">
                                            <label title="Carcar archivo PDF" for="archivo6" name="addPdf-6" id="addPdf-6">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=panel&mod=empresa&cod=<?= $id ?>&file=<?= $carnet_conadis ?>" id="btn6" class="btn6 btn-action-doc <?= $b6 ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsEmpresas/files<?= $id ?>/<?= $carnet_conadis ?>" id="btn6" class="btn6 btn-action-doc <?= $b6 ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $hacer; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const archivos = [{
            archivo: document.getElementById("archivo1"),
            des: document.getElementById("des1"),
            btns: document.querySelectorAll(".btn1")
        },
        {
            archivo: document.getElementById("archivo2"),
            des: document.getElementById("des2"),
            btns: document.querySelectorAll(".btn2")
        },
        {
            archivo: document.getElementById("archivo3"),
            des: document.getElementById("des3"),
            btns: document.querySelectorAll(".btn3")
        },
        {
            archivo: document.getElementById("archivo4"),
            des: document.getElementById("des4"),
            btns: document.querySelectorAll(".btn4")
        },
        {
            archivo: document.getElementById("archivo5"),
            des: document.getElementById("des5"),
            btns: document.querySelectorAll(".btn5")
        },
        {
            archivo: document.getElementById("archivo6"),
            des: document.getElementById("des6"),
            btns: document.querySelectorAll(".btn6")
        }
    ];

    archivos.forEach((item, index) => {
        item.archivo.addEventListener("change", function() {
            if (item.archivo.files.length > 0) {
                const nombre = item.archivo.files[0].name;
                item.des.value = nombre;
                item.btns.forEach((elemento) => {
                    elemento.classList.remove("disabled-button");
                });
            } else {
                item.des.value = "";
            }
        });
    });

    function validateLength(input, maxLength) {
        if (input.value.length > maxLength) {
            input.setCustomValidity("Debe contener " + maxLength + " Caractere(s) como maximo");
        } else {
            input.setCustomValidity("");
        }
    }
</script>