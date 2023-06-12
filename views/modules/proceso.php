<?php
$dbProcesos = new dbProcesos();

$procesos = $dbProcesos->obtenerProcesos();
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas">Procesos</a>
    <a href="#" title="Estas justo aqui" class="active">Proceso</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>PROCESO</h3>
        <div class="main">
            <div class="formm">
                <?php
                $action = isset($_GET["action"]) ? $_GET["action"] : "add";

                //====================================================================
                //==            Mostrar los datos dentro del formulario             ==
                //====================================================================
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Aca se deben procesar los datos del formulario ejecutado
                    $id = isset($_GET["id"]) ? $_GET["id"] : "";

                    if ($action == "update" || $action == "delete") {
                        $proceso = $dbProcesos->selectProceso($id);

                        if (!empty($proceso)) {
                            $numProceso = $proceso["numProceso"];
                            $entidad = $proceso["entidad"];
                            $nomenclatura = $proceso["nomenclatura"];
                            $nombreClave = $proceso["nombreClave"];
                            $consultas = $proceso["consultas"];
                            $integracion = $proceso["integracion"];
                            $presentacion = $proceso["presentacion"];
                            $buenaPro = $proceso["buenaPro"];
                            $valorReferencial = $proceso["valorReferencial"];
                            $postores = $proceso["postores"];
                            $encargado = $proceso["encargado"];
                            $observaciones = $proceso["observaciones"];
                        }
                    } else if ($action == "add") {
                        // Inicializar los valores en blanco para un nuevo registro
                        $numProceso = "";
                        $entidad = "";
                        $nomenclatura = "";
                        $nombreClave = "";
                        $consultas = "";
                        $integracion = "";
                        $presentacion = "";
                        $buenaPro = "";
                        $valorReferencial = "";
                        $postores = "";
                        $encargado = "";
                        $observaciones = "";
                    }
                } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores del formulario
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
                    $observaciones = $_POST["observaciones"];

                    // Verificar action
                    if ($action == "update") {
                        // Realizar la actualización utilizando el método updateProceso
                        $proceso = [
                            'numProceso' => $numProceso,
                            'entidad' => $entidad,
                            'nomenclatura' => $nomenclatura,
                            'nombreClave' => $nombreClave,
                            'consultas' => $consultas,
                            'integracion' => $integracion,
                            'presentacion' => $presentacion,
                            'buenaPro' => $buenaPro,
                            'valorReferencial' => $valorReferencial,
                            'postores' => $postores,
                            'encargado' => $encargado,
                            'observaciones' => $observaciones,
                        ];

                        $actualizado = $dbProcesos->updateProceso($proceso);
                        if ($actualizado) {
                            // Actualización exitosa, realizar alguna acción
                        } else {
                            // Error al actualizar, manejar el caso apropiado
                        }
                    } else if ($action == "add") {
                        // Realizar la inserción utilizando el método insertarProceso
                        $proceso = [
                            'numProceso' => $numProceso,
                            'entidad' => $entidad,
                            'nomenclatura' => $nomenclatura,
                            'nombreClave' => $nombreClave,
                            'consultas' => $consultas,
                            'integracion' => $integracion,
                            'presentacion' => $presentacion,
                            'buenaPro' => $buenaPro,
                            'valorReferencial' => $valorReferencial,
                            'postores' => $postores,
                            'encargado' => $encargado,
                            'observaciones' => $observaciones,
                        ];

                        $idInsertado = $dbProcesos->insertarProceso($proceso);
                        if ($idInsertado) {
                            // Inserción exitosa, realizar alguna acción
                        } else {
                            // Error al insertar, manejar el caso apropiado
                        }
                    } else if ($action == "delete") {
                        // Realizar la eliminación utilizando el método deleteProceso
                        $eliminado = $dbProcesos->deleteProceso($numProceso);
                        if ($eliminado) {
                            // Eliminación exitosa, realizar alguna acción
                        } else {
                            // Error al eliminar, manejar el caso apropiado
                        }
                    }
                }
                ?>
                <form action="?m=panel&mod=proceso&action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="numProceso" value="<?php echo $numProceso; ?>">
                    <i class="bi bi-qr-code-scan"></i><span> Número de Proceso </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="numProceso" value="<?php echo $numProceso; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Entidad </span>
                    <input required type="text" name="entidad" value="<?php echo $entidad; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Nomenclatura </span>
                    <input required type="text" name="nomenclatura" value="<?php echo $nomenclatura; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Nombre Clave </span>
                    <input required type="text" name="nombreClave" value="<?php echo $nombreClave; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Consultas </span>
                    <input required type="text" name="consultas" value="<?php echo $consultas; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Integración </span>
                    <input required type="text" name="integracion" value="<?php echo $integracion; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Presentación </span>
                    <input required type="text" name="presentacion" value="<?php echo $presentacion; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Buena Pro </span>
                    <input required type="text" name="buenaPro" value="<?php echo $buenaPro; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Valor Referencial </span>
                    <input required type="text" name="valorReferencial" value="<?php echo $valorReferencial; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Postores </span>
                    <input required type="text" name="postores" value="<?php echo $postores; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Encargado </span>
                    <input required type="text" name="encargado" value="<?php echo $encargado; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Observaciones </span>
                    <input required type="text" name="observaciones" value="<?php echo $observaciones; ?>">
                    <br><br>
                    <button type="submit" name="action" id="ac" style="color:red;" class="form_login" value="<?php echo $action; ?>">
                        <?php
                        if ($action == "update") {
                            echo "Actualizar";
                        } else if ($action == "add") {
                            echo "Agregar";
                        } else if ($action == "delete") {
                            echo "Eliminar";
                        }
                        ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
