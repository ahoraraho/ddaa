<?php
// Valido que el usuario sea administrador
validacionIicioSesion();

// Valido que haya una accion a realizar, sino se irá a crear un nuevo producto
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// descarga el archivo
if (isset($_GET['file'])) {
    $archivo = $_GET['file'];

    $ruta_archivo = "pdfsActualizaciones/" . $archivo;

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

// Valido que tipo de petición invoca al módulo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aca se deben procesar los datos del formulario ejecutado
    $id = $_POST["id"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];

    $pdf = $_FILES["archivo"];
    $pdfNombre = $pdf["name"];

    $pdfActual = $_POST["pdfActual"];

    $directorio = "pdfsActualizaciones/";
    $ruta = $directorio . "/" . $pdfNombre;


    switch ($action) {
        case 'add':
            $msj = "0x000"; // BUG
            //si la carpeta no exite crea la misma con el nombre establecido lineas arriba
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $affectedRows = $dbActualizaciones->InsertActualizacion($descripcion, $tipo, $pdfNombre);
            if ($affectedRows > 0) {
                $msj = "0x10";
                if (!empty($pdfNombre)) {
                    if (move_uploaded_file($pdf["tmp_name"], $ruta) == false) {
                        $msj = "0x11";
                    }
                }
            }
            break;
        case 'update':
            if (!empty($pdfNombre)) {
                if (move_uploaded_file($pdf["tmp_name"], $ruta) == true) {
                    $sqlpdf = $pdfNombre;
                    unlink($directorio . "/" . $pdfActual);
                } else {
                    $msj = "0x21";
                }
            } else {
                $sqlpdf = $pdfActual;
            }
            $affectedRows = $dbActualizaciones->UpdateActualizacion($id, $descripcion, $tipo, $sqlpdf);
            if ($affectedRows == 0) {
                $msj = "0x000";
            }
            $msj = "0x20";
            break;
        case 'delete':
            $msj = "0x000";
            if ($dbActualizaciones->DeleteActualizacion($id) > 0) {
                unlink("pdfsActualizaciones/" . $pdfActual);
                $msj = "0x30";
            }
            break;
    }
    header('location: ?m=panel&mod=actualizaciones&msj=' . $msj);
    exit;
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            $maxid = $dbActualizaciones->MayorIdActualizacion();
            $id = $maxid + 1;
            $btn = "Agregar";
            $status = null;
            $actualizacion = array(
                "idActualizacion" => $id,
                "descripcion" => "",
                "tipo" => "",
                "archivo" => ""
            );
            $botonView = 1;
            break;
        case 'update':
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Guardar";
            $status = null;
            $actualizacion = $dbActualizaciones->selectActulizacion($id);
            break;
        case 'delete':
            $id = $_GET["id"];
            $botonView = 1;
            $btn = "Eliminar";
            $status = "disabled";
            $actualizacion = $dbActualizaciones->selectActulizacion($id);
            break;
        case 'view':
            $id = $_GET["id"];
            $botonView = 0;
            $btn = "Ver";
            $status = "disabled";
            $actualizacion = $dbActualizaciones->selectActulizacion($id);
            break;
    }
}
switch ($btn) {
    case 'Eliminar':
        $style = "background-color: crimson";
        $hacer = "Eliminar Actualización";
        break;
    case 'Agregar':
        $style = "background-color: rgb(0, 176, 26)";
        $hacer = "Agregar Actualización";
        break;
    case 'Guardar':
        $style = "background-color: rgb(9, 109, 149)";
        $hacer = "Editar Actualización";
        break;
    case 'Ver':
        $style = "";
        $hacer = "Ver Actulización";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=actualizaciones" title="Ir a Actualizaciones">Actualizaciones</a>
    <a href="#" title="Estas justo aquí" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Actualización</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=actualizacion&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $actualizacion["idActualizacion"]; ?>">
                    <input type="hidden" name="pdfActual" value="<?= $actualizacion["archivo"]; ?>">
                    <span> Id Actualización</span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="id" value="<?= $actualizacion["idActualizacion"] ?>" <?= $status ?>>
                    <span> Descripción </span>
                    <input required type="text" name="descripcion" value="<?= $actualizacion["descripcion"] ?>" <?= $status ?>>
                    <span> Tipo </span>
                    <div class="custom-select">
                        <select name="tipo" class="l" required <?= $status; ?>>
                            <option value="">Tipo de actualización...</option>
                            <?php
                            $tipos = $dbProdds->selectProdds();
                            foreach ($tipos as $tipo) {
                                $idActual = $tipo["idActual"];
                                $nombre = $tipo["nombre"];
                                $tipo = $actualizacion["tipo"]; //este codigo recata el id de la tabla principal para luego compararlo con el de la secundaria
                            ?>
                                <option value="<?= $idActual ?>" <?= ($idActual == $tipo) ? "selected" : null ?>><?= $nombre ?></option>
                            <?php } ?>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></span> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>
                    <?php
                    //SI LA VARIABLE ESTA BASIO SE ACTIVA LOS ESTILOS DE LOS BOTONES DESABILITADOS
                    if (empty($actualizacion["archivo"])) {
                        $deshabilitado = 'disabled-button';
                        $archivo = 'El archivo está vacío';
                    } else {
                        $deshabilitado = null;
                        $archivo = $actualizacion["archivo"];
                    }
                    ?><br>
                    <div class="contenedor_pdf">
                        <table>
                            <tbody style="text-align: start;">
                                <tr>
                                    <td class="description"><?= $archivo ?></td>
                                    <td>
                                        <input id="pdfActual" type="file" name="archivo" accept=".pdf" <?= $status ?>>
                                        <div class="btn-add-pdf">
                                            <label title="Cargar archivo PDF" for="pdfActual" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=actualizacion&file=<?= $actualizacion["archivo"] ?>" class="btn-action-doc <?= $deshabilitado ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a title="Ver" target="_blank" href="pdfsActualizaciones/<?= $actualizacion["archivo"] ?>" class="btn-action-doc <?= $deshabilitado ?>">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br><br>
                    <?php if ($botonView == 1) { ?>
                        <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn ?></button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const archivoInput = document.getElementById("pdfActual");
    const descripcionArchivo = document.querySelector(".description");

    const elementos = document.querySelectorAll(".btn-action-doc");

    archivoInput.addEventListener("change", function() {
        if (archivoInput.files.length > 0) {
            const nombre = archivoInput.files[0].name;
            descripcionArchivo.textContent = nombre;
            // Eliminar la clase "mi-clase" de otros elementos
            elementos.forEach(function(elemento) {
                elemento.classList.remove("disabled-button");
            });

        } else {
            descriptionElement.textContent = "El Archivo esta vacio";
        }

    });
</script>