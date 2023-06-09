<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Procesos</a>
</div>

<?php
validacionIicioSesion();

mensaje('Proceso', 'o');
/* //////////////////////////  FILTROS  //////////////////////////*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filtro = '';

    $buscarPostor = $_POST["buscarPostor"];
    $buscarEncargado = $_POST["buscarEncargado"];
    $buscarObjeto = $_POST["buscarObjeto"];

    $procesos = $dbProcesos->filtrarProceso($buscarPostor, $buscarEncargado, $buscarObjeto);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
    $procesos = $dbProcesos->buscarProceso($busqueda);
    /* //////////////////////////  Barra de busqueda  //////////////////////////*/
} else {
    $procesos = $dbProcesos->selectProcesos();
}
$contador = count($procesos);
?>

<h2>PROCESOS</h2>
<div class="numm">
    <div class="f1">
        <form class="from_input" action="" method="GET">
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="procesos">
            <input type="text" name="buscar" value="" placeholder="Buscar...">
            <button class="btn-buscador" type="submit"><i class="bi-search"></i></button>
        </form>
        <span class="f-s"><?= $contador ?></span>
    </div>
    <div class="f2">
        <a href="?m=panel&mod=proceso&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Proceso</span>
        </a>
    </div>
</div>

<div class="filtros">
    <form class="order-nav" name="filtros" action="?m=panel&mod=procesos" method="POST">
        <div class="contenedor-select">
            <div class="conteneFilto">
                <strong><i class="bi bi-funnel-fill"></i>...FILTROS...<i class="bi bi-filter-circle-fill"></i></strong>
            </div>
        </div>
        <!-- Postores -->
        <div class="contenedor-select">
            <select name="buscarPostor" id="buscarPostor">
                <option value="">Todos los Postores</option> <!-- Agrega la opción predeterminada -->
                <?php
                $selectedPostor = $_POST["buscarPostor"]; // Obtén el valor seleccionado por el usuario
                $empresas = $dbEmpresas->selectEmpresas();
                foreach ($empresas as $empresa) {
                    $idEmpresa = $empresa["idEmpresa"];
                    $nombreEmpresa = $empresa["nombreEmpresa"];
                    $selected = ($selectedPostor == $idEmpresa) ? 'selected' : '';
                    echo '<option value="' . $idEmpresa . '" ' . $selected . '>' . $nombreEmpresa . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Encargado -->
        <div class="contenedor-select">
            <select name="buscarEncargado" id="buscarEncargado">
                <option value="">Todos los Encargados</option> <!-- Agrega la opción predeterminada -->
                <?php
                $selectedEncargado = $_POST["buscarEncargado"]; // Obtén el valor seleccionado por el usuario
                $especialistas = $dbEspecialistas->selectEspecialistas();
                foreach ($especialistas as $especialista) {
                    $idEspecialista = $especialista["idEspecialista"];
                    $nombreEspecialista = $especialista["nombre"];
                    $selected = ($selectedEncargado == $idEspecialista) ? 'selected' : '';
                    echo '<option value="' . $idEspecialista . '" ' . $selected . '>' . $nombreEspecialista . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Objetos -->
        <div class="contenedor-select">
            <select name="buscarObjeto" id="buscarObjeto">
                <option value="">Todos los Objetos</option> <!-- Agrega la opción predeterminada -->
                <?php
                $selectedObjeto = $_POST["buscarObjeto"]; // Obtén el valor seleccionado por el usuario
                $objetos = $dbObjetos->selectObjetos();
                foreach ($objetos as $objeto) {
                    $idObjeto = $objeto["idObjeto"];
                    $nombreObjeto = $objeto["nombre"];
                    $selected = ($selectedObjeto == $idObjeto) ? 'selected' : '';
                    echo '<option value="' . $idObjeto . '" ' . $selected . '>' . $nombreObjeto . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="contenedor-select">
            <button type="submit" class="btn-filtrador">Filtrar</button>
        </div>
    </form>
</div>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-procesos">
        <thead>
            <tr>
                <th># Proceso</th>
                <th>Entidad</th>
                <th>Nombre clave</th>
                <th>Postores</th>
                <th>Encargado</th>
                <th style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($procesos as $proceso) {
                $id = $proceso['numProceso'];
                $entidad = $proceso['entidad'];
                $nomenclatura = $proceso['nomenclatura'];
                $nombreClave = $proceso['nombreClave'];
                $consultas = $proceso['consultas'];
                $integracion = $proceso['integracion'];
                $presentacion = $proceso['presentacion'];
                $buenaPro = $proceso['buenaPro'];
                $valorReferencial = $proceso['valorReferencial'];
                $postores = $proceso['nomPostor'];
                $encargado = $proceso['nomEncargado'];
                $objeto = $proceso['nomObjeto'];
                $observaciones = $proceso['observaciones'];
            ?>
                <tr onclick="window.location.href='?m=panel&mod=proceso&action=view&id=<?= $id ?>'">
                    <td>
                        <?= $id ?>
                    </td>
                    <td>
                        <?= $entidad ?>
                    </td>
                    <td>
                        <?= $nombreClave ?>
                    </td>
                    <td>
                        <?= $postores ?>
                    </td>
                    <td>
                        <?= $encargado ?>
                    </td>
                    <td>
                        <a href="?m=panel&mod=proceso&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"></i></a>
                        <a href="?m=panel&mod=proceso&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash"></i></a>
                    </td>
                </tr>
        </tbody>
    <?php } ?>
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