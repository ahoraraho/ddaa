<?php
validacionIicioSesion();

mensaje('Tipo Actualización', 'o');
?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=actualizaciones" title="Ir a Actulizaciones">Actualizaciones</a>
    <a href="#" title="Estas justo aqui" class="active">Tipos de Actualizaciones</a>
</div>


<h3>Tipos de Actualizaciones</h3>
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
        <a href="?m=panel&mod=prodd&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nuevo Tipo de Actualización</span>
        </a>
    </div>
</div>

<!-- tabla prodd -->
<div class="contenido-tabla">
    <table class="responsive-objetos">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre de tipo</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $prodds = $dbProdds->selectProdds();

            foreach ($prodds as $prodd) {
                $id = $prodd['idActual'];
                $nombre = $prodd['nombre'];
            ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $nombre ?></td>
                    <td>
                        <a href="?m=panel&mod=prodd&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"><b> </i></a>
                        <a href="?m=panel&mod=prodd&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash"><b></i></a>
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