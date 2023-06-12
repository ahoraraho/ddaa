<?php
$dbProyectos = new dbProyectos();

$proyecto = $dbProyectos->obtenerProyectos();
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=proyectos" title="Ir a Proyectos">Proyectos</a>
    <a href="#" title="Estás aquí" class="active">Proyecto</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>PROYECTO</h3>
        <div class="main">
            <div class="formm">
                <?php
                $action = isset($_GET["action"]) ? $_GET["action"] : "add";

                //====================================================================
                //==            Mostrar los datos dentro del formulario             ==
                //====================================================================
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Aca se deben procesar los datos del formulario ejecutado
                    $idProyecto = isset($_GET["idProyecto"]) ? $_GET["idProyecto"] : "";

                    if ($action == "update" || $action == "delete") {
                        $proyecto = $dbProyectos->selectProyecto($idProyecto);

                        if (!empty($proyecto)) {
                            $nombreEmpresa = $proyecto["nombre_empresa"];
                            $nombreProyecto = $proyecto["nombre_proyecto"];
                            $numeroContrato = $proyecto["numero_contrato"];
                            $entidad = $proyecto["entidad"];
                            $fechaFirma = $proyecto["fecha_firma"];
                            $montoContratoOriginal = $proyecto["monto_contrato_original"];
                            $porcentajeParticipacion = $proyecto["porcentaje_de_participacion"];
                            $adicionalesObra = $proyecto["adicionales_de_la_obra"];
                            $deductivosObra = $proyecto["deductivos_de_obra"];
                            $montoFinalContrato = $proyecto["monto_final_del_contrato"];
                            $miembroConsorcio = $proyecto["miembro_del_consorcio"];
                            $observaciones = $proyecto["observaciones"];
                            $contrato = $proyecto["contrato"];
                            $objeto = $proyecto["objeto"];
                            $especialidad = $proyecto["especialidad"];
                        }
                    } else if ($action == "add") {
                        // Inicializar los valores en blanco para un nuevo registro
                        $nombreEmpresa = "";
                        $nombreProyecto = "";
                        $numeroContrato = "";
                        $entidad = "";
                        $fechaFirma = "";
                        $montoContratoOriginal = "";
                        $porcentajeParticipacion = "";
                        $adicionalesObra = "";
                        $deductivosObra = "";
                        $montoFinalContrato = "";
                        $miembroConsorcio = "";
                        $observaciones = "";
                        $contrato = "";
                        $objeto = "";
                        $especialidad = "";
                    }
                } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores del formulario
                    $nombreEmpresa = $_POST["nombreEmpresa"];
                    $nombreProyecto = $_POST["nombreProyecto"];
                    $numeroContrato = $_POST["numeroContrato"];
                    $entidad = $_POST["entidad"];
                    $fechaFirma = $_POST["fechaFirma"];
                    $montoContratoOriginal = $_POST["montoContratoOriginal"];
                    $porcentajeParticipacion = $_POST["porcentajeParticipacion"];
                    $adicionalesObra = $_POST["adicionalesObra"];
                    $deductivosObra = $_POST["deductivosObra"];
                    $montoFinalContrato = $_POST["montoFinalContrato"];
                    $miembroConsorcio = $_POST["miembroConsorcio"];
                    $observaciones = $_POST["observaciones"];
                    $contrato = $_POST["contrato"];
                    $objeto = $_POST["objeto"];
                    $especialidad = $_POST["especialidad"];

                    // Verificar acción
                    if ($action == "update") {
                        // Realizar la actualización utilizando el método updateProyecto
                        $proyecto = [
                            'idProyecto' => $idProyecto,
                            'nombre_empresa' => $nombreEmpresa,
                            'nombre_proyecto' => $nombreProyecto,
                            'numero_contrato' => $numeroContrato,
                            'entidad' => $entidad,
                            'fecha_firma' => $fechaFirma,
                            'monto_contrato_original' => $montoContratoOriginal,
                            'porcentaje_de_participacion' => $porcentajeParticipacion,
                            'adicionales_de_la_obra' => $adicionalesObra,
                            'deductivos_de_obra' => $deductivosObra,
                            'monto_final_del_contrato' => $montoFinalContrato,
                            'miembro_del_consorcio' => $miembroConsorcio,
                            'observaciones' => $observaciones,
                            'contrato' => $contrato,
                            'objeto' => $objeto,
                            'especialidad' => $especialidad,
                        ];

                        $actualizado = $dbProyectos->updateProyecto($proyecto);
                        if ($actualizado) {
                            // Actualización exitosa, realizar alguna acción
                        } else {
                            // Error al actualizar, manejar el caso apropiado
                        }
                    } else if ($action == "add") {
                        // Realizar la inserción utilizando el método insertarProyecto
                        $proyecto = [
                            'nombre_empresa' => $nombreEmpresa,
                            'nombre_proyecto' => $nombreProyecto,
                            'numero_contrato' => $numeroContrato,
                            'entidad' => $entidad,
                            'fecha_firma' => $fechaFirma,
                            'monto_contrato_original' => $montoContratoOriginal,
                            'porcentaje_de_participacion' => $porcentajeParticipacion,
                            'adicionales_de_la_obra' => $adicionalesObra,
                            'deductivos_de_obra' => $deductivosObra,
                            'monto_final_del_contrato' => $montoFinalContrato,
                            'miembro_del_consorcio' => $miembroConsorcio,
                            'observaciones' => $observaciones,
                            'contrato' => $contrato,
                            'objeto' => $objeto,
                            'especialidad' => $especialidad,
                        ];

                        $idInsertado = $dbProyectos->insertarProyecto($proyecto);
                        if ($idInsertado) {
                            // Inserción exitosa, realizar alguna acción
                        } else {
                            // Error al insertar, manejar el caso apropiado
                        }
                    } else if ($action == "delete") {
                        // Realizar la eliminación utilizando el método deleteProyecto
                        $eliminado = $dbProyectos->deleteProyecto($idProyecto);
                        if ($eliminado) {
                            // Eliminación exitosa, realizar alguna acción
                        } else {
                            // Error al eliminar, manejar el caso apropiado
                        }
                    }
                }
                ?>
                <form action="?m=panel&mod=proyecto&action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idProyecto" value="<?php echo $idProyecto; ?>">
                    <i class="bi bi-building"></i><span> Nombre Empresa </span>
                    <input required type="text" name="nombreEmpresa" value="<?php echo $nombreEmpresa; ?>">
                    <i class="bi bi-clipboard-data"></i><span> Nombre Proyecto </span>
                    <input required type="text" name="nombreProyecto" value="<?php echo $nombreProyecto; ?>">
                    <i class="bi bi-hash"></i><span> Número de Contrato </span>
                    <input required type="text" name="numeroContrato" value="<?php echo $numeroContrato; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Entidad </span>
                    <input required type="text" name="entidad" value="<?php echo $entidad; ?>">
                    <i class="bi bi-calendar2-check"></i><span> Fecha de Firma </span>
                    <input required type="date" name="fechaFirma" value="<?php echo $fechaFirma; ?>">
                    <i class="bi bi-cash"></i><span> Monto Contrato Original </span>
                    <input required type="text" name="montoContratoOriginal" value="<?php echo $montoContratoOriginal; ?>">
                    <i class="bi bi-percent"></i><span> Porcentaje de Participación </span>
                    <input required type="text" name="porcentajeParticipacion" value="<?php echo $porcentajeParticipacion; ?>">
                    <i class="bi bi-card-checklist"></i><span> Adicionales de la Obra </span>
                    <input required type="text" name="adicionalesObra" value="<?php echo $adicionalesObra; ?>">
                    <i class="bi bi-card-checklist"></i><span> Deductivos de Obra </span>
                    <input required type="text" name="deductivosObra" value="<?php echo $deductivosObra; ?>">
                    <i class="bi bi-cash-stack"></i><span> Monto Final del Contrato </span>
                    <input required type="text" name="montoFinalContrato" value="<?php echo $montoFinalContrato; ?>">
                    <i class="bi bi-people"></i><span> Miembro del Consorcio </span>
                    <input required type="text" name="miembroConsorcio" value="<?php echo $miembroConsorcio; ?>">
                    <i class="bi bi-sticky"></i><span> Observaciones </span>
                    <input required type="text" name="observaciones" value="<?php echo $observaciones; ?>">
                    <i class="bi bi-card-list"></i><span> Contrato </span>
                    <input required type="text" name="contrato" value="<?php echo $contrato; ?>">
                    <i class="bi bi-newspaper"></i><span> Objeto </span>
                    <input required type="text" name="objeto" value="<?php echo $objeto; ?>">
                    <i class="bi bi-newspaper"></i><span> Especialidad </span>
                    <input required type="text" name="especialidad" value="<?php echo $especialidad; ?>">
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
