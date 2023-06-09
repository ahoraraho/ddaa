<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Actualizaciones</a>
</div>
<?php
validacionIicioSesion();

if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];

    $mensajeMap = [
        '0x10' => array('msj' => "Actualización y PDF Agregados!", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check-circle-fill"),
        '0x11' => array('msj' => "Actualización Agregada, 0 PDF Agregados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-circle"),
        '0x13' => array('msj' => "No se registraron las Actualización ni los PDF", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x20' => array('msj' => "Actualización y PDF Actualizados!", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check-circle-fill"),
        '0x21' => array('msj' => "Actualización Actualizados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-circle"),
        '0x23' => array('msj' => "No se realizaron cambios", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x30' => array('msj' => "Actualización y PDF Eliminados!", 'typeMsj' => "msj-warning", 'iconoAlert' => "bi-info-circle-fill"),
        '0x31' => array('msj' => "Actualización Eliminados", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-check2-circle"),
        '0x33' => array('msj' => "No se Eliminaron los Actualización ni PDF", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

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

/* //////////////////////////  FILTROS  //////////////////////////*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filtro = '';

    $buscarTipo = $_POST["buscarTipo"];

    $actualizaciones = $dbActualizaciones->filtrarActualizacion($buscarTipo);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
    $actualizaciones = $dbActualizaciones->buscarActualizacion($busqueda);
    /* //////////////////////////  Barra de busqueda  //////////////////////////*/
} else {
    $actualizaciones = $dbActualizaciones->selectActualizaciones();
}
$contador = count($actualizaciones);
?>

<h2>ACTUALIZACIONES</h2>
<div class="numm">
    <div class="f1">
        <form class="from_input" action="" method="GET">
            <!-- para agregar la vista de ?m=productos en la url -->
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="actualizaciones">
            <!-- concatenando el valor a buscar -->
            <input type="text" name="buscar" value="" placeholder="Buscar...">
            <!-- <input type="submit" value="BUSCAR"> -->
            <button class="btn-buscador" type="submit"><i class="bi-search"></i></button>
        </form>
        <span class="f-s"><?= $contador ?></span>
    </div>
    <div class="f2">
        <a href="?m=panel&mod=prodds" class="btn-main">Tipos</a>
        <a href="?m=panel&mod=actualizacion&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Actualización</span>
        </a>
    </div>
</div>

<div class="filtros">
    <form class="order-nav" name="filtros" action="?m=panel&mod=actualizaciones" method="POST">
        <div class="contenedor-select">
            <div class="conteneFilto">
                <strong><i class="bi bi-funnel-fill"></i>...FILTROS...<i class="bi bi-filter-circle-fill"></i></strong>
            </div>
        </div>
        <!-- Tipo -->
        <div class="contenedor-select">
            <select name="buscarTipo" id="buscarTipo">
                <option value="">Tipo de actualización</option> <!-- Agrega la opción predeterminada -->
                <?php
                $selectedTipo = $_POST["buscarTipo"]; // Obtén el valor seleccionado por el usuario
                $tipos = $dbActualizaciones->selectTipos();
                foreach ($tipos as $tipo) {
                    $idActual = $tipo["idActual"];
                    $nombre = $tipo["nombre"];
                    $selected = ($selectedTipo == $idActual) ? 'selected' : '';
                    echo '<option value="' . $idActual . '" ' . $selected . '>' . $nombre . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="contenedor-select">
            <button type="submit" class="btn-filtrador">Filtrar</button>
        </div>
    </form>
</div>

<!-- tabla objetos -->
<div class="contenido-tabla">
    <table class="responsive-actualizaciones">
        <thead>
            <tr>
                <th style="width: 25px;">#</th>
                <th style="text-align: start;">Descripción</th>
                <th style="width: 182px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actualizaciones as $actualizacion) {
                // $archivo = null;
                $id = $actualizacion['idActualizacion'];
                $descripcion = $actualizacion['descripcion'];
                $archivo = $actualizacion['archivo'];
                $tieneArchivo = isset($archivo) && !empty($archivo);
            ?>
                <tr onclick="window.location.href='?m=panel&mod=actualizacion&action=view&id=<?= $id ?>'">
                    <td><?= $id ?></td>
                    <td style="max-width: 1000px;"><?= $descripcion ?></td>
                    <td style="text-align: end; width: auto;">
                        <?php if ($tieneArchivo) { ?>
                            <a title="Ver" target="_blank" href="pdfsActualizaciones/<?= $archivo ?>" onclick="event.stopPropagation();">
                                <i class="view bi bi-file-earmark-pdf"></i>
                            </a>
                            <a title="Descargar" href="?m=panel&mod=actualizaciones&file=<?= $archivo ?>">
                                <i class="donwload bi bi-download"></i>
                            </a>
                        <?php } ?>

                        <a href="?m=panel&mod=actualizacion&action=update&id=<?= $id ?>" title="Modificar">
                            <i class="edid bi-pencil-square"></i>
                        </a>
                        <a href="?m=panel&mod=actualizacion&action=delete&id=<?= $id ?>" title="Eliminar">
                            <i class="delete bi-trash"></i>
                        </a>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</div>

<!-- <div class="piePagina">
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
</div> -->