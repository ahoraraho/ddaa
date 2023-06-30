<?php
if (!$_SESSION["Usuario"]) {
    header('location: ./');
    exit;
}

if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
        case '0x10':
            $msj = "Actualización agregado!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check-circle";
            break;
        case '0x20':
            $msj = "Actualización actualizado!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check2-circle";
            break;
        case '0x30':
            $msj = "Actualización eliminado!";
            $typeMsj = "msj-warning";
            $iconoAlert = "bi-info-circle";
            break;
        case '0x1000':
            $msj = "Hubo un error al intentar realizar la operación!";
            $typeMsj = "msj-error";
            $iconoAlert = "bi-bug";
            break;
    }
    alertaResponDialog($typeMsj, $msj, $iconoAlert);
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
?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Actualizaciones</a>
</div>


<h3>Actualizaciones</h3>
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
        <a href="?m=panel&mod=actualizacion&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Actualización</span>
        </a>
    </div>
</div>

<!-- tabla objetos -->
<div class="contenido-tabla">
    <table class="table-actualizaciones">
        <thead>
            <tr>
                <th style="width: 25px;">#</th>
                <th style="text-align: start;">Descripción</th>
                <th style="text-align: end;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $actualizaciones = $dbActualizaciones->selectActualizaciones();

            foreach ($actualizaciones as $actualizacion) {
                $id = $actualizacion['idActualizacion'];
                $descripcion = $actualizacion['descripcion'];
                $archivo = $actualizacion['archivo'];
            ?>
                <tr>
                    <td><?= $id ?></td>
                    <td style="text-align: start;   width: max-content;"><?= $descripcion ?></td>
                    <td style="text-align: end;   width: min-content;">
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