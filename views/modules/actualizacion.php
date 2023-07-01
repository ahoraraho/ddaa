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
        echo "El archivo no existe en el servidor.";
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

    $directorio = "pdfsActualizaciones/" . $pdfNombre;

    switch ($action) {
        case 'add':
            $msj = "0x400"; // BUG
            $affectedRows = $dbActualizaciones->InsertActualizacion($descripcion, $tipo, $pdfNombre);
            if ($affectedRows > 0) {
                $msj = "0x10";
                if (!empty($pdfNombre)) {
                    if (move_uploaded_file($pdf["tmp_name"], $directorio) == false) {
                        $msj = "0x11";
                    }
                }
            }
            break;
        case 'update':
            if (!empty($pdfNombre)) {
                if (move_uploaded_file($pdf["tmp_name"], $directorio) == true) {
                    $sqlpdf = $pdfNombre;
                    unlink("pdfsActualizaciones/" . $pdfActual);
                } else {
                    $msj = "0x21";
                }
            } else {
                $sqlpdf = $pdfActual;
            }
            $affectedRows = $dbActualizaciones->UpdateActualizacion($id, $descripcion, $tipo, $sqlpdf);
            if ($affectedRows == 0) {
                $msj = "0x400";
            }
            $msj = "0x20";
            break;
        case 'delete':
            $msj = "0x400";
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
            break;
        case 'update':
            $id = $_GET["id"];
            $btn = "Guardar";
            $status = null;
            $actualizacion = $dbActualizaciones->selectActulizacion($id);
            break;
        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $actualizacion = $dbActualizaciones->selectActulizacion($id);
            break;
    }
}
switch ($btn) {
    case 'Eliminar':
        $style = "background-color: crimson";
        $styleImage = "display: none !important";
        $hacer = "Eliminar Actualización";
        $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color: rgb(0, 176, 26)";
        $hacer = "Agregar Actualización";
        $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color: rgb(9, 109, 149)";
        $hacer = "Editar Actualización";
        $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=objetos" title="Ir a Marcas">Actualizaciones</a>
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
                    <input id="noEdit" title="No se puede modificar" disabled required type="text" name="id" value="<?= $actualizacion["idActualizacion"] ?>" <?= $status ?>>
                    <span> Descripción </span>
                    <input required type="text" name="descripcion" value="<?= $actualizacion["descripcion"] ?>" <?= $status ?>>
                    <span> Tipo </span>
                    <select name="tipo" value="<?= $actualizacion["tipo"]; ?>"<?= $status ?>>
                            <?php
                            $tipos = $dbActualizaciones->selectTipos();
                            foreach ($tipos as $tipo) {
                                $selected = ($tipo["idObjeto"] == $actualizacion["tipo"]) ? "selected" : ""; ?>
                                <option value="<?= $tipo["idActual"] ?>" <?= $selected ?>><?= $tipo["nombre"] ?></option>
                            <?php
                            }
                            ?>
                    </select><br><br>
                    <div class="contenedor_pdf">
                        <table>
                            <tbody style="text-align: start;">
                                <tr>
                                    <td class="description">Archivo</td>
                                    <td>
                                        <input id="pdfActual" type="file" name="archivo">
                                        <div class="btn-add-pdf">
                                            <label title="Cargar archivo PDF" for="pdfActual" name="addPdf-1" id="addPdf-1">Cargar PDF</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Descargar" href="?m=actualizacion&file=<?= $actualizacion["archivo"] ?>" class="btn-action-doc" <?= $status ?>>
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td style="width: min-content;">
                                        <a title="Ver" target="_blank" href="pdfsActualizaciones/<?= $actualizacion["archivo"] ?>" class="btn-action-doc" <?= $status ?>>
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>