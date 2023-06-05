<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Documentos</a>
</div>

<h3>DOCUMENTOS</h3>
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
        <!-- <a href="?m=panel&mod=categoria&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Documento</span>
        </a> -->
    </div>
</div>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-categorias">
        <thead>
            <tr>
                <th>Id Documento</th>
                <th>Acta</th>
                <th>constancia</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
            /*==========================================================================*/
            /*                   Consulta de base de datos para tabla                   */
            /*==========================================================================*/
            $consulta = "SELECT * FROM documentos";
            $resultado = $conexion->query($consulta);
            if($resultado->num_rows > 0){
                while($row = $resultado->fetch_assoc()){
                    $idDocumento = $row["idDocumento"];
                    $acta_de_recepcion = $row["acta_de_recepcion"];
                    $resolucion_de_obra = $row["resolucion_de_obra"];
                    $resolucion_deductivos = $row["resolucion_deductivos"];
                    $resolucion_adicionales = $row["resolucion_adicionales"];
                    $anexo_de_promesa_de_consorcio = $row["anexo_de_promesa_de_consorcio"];
                    $constancia = $row["constancia"];
                    $contrato_de_consorcio = $row["contrato_de_consorcio"];
                    $contrato = $row["contrato"];
                    echo "<tr>";
                    echo "<td>". $idDocumento ."</td>";
                    echo "<td>". $acta_de_recepcion ."</td>";
                    echo "<td>". $constancia ."</td>";
                    echo "<td> <a href='?m=panel&mod=categoria&action=update&id=". $idDocumento ."' title='Modificar'><i class='edid bi-pencil-square'><b></i></a>";
                    echo "<a href='?m=panel&mod=categoria&action=delete&id=". $idDocumento ."' title='Eliminar'><i class='delete bi-trash'><b></i></a> </td>";
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