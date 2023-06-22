<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Documentos</a>
</div>

<?php
if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
        case '0x10':
            $msj = "Objeto agregado!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check-circle";
            break;
        case '0x20':
            $msj = "Objeto actualizado!";
            $typeMsj = "msj-ok";
            $iconoAlert = "bi-check2-circle";
            break;
        case '0x30':
            $msj = "Objeto eliminado!";
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

?>

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
    <div class="f2">
        <a href="?m=panel&mod=documento&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Documento</span>
        </a>
    </div>
        <!-- <a href="?m=panel&mod=categoria&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Documento</span>
        </a> -->
    </div>
</div>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="tabla-responsive">
        <thead>
            <tr>
                <th>Id</th>
                <th>Proyecto</th>
                <th>Acta</th>
                <th>constancia</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
             $documentos = $dbDocumentos->selectDocumentos();

             foreach($documentos as $documento){
                $id=$documento['idDocumento'];
                $nom_proyecto=$documento['nombre_proyecto'];
                $acta_de_recepcion=$documento['acta_de_recepcion'];
                $resolucion_de_obra=$documento['resolucion_de_obra'];
                $resolucion_deductivos=$documento['resolucion_deductivos'];
                $resolucion_adicionales=$documento['resolucion_adicionales'];
                $anexo_de_promesa_de_consorcio=$documento['anexo_de_promesa_de_consorcio'];
                $constancia=$documento['constancia'];
                $contrato_de_consorcio=$documento['contrato_de_consorcio'];
                $contrato=$documento['contrato'];
            ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $nom_proyecto ?></td>
                    <td><?= $acta_de_recepcion ?></td>
                    <td><?= $constancia ?></td>
                    <td>
                        <a href="?m=panel&mod=documento&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"><b> </i></a>
                        <a href="?m=panel&mod=documento&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash"><b></i></a>
                    </td
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