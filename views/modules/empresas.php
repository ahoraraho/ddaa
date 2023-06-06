<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Empresas</a>
</div>

<?php

$id = 12;
?>

<h3>EMPRESAS</h3>
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
        <a href="?m=panel&mod=empresa&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Empresa</span>
        </a>
    </div>
</div>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-empresas">
        <thead>
            <tr>
                <th>Id de Empresa</th>
                <th>Nombre Empresa</th>
                <th>RUC</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
<<<<<<< HEAD
        <?php
            /*==========================================================================*/
            /*                   Consulta de base de datos para tabla                   */
            /*==========================================================================*/
            $consulta = "SELECT * FROM empresa";
            $resultado = $conexion->query($consulta);
            if($resultado->num_rows > 0){
                while($row = $resultado->fetch_assoc()){
                    $idEmpresa = $row["idEmpresa"];
                    $nombreEmpresa = $row["nombreEmpresa"];
                    $ruc = $row["ruc"];
                    $telefono = $row["telefono"];
                    $email = $row["email"];
                    echo "<tr>";
                    echo "<td>". $idEmpresa ."</td>";
                    echo "<td>". $nombreEmpresa ."</td>";
                    echo "<td>". $ruc ."</td>";
                    echo "<td>". $telefono ."</td>";
                    echo "<td>". $email ."</td>";
                    echo "<td> <a href='?m=panel&mod=categoria&action=update&id=". $idEmpresa ."' title='Modificar'><i class='edid bi-pencil-square'><b></i></a>";
                    echo "<a href='?m=panel&mod=categoria&action=delete&id=". $idEmpresa ."' title='Eliminar'><i class='delete bi-trash'><b></i></a> </td>";
                    echo "</tr>";
                }
            } 
        ?>
=======


            <tr>
                <td>1</td>
                <td>Pat's inc.</td>
                <td>744584855</td>
                <td>99999999</td>
                <td>correo@gmai.com</td>
                <td>
                    <a href="?m=panel&mod=empresa&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"><b> </i></a>
                    <a href="?m=panel&mod=empresa&action=delete&id=3" title="Eliminar"><i class="delete bi-trash"><b></i></a>
                </td>
            </tr>
>>>>>>> f82086df92b934ecdcd3893748a1712b13a22a48
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