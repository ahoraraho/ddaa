<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Usuarios</a>
</div>

<?php

if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
    exit;
}

mensaje('Especialista', 'a');
?>
<?php
/* //////////////////////////  FILTROS  //////////////////////////*/
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
    $especialistas = $dbEspecialistas->buscarEspecialista($busqueda);
    /* //////////////////////////  Barra de busqueda  //////////////////////////*/
} else {
    $especialistas = $dbEspecialistas->selectEspecialistas();
}
$contador = count($especialistas);
?>


<h2>USUARIOS</h2>
<div class="numm">
    <div class="f1">
        <form class="from_input" action="" method="GET">
            <!-- para agregar la vista de ?m=productos en la url -->
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="usuarios">
            <!-- concatenando el valor a buscar -->
            <input type="text" name="buscar" value="" placeholder="Buscar...">
            <!-- <input type="submit" value="BUSCAR"> -->
            <button class="btn-buscador" type="submit"><i class="bi-search"></i></button>
        </form>
        <span class="f-s"><?= $contador ?></span>
    </div>
    <div class="f2">
        <a href="?m=panel&mod=usuario&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Usuario</span>
        </a>
    </div>
</div>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-usuarios">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Celular</th>
                <th style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($especialistas as $especialista) {
                $id = $especialista['idEspecialista'];
                $dni = $especialista['dni'];
                $nombre = $especialista['nombre'];
                $apellido = $especialista['apellido'];
                $cargo = $especialista['cargo'];
                $direccion = $especialista['direccion'];
                $telefono = $especialista['telefono'];
            ?>

                <tr onclick="window.location.href='?m=panel&mod=usuario&action=view&id=<?= $id ?>'">
                    <td><?= $id ?></td>
                    <td><?= $nombre ?></td>
                    <td><?= $apellido ?></td>
                    <td><?= $telefono ?></td>
                    <td>
                        <a href="?m=panel&mod=usuario&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"></i></a>
                        <a href="?m=panel&mod=usuario&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash"></i></a>
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