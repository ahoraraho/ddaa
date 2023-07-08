<?php
validacionIicioSesion();

mensaje('Proyecto');

?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Proyectos</a>
</div>


<h3>PROYECTOS</h3>
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
            <i class="abi bi bi-plus-square"></i><span>Nueva Proyecto</span>
        </a>
    </div>
</div>
<!-- FILTROS -->
<div class="filtros">
    <div class="f1">
        <form action="?m=panel&mod=proyectos" method="POST">
            <h3>Filtros:</h3>
            <!--Empresa-->
            <select name="buscarEmpresa" id="buscarEmpresa">
                <option>Empresa</option>
                <?php
                $empresas = $dbEmpresas->selectEmpresas();
                if ($_POST["buscarEmpresa"] != '') {
                    echo '<option value="' . $_POST["buscarEmpresa"] . '">' . $_POST["buscarEmpresa"] . '</option>';
                }
                foreach ($empresas as $empresa) {
                    $idEmpresa = $empresa["idEmpresa"];
                    $nombre = $empresa["nombreEmpresa"];
                    echo '<option value="' . $idEmpresa . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <!--contacto-->
            <select name="buscarContacto" id="buscarContacto">
                <option>Contacto</option>
                <?php
                $contactos = $dbContactos->selectContactos();
                if ($_POST["buscarContacto"] != '') {
                    echo '<option value="' . $_POST["buscarContacto"] . '">' . $_POST["buscarContacto"] . '</option>';
                }
                foreach ($contactos as $contacto) {
                    $idContacto = $contacto["idContacto"];
                    $nombre = $contacto["nombre"];
                    echo '<option value="' . $idContacto . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <!--objetos-->
            <select name="buscarObjeto" id="buscarObjeto">
                <option>Objeto</option>
                <?php
                $objetos = $dbObjetos->selectObjetos();
                if ($_POST["buscarObjeto"] != '') {
                    echo '<option value="' . $_POST["buscarObjeto"] . '">' . $_POST["buscarObjeto"] . '</option>';
                }
                foreach ($objetos as $objeto) {
                    $idObjeto = $objeto["idObjeto"];
                    $nombre = $objeto["nombre"];
                    echo '<option value="' . $idObjeto . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <!--Especialidad-->
            <select name="buscarEspecialidad" id="buscarEspecialidad">
                <option>Especialidad</option>
                <?php
                $especialidades = $dbEspecialidades->selectEspecialidades();
                if ($_POST["buscarEspecialidad"] != '') {
                    echo '<option value="' . $_POST["buscarEspecialidad"] . '">' . $_POST["buscarEspecialidad"] . '</option>';
                }
                foreach ($especialidades as $especialidad) {
                    $idEspecialidad = $especialidad["idEspecialidad"];
                    $nombre = $especialidad["nombre"];
                    echo '<option value="' . $idEspecialidad . '">' . $nombre . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="form_login">Filtrar</button>
        </form>
    </div>
</div>

<?php
/* //////////////////////////  FILTROS  //////////////////////////*/
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

            //$proyectos = $dbProyectos->filtrarProyecto($_POST["buscarEmpresa"],$_POST["buscarContacto"],$_POST["buscarObjeto"],$_POST["buscarEspecialidad"]);

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
                <tr>
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
                        <a href="?m=panel&mod=proyecto&action=update&id=<?= $id ?>" title="Modificar"><i
                                class="edid bi-pencil-square"><b> </i></a>
                        <a href="?m=panel&mod=proyecto&action=delete&id=<?= $id ?>" title="Eliminar"><i
                                class="delete bi-trash"><b></i></a>
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