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

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-categorias">
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
            /*==========================================================================*/
            /*                   Consulta de base de datos para tabla                   */
            /*==========================================================================*/
            $consulta = "SELECT * FROM proyectos";
            $resultado = $conexion->query($consulta);
            if($resultado->num_rows > 0){
                while($row = $resultado->fetch_assoc()){
                    $idProyecto = $row["idProyecto"];
                    $nombre_empresa = $row["nombre_empresa"];
                    $nombre_proyecto = $row["nombre_proyecto"];
                    $numero_contrato = $row["numero_contrato"];
                    $entidad = $row["entidad"];
                    $fecha_firma = $row["fecha_firma"];
                    $monto_contrato_original = $row["monto_contrato_original"];
                    $porcentaje_de_participacion = $row["porcentaje_de_participacion"];
                    $adicionales_de_la_obra = $row["adicionales_de_la_obra"];
                    $deductivos_de_obra = $row["deductivos_de_obra"];
                    $monto_final_del_contrato = $row["monto_final_del_contrato"];
                    $miembro_del_consorcio = $row["miembro_del_consorcio"];
                    $observaciones = $row["observaciones"];
                    $contacto = $row["contacto"];
                    $objeto = $row["objeto"];
                    $especialidad = $row["especialidad"];

                    echo "<tr>";
                    echo "<td>". $idProyecto ."</td>";
                    echo "<td>". $nombre_empresa ."</td>";
                    echo "<td>". $nombre_proyecto ."</td>";
                    echo "<td>". $numero_contrato ."</td>";
                    echo "<td> <a href='?m=panel&mod=categoria&action=update&id=". $idContacto ."' title='Modificar'><i class='edid bi-pencil-square'><b></i></a>";
                    echo "<a href='?m=panel&mod=categoria&action=delete&id=". $idContacto ."' title='Eliminar'><i class='delete bi-trash'><b></i></a> </td>";
                    echo "</tr>";
                }
            } 
        ?>
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
                <option  value="15">15</option>
                <option  value="10">10</option>
                <option  value="5">5</option>
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