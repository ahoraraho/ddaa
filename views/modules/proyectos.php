<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Proyectos</a>
</div>
<?php
validacionIicioSesion();

if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];

    $mensajeMap = [
        '0x10' => array('msj' => "Datos y Archivos Agregados!", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check-circle-fill"),
        '0x11' => array('msj' => "Datos Agregada, 0 archivos Agregados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-circle"),
        '0x12' => array('msj' => "Datos Agregada y Algunos Archivos agregados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-square"),
        '0x13' => array('msj' => "No se registraron los Datos ni los Archivos", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x20' => array('msj' => "Datos y Archivos Actualizados!", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check-circle-fill"),
        '0x21' => array('msj' => "Datos Actualizados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-circle"),
        '0x22' => array('msj' => "Archivos Actualizados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-square"),
        '0x23' => array('msj' => "No se realizaron cambios", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x30' => array('msj' => "Datos y Archivos Eliminados!", 'typeMsj' => "msj-warning", 'iconoAlert' => "bi-info-circle-fill"),
        '0x31' => array('msj' => "Datos Eliminados", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-check2-circle"),
        '0x32' => array('msj' => "Archivos Eliminados", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-check2-square"),
        '0x33' => array('msj' => "No se Eliminaron los datos ni archivos", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x000' => array('msj' => "Hubo un error al intentar realizar la operación!", 'typeMsj' => "msj-error", 'iconoAlert' => "bi-bug-fill")
    ];

    if (isset($mensajeMap[$msj])) {
        $mensaje = $mensajeMap[$msj];
        $msj = $mensaje['msj'];
        $typeMsj = $mensaje['typeMsj'];
        $iconoAlert = $mensaje['iconoAlert'];
        alertaResponDialog($typeMsj, $msj, $iconoAlert);
    }
}
?>
<h2>PROYECTOS</h2>
<div class="numm">
    <div class="f1">
        <form class="from_input" action="" method="GET">
            <!-- para agregar la vista de ?m=productos en la url -->
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="categorias">
            <!-- concatenando el valor a buscar -->
            <input type="text" name="buscar" value="" placeholder="Buscar...">
            <!-- <input type="submit" value="BUSCAR"> -->
            <button class="btn-buscador" type="submit"><i class="bi-search"></i></button>
        </form>
        <span class="f-s">15</span>
    </div>
    <div class="f2">
        <a href="?m=panel&mod=proyecto&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nuevo Proyecto</span>
        </a>
    </div>
</div>
<div class="numm">
    <div class="f1">
        <form name="filtros" action="?m=panel&mod=proyectos" method="POST">
            <h3>Filtros:</h3>
            <!--Empresa-->
            <select name="buscarEmpresa" id="buscarEmpresa">
                <option value="">Empresas</option> <!-- Agrega la opción predeterminada -->
                <?php
                if ($_POST["buscarEmpresa"] != '') {
                    echo '<option value="' . $_POST["buscarEmpresa"] . '">' . $_POST["buscarEmpresa"] . '</option>';
                }
                $empresas = $dbEmpresas->selectEmpresas();
                foreach ($empresas as $empresa) {
                    $idEmpresa = $empresa["idEmpresa"];
                    $nombre = $empresa["nombreEmpresa"];
                    echo '<option value="' . $idEmpresa . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <!--contacto-->
            <select name="buscarContacto" id="buscarContacto">
                <option value="">Contactos</option> <!-- Agrega la opción predeterminada -->
                <?php
                if ($_POST["buscarContacto"] != '') {
                    echo '<option value="' . $_POST["buscarContacto"] . '">' . $_POST["buscarContacto"] . '</option>';
                }
                $contactos = $dbContactos->selectContactos();
                foreach ($contactos as $contacto) {
                    $idContacto = $contacto["idContacto"];
                    $nombre = $contacto["nombre"];
                    echo '<option value="' . $idContacto . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <!--objetos-->
            <select name="buscarObjeto" id="buscarObjeto">
                <option value="">Objetos</option> <!-- Agrega la opción predeterminada -->
                <?php
                if ($_POST["buscarObjeto"] != '') {
                    echo '<option value="' . $_POST["buscarObjeto"] . '">' . $_POST["buscarObjeto"] . '</option>';
                }
                $objetos = $dbObjetos->selectObjetos();
                foreach ($objetos as $objeto) {
                    $idObjeto = $objeto["idObjeto"];
                    $nombre = $objeto["nombre"];
                    echo '<option value="' . $idObjeto . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <!--Especialidad-->
            <select name="buscarEspecialidad" id="buscarEspecialidad">
                <option value="">Especialidades</option> <!-- Agrega la opción predeterminada -->
                <?php
                if ($_POST["buscarEspecialidad"] != '') {
                    echo '<option value="' . $_POST["buscarEspecialidad"] . '">' . $_POST["buscarEspecialidad"] . '</option>';
                }
                $especialidades = $dbEspecialidades->selectEspecialidades();
                foreach ($especialidades as $especialidad) {
                    $idEspecialidad = $especialidad["idEspecialidad"];
                    $nombre = $especialidad["nombre"];
                    echo '<option value="' . $idEspecialidad . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="button-link btn-new f-e">Filtrar</button>
        </form>
    </div>
</div>


<?php
/* //////////////////////////  FILTROS  //////////////////////////*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filtro = '';

    $buscarEmpresa = $_POST["buscarEmpresa"];
    $buscarContacto = $_POST["buscarContacto"];
    $buscarObjeto = $_POST["buscarObjeto"];
    $buscarEspecialidad = $_POST["buscarEspecialidad"];

    if ($buscarEmpresa != '' && $buscarContacto == '' && $buscarObjeto == '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto != '' && $buscarObjeto == '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.contacto = '" . $buscarContacto . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto == '' && $buscarObjeto != '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.objeto = '" . $buscarObjeto . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto == '' && $buscarObjeto == '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.especialidad = '" . $buscarEspecialidad . "'";
    } elseif ($buscarEmpresa != '' && $buscarContacto != '' && $buscarObjeto == '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "' AND p.contacto = '" . $buscarContacto . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto != '' && $buscarObjeto != '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.contacto = '" . $buscarContacto . "' AND p.objeto = '" . $buscarObjeto . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto == '' && $buscarObjeto != '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.objeto = '" . $buscarObjeto . "' AND p.especialidad = '" . $buscarEspecialidad . "'";
    } elseif ($buscarEmpresa != '' && $buscarContacto == '' && $buscarObjeto == '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "' AND p.especialidad = '" . $buscarEspecialidad . "'";
    } elseif ($buscarEmpresa != '' && $buscarContacto == '' && $buscarObjeto != '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "' AND p.objeto = '" . $buscarObjeto . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto != '' && $buscarObjeto == '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.contacto = '" . $buscarContacto . "' AND p.especialidad = '" . $buscarEspecialidad . "'";
    } elseif ($buscarEmpresa != '' && $buscarContacto != '' && $buscarObjeto != '' && $buscarEspecialidad == '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "' AND p.contacto = '" . $buscarContacto . "' AND p.objeto = '" . $buscarObjeto . "'";
    } elseif ($buscarEmpresa != '' && $buscarContacto != '' && $buscarObjeto == '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "' AND p.contacto = '" . $buscarContacto . "' AND p.especialidad = '" . $buscarEspecialidad . "'";
    } elseif ($buscarEmpresa != '' && $buscarContacto == '' && $buscarObjeto != '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.nombre_empresa = '" . $buscarEmpresa . "' AND p.objeto = '" . $buscarObjeto . "' AND p.especialidad = '" . $buscarEspecialidad . "'";
    } elseif ($buscarEmpresa == '' && $buscarContacto != '' && $buscarObjeto != '' && $buscarEspecialidad != '') {
        $filtro = "WHERE p.contacto = '" . $buscarContacto . "' AND p.objeto = '" . $buscarObjeto . "' AND p.especialidad = '" . $buscarEspecialidad . "'";
    }
} else {
    $filtro = '';
}

$consulta = "SELECT *, e.nombreEmpresa AS NomEmpresa FROM proyectos p INNER JOIN empresa e ON p.nombre_empresa = e.idEmpresa $filtro";
$resultado = mysqli_query($conexion, $consulta);

$proyectos = array();

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $proyectos[] = $fila;
    }
    mysqli_free_result($resultado);
}

?>

<div class="contenido-tabla">
    <table class="responsive-proyectos">
        <thead>
            <tr>
                <th>Id Proyecto</th>
                <th>Nombre de Empresa</th>
                <th>Nombre de Proyecto</th>
                <th>Numero de contrato</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php

            //$proyectos = $dbProyectos->selectProyectos();

            foreach ($proyectos as $proyecto) {
                $id = $proyecto['idProyecto'];
                $nombre_empresa = $proyecto['NomEmpresa'];
                $nombre_proyecto = $proyecto['nombre_proyecto'];
                $numero_contrato = $proyecto['numero_contrato'];
                $entidad = $proyecto['entidad'];
                $fecha_firma = $proyecto['fecha_firma'];
                $monto_contrato_original = $proyecto['monto_contrato_original'];
                $porcentaje_de_participacion = $proyecto['porcentaje_de_participacion'];
                $adicionales_de_la_obra = $proyecto['adicionales_de_la_obra'];
                $deductivos_de_obra = $proyecto['deductivos_de_obra'];
                $monto_final_del_contrato = $proyecto['monto_final_del_contrato'];
                $miembro_del_consorcio = $proyecto['miembro_del_consorcio'];
                $observaciones = $proyecto['observaciones'];
                $contacto = $proyecto['contacto'];
                $objeto = $proyecto['objeto'];
                $especialidad = $proyecto['especialidad'];
            ?>
                <tr onclick="window.location.href='?m=panel&mod=proyecto&action=view&id=<?= $id ?>'">
                    <td>
                        <?= $id ?>
                    </td>
                    <td>
                        <?= $nombre_empresa ?>
                    </td>
                    <td>
                        <?= $nombre_proyecto ?>
                    </td>
                    <td>
                        <?= $numero_contrato ?>
                    </td>
                    <td>
                        <a href="?m=panel&mod=proyecto&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"></i></a>
                        <a href="?m=panel&mod=proyecto&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="piePagina">
    <div class="derecha">
        <form class="num_paginas--filtro" action="" method="GET">
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="categorias">
            <input type="hidden" name="buscar" value="<?= $filtro ?>">
            <input type="hidden" name="orden" value="<?= $orden ?>">
            <select class="form-select" name="limite">
                <option value="15">15</option>
                <option value="10">10</option>
                <option value="5">5</option>
            </select>
            <button onclick="filtrardorAlfabeto()" title="Numero de productos" class="btn-filtro-num" type="submit">
                <i class="bi bi-sliders"></i>
            </button>
        </form>
    </div>
    <div class="izquierda">
        <?php
        //createPaginationLogueado($paginas_total, $pagina, $filtro, $orden, $limite, "categorias");
        ?>
    </div>
</div>