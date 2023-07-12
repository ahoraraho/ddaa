<?php
validacionIicioSesion();

mensaje('Contacto', 'o');

?>
<!-- ruta de acceso guia -->
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="#" title="Estas justo aqui" class="active">Contactos</a>
</div>

<h2>CONTACTOS</h2>
<div class="numm">
    <div class="f1">
        <form class="from_input" action="" method="GET">
            <!-- para agregar la vista de ?m=productos en la url -->
            <input type="hidden" name="m" value="panel">
            <input type="hidden" name="mod" value="contactos">
            <!-- concatenando el valor a buscar -->
            <input type="text" name="buscar" value="" placeholder="Buscar...">
            <!-- <input type="submit" value="BUSCAR"> -->
            <button class="btn-buscador" type="submit"><i class="bi-search"></i></button>
        </form>
        <span class="f-s">15</span>
    </div>
    <div class="f2">
        <a href="?m=panel&mod=contacto&action=add" class="button-link btn-new f-e">
            <i class="abi bi bi-plus-square"></i><span>Nueva Contacto</span>
        </a>
    </div>
</div>

<div class="numm">
    <div class="f1">
        <form name="filtros" action="?m=panel&mod=contactos" method="POST">
            <h3>Filtros:</h3>
            <!-- Cargo -->
            <select name="buscarCargo" id="buscarCargo">
                <option value="">Cargo</option> <!-- Agrega la opción predeterminada -->
                <?php
                $selectedCargo = $_POST["buscarCargo"]; // Obtén el valor seleccionado por el usuario
                $options = array(
                    'Dueño de negocio' => 'Dueño de negocio',
                    'Gerente' => 'Gerente',
                    'Otros' => 'Otros'
                );
                foreach ($options as $value => $text) {
                    $selected = ($selectedCargo == $value) ? 'selected' : '';
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

    $buscarCargo = $_POST["buscarCargo"];

    $contactos = $dbContactos->filtrarContacto($buscarCargo);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
    $contactos = $dbContactos->buscarContacto($busqueda);
    /* //////////////////////////  Barra de busqueda  //////////////////////////*/
} else {
    $contactos = $dbContactos->selectContactos();
}
?>

<!-- tabla categorias -->
<div class="contenido-tabla">
    <table class="responsive-contactos">
        <thead>
            <tr>
                <th>Id Contacto</th>
                <th>nombre</th>
                <th>DNI</th>
                <th>email</th>
                <th>telefono</th>
                <th>Cargo</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php

            foreach ($contactos as $contacto) {
                $id = $contacto['idContacto'];
                $dni = $contacto['dni'];
                $nombre = $contacto['nombre'];
                $email = $contacto['email'];
                $celular = $contacto['celular'];
                $cargo = $contacto['cargo'];
            ?>
                <tr onclick="window.location.href='?m=panel&mod=contacto&action=view&id=<?= $id ?>'">
                    <td><?= $id ?></td>
                    <td><?= $nombre ?></td>
                    <td><?= $dni ?></td>
                    <td><?= $email ?></td>
                    <td><?= $celular ?></td>
                    <td><?= $cargo ?></td>
                    <td>
                        <a href="?m=panel&mod=contacto&action=update&id=<?= $id ?>" title="Modificar"><i class="edid bi-pencil-square"></i></a>
                        <a href="?m=panel&mod=contacto&action=delete&id=<?= $id ?>" title="Eliminar"><i class="delete bi-trash"></i></a>
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