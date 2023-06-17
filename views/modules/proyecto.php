<?php
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
                "idProyecto"=>$idProyecto,
                "nombre_empresa"=>"",
                "nombre_proyecto"=>"",
                "numero_contrato"=>"",
                "entidad"=>"",
                "fecha_firma"=>"",
                "monto_contrato_original"=>"",
                "porcentaje_de_participacion"=>"",
                "adicionales_de_la_obra"=>"",
                "deductivos_de_obra"=>"",
                "monto_final_del_contrato"=>"",
                "miembro_del_consorcio"=>"",
                "observaciones"=>"",
                "contacto"=>"",
                "objeto"=>"",
                "especialidad"=>""
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
        $hacer = "Eliminar Objeto";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Objeto";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Objeto";
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
    <a href="#" title="Estás aquí" class="active">Proyecto</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>PROYECTO</h3>
        <div class="main">
            <div class="formm">
                
                <form action="?m=panel&mod=proyecto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idProyecto" value="<?= $proyecto["idProyecto"]; ?>">
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="idProyecto" value="<?= $proyecto["idProyecto"]; ?>" <?= $status ?>>
                    <span> Nombre Empresa </span>
                    <select name="nombreEmpresa" value="<?= $proyecto["nombre_empresa"]; ?>"<?= $status ?>>
                            <?php
                            $empresas = $dbEmpresas->selectEmpresas();
                            foreach ($empresas as $empresa) {
                                $selected = ($empresa["idEmpresa"] == $proyecto["nombre_empresa"]) ? "selected" : ""; ?>
                                <option value="<?= $empresa["idEmpresa"] ?>" <?= $selected ?>><?= $empresa["nombreEmpresa"] ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <span> Nombre Proyecto </span>
                    <input required type="text" name="nombreProyecto" value="<?= $proyecto["nombre_proyecto"]; ?>" <?= $status ?>> 
                    <span> Número de Contrato </span>
                    <input required type="text" name="numeroContrato" value="<?= $proyecto["numero_contrato"]; ?>"<?= $status ?>>
                    <span> Entidad </span>
                    <input required type="text" name="entidad" value="<?= $proyecto["entidad"]; ?>"<?= $status ?>>
                    <span> Fecha de Firma </span>
                    <input required type="text"  placeholder="aaaa-mm-dd" name="fechaFirma" value="<?= $proyecto["fecha_firma"]; ?>"<?= $status ?>>
                    <span> Monto Contrato Original </span>
                    <input required type="text" name="montoContratoOriginal" value="<?= $proyecto["monto_contrato_original"]; ?>"<?= $status ?>>
                    <span> Porcentaje de Participación </span>
                    <input required type="text" name="porcentajeParticipacion" value="<?= $proyecto["porcentaje_de_participacion"]; ?>"<?= $status ?>>
                    <span> Adicionales de la Obra </span>
                    <input required type="text" name="adicionalesObra" value="<?= $proyecto["adicionales_de_la_obra"]; ?>"<?= $status ?>>
                    <span> Deductivos de Obra </span>
                    <input required type="text" name="deductivosObra" value="<?= $proyecto["deductivos_de_obra"]; ?>"<?= $status ?>>
                    <span> Monto Final del Contrato </span>
                    <input required type="text" name="montoFinalContrato" value="<?= $proyecto["monto_final_del_contrato"]; ?>"<?= $status ?>>
                    <span> Miembro del Consorcio </span>
                    <input required type="text" name="miembroConsorcio" value="<?= $proyecto["miembro_del_consorcio"]; ?>"<?= $status ?>>
                    <span> Observaciones </span>
                    <input required type="text" name="observaciones" value="<?= $proyecto["observaciones"]; ?>"<?= $status ?>>
                    <span> Contacto </span>
                    <select name="contacto" value="<?= $proyecto["contacto"]; ?>"<?= $status ?>>
                            <?php
                            $contactos = $dbContactos->selectContactos();
                            foreach ($contactos as $contacto) {
                                $selected = ($contacto["idEmpresa"] == $proyecto["contacto"]) ? "selected" : ""; ?>
                                <option value="<?= $contacto["idContacto"] ?>" <?= $selected ?>><?= $contacto["nombre"] ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <span> Objeto </span>
                    <select name="objeto" value="<?= $proyecto["objeto"]; ?>" <?= $status ?>>
                            <?php
                            $objetos = $dbObjetos->selectObjetos();
                            foreach ($objetos as $objeto) {
                                $selected = ($objeto["idEmpresa"] == $proyecto["objeto"]) ? "selected" : ""; ?>
                                <option value="<?= $objeto["idObjeto"] ?>" <?= $selected ?>><?= $objeto["nombre"] ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <span> Especialidad </span>
                    <select name="especialidad" value="<?= $proyecto["especialidad"]; ?>" <?= $status ?>>
                            <?php
                            $especialidades = $dbEspecialidades->selectEspecialidades();
                            foreach ($especialidades as $especialidad) {
                                $selected = ($especialidad["idEspecialidad"] == $proyecto["especialidad"]) ? "selected" : ""; ?>
                                <option value="<?= $especialidad["idEspecialidad"] ?>" <?= $selected ?>><?= $especialidad["nombre"] ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
