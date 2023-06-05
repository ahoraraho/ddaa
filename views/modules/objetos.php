<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Objetos</a>
</div>

<h3>OBJETOS</h3>
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
        <a href="?m=panel&mod=objeto&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Objeto</span>
        </a>
    </div>
</div>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-categorias">
        <thead>
            <tr>
                <th>Id Objeto</th>
                <th>Nombre del Objeto</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
            /*==========================================================================*/
            /*                   Consulta de base de datos para tabla                   */
            /*==========================================================================*/
            $consulta = "SELECT * FROM objeto";
            $resultado = $conexion->query($consulta);
            if($resultado->num_rows > 0){
                while($row = $resultado->fetch_assoc()){
                    $idObjeto = $row["idObjeto"];
                    $nombreObjeto = $row["nombre"];
                    echo "<tr>";
                    echo "<td>". $idObjeto ."</td>";
                    echo "<td>". $nombreObjeto ."</td>";
                    echo "<td> <a href='?m=panel&mod=categoria&action=update&id=". $idObjeto ."' title='Modificar'><i class='edid bi-pencil-square'><b></i></a>";
                    echo "<a href='?m=panel&mod=categoria&action=delete&id=". $idObjeto ."' title='Eliminar'><i class='delete bi-trash'><b></i></a> </td>";
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