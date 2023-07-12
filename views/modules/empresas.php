<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Empresas</a>
</div>
<?php
validacionIicioSesion();
if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];

    $mensajeMap = [
        '0x10' => array('msj' => "Empresa y Archivos Agregados!", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check-circle-fill"),
        '0x11' => array('msj' => "Empresa Agregada, 0 archivos Agregados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-circle"),
        '0x12' => array('msj' => "Empresa Agregada y Algunos Archivos agregados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-square"),
        '0x13' => array('msj' => "No se registraron los datos ni los Archivos", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x20' => array('msj' => "Datos y Archivos Actualizados!", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check-circle-fill"),
        '0x21' => array('msj' => "Datos Actualizados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-circle"),
        '0x22' => array('msj' => "Archivos Actualizados", 'typeMsj' => "msj-ok", 'iconoAlert' => "bi-check2-square"),
        '0x23' => array('msj' => "No se realizaron cambios", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x30' => array('msj' => "Datos y Archivos Eliminados!", 'typeMsj' => "msj-warning", 'iconoAlert' => "bi-info-circle-fill"),
        '0x31' => array('msj' => "Datos Eliminados", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-check2-circle"),
        '0x32' => array('msj' => "Archivos Eliminados", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-check2-square"),
        '0x33' => array('msj' => "No se Eliminaron los datos ni archivos", 'typeMsj' => "msj-alert", 'iconoAlert' => "bi-exclamation-triangle-fill"),

        '0x000' => array('msj' => "Hubo un error al intentar realizar la operación!", 'typeMsj' => "msj-error", 'iconoAlert' => "bi-bug-fill")
    ];

    if (isset($mensajeMap[$msj])) {
        $mensaje = $mensajeMap[$msj];
        $msj = $mensaje['msj'];
        $typeMsj = $mensaje['typeMsj'];
        $iconoAlert = $mensaje['iconoAlert'];
        alertaResponDialog($typeMsj, $msj, $iconoAlert);
    }
}

?>

<h2>EMPRESAS</h2>
<div class="numm">
    <div class="f1">
        <form class="from_input" action="" method="GET">
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="empresas">
            <input type="text" name="buscar" value="" placeholder="Buscar...">
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
<div class="numm">
    <div class="f1">
        <form name="filtros" action="?m=panel&mod=empresas" method="POST">
            <h3>Filtros:</h3>
            <!-- Especialidad -->
            <select name="buscarMipe" id="buscarMipe">
                <option value="">Es Mipe?</option> <!-- Agrega la opción predeterminada -->
                <?php
                $selectedMipe = $_POST["buscarMipe"]; // Obtén el valor seleccionado por el usuario
                $options = array(
                    'S' => 'Si es mipe',
                    'N' => 'No es mipe'
                );
                foreach ($options as $value => $text) {
                    $selected = ($selectedMipe == $value) ? 'selected' : '';
                    echo '<option value="' . $value . '" ' . $selected . '>' . $text . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="button-link btn-new f-e">Filtrar</button>
        </form>

    </div>
</div>

<?php
/* //////////////////////////  FILTROS  //////////////////////////*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filtro = '';

    $buscarMipe = $_POST["buscarMipe"];

    $empresas = $dbEmpresas->filtrarEmpresa($buscarMipe);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
    $empresas = $dbEmpresas->buscarEmpresa($busqueda);
    /* //////////////////////////  Barra de busqueda  //////////////////////////*/
} else {
    $empresas = $dbEmpresas->selectEmpresas();
}
?>

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
            <?php

            foreach ($empresas as $empresa) {
                $id = $empresa['idEmpresa'];
                $nombreEmpresa = $empresa['nombreEmpresa'];
                $ruc = $empresa['ruc'];
                $telefono = $empresa['telefono'];
                $email = $empresa['email'];
                $numeroPartida = $empresa['numeroPartida'];
                $mipe = $empresa['mipe'];
                ?>
                <tr onclick="window.location.href='?m=panel&mod=empresa&action=view&id=<?= $id ?>'">
                    <td>
                        <?= $id ?>
                    </td>
                    <td>
                        <?= $nombreEmpresa ?>
                    </td>
                    <td>
                        <?= $ruc ?>
                    </td>
                    <td>
                        <?= $telefono ?>
                    </td>
                    <td>
                        <?= $email ?>
                    </td>
                    <td>
                        <a href="?m=panel&mod=empresa&action=update&id=<?= $id ?>" title="Modificar"><i
                                class="edid bi-pencil-square"><b> </i></a>
                        <a href="?m=panel&mod=empresa&action=delete&id=<?= $id ?>" title="Eliminar"><i
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