<?php
validacionIicioSesion();
mensaje('Actualización', 'a');

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
?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Actualizaciones</a>
</div>


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
        <span class="f-s">15</span>
    </div>
    <div class="f2">
        <a href="?m=panel&mod=prodds" class="btn-main">Tipos</a>
        <a href="?m=panel&mod=actualizacion&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Actualización</span>
        </a>
    </div>
</div>

<div class="numm">
    <div class="f1">
        <form name="filtros" action="?m=panel&mod=actualizaciones" method="POST">
            <h3>Filtros:</h3>
            <!-- Tipo -->
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
            <button type="submit" class="button-link btn-new f-e">Filtrar</button>
        </form>

    </div>
</div>

<?php
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
?>

<!-- tabla objetos -->
<div class="contenido-tabla">
    <table class="responsive-actualizaciones">
        <thead>
            <tr>
                <th style="width: 25px;">#</th>
                <th style="text-align: start;">Descripción</th>
                <th style="text-align: end;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($actualizaciones as $actualizacion) {
                $id = $actualizacion['idActualizacion'];
                $descripcion = $actualizacion['descripcion'];
                $archivo = $actualizacion['archivo'];
                ?>
                <tr onclick="window.location.href='?m=panel&mod=actualizacion&action=view&id=<?= $id ?>'">
                    <td>
                        <?= $id ?>
                    </td>
                    <td>
                        <?= $descripcion ?>
                    </td>
                    <td style="text-align: end;   width: auto;">
                        <a title="Ver" target="_blank" href="pdfsActualizaciones/<?= $archivo ?>">
                            <i class="view bi bi-file-earmark-pdf"></i>
                        </a>
                        <a title="Descargar" href="?m=panel&mod=actualizaciones&file=<?= $archivo ?>">
                            <i class="donwload bi bi-download"></i>
                        </a>
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