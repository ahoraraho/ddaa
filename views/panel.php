<?php
//session_start();

// Verificar si se abrió sesión
if (!isset($_SESSION["Usuario"])) {
    header('location: ./');
    exit;
}

// Verificar si se está cerrando la sesión
if (isset($_GET['sesion']) && $_GET['sesion'] == 'cerrar') {
    session_destroy();
    header('location: ./');
    exit;
}
?>

<section class="panel-users">
    <nav class="nav-panel">
        <a href="?m=panel&mod=proyectos" class="<?= ($_GET['mod'] == 'proyectos') ? 'nav-active' : ''; ?>">
            <i class="bi bi-calendar2-event"></i>
            <span>Proyectos</span>
        </a>
        <a href="?m=panel&mod=empresas" class="<?= ($_GET['mod'] == 'empresas') ? 'nav-active' : ''; ?>">
            <i class="bi bi-box-seam"></i>
            <span>Empresas</span>
        </a>
        <a href="?m=panel&mod=especialidades" class="<?= ($_GET['mod'] == 'especialidades') ? 'nav-active' : ''; ?>">
            <i class="bi bi-tags"></i>
            <span>Especialidades</span>
        </a>
        <a href="?m=panel&mod=contactos" class="<?= ($_GET['mod'] == 'contactos') ? 'nav-active' : ''; ?>">
            <i class="bi bi-calendar2-event"></i>
            <span>Contactos</span>
        </a>
        <a href="?m=panel&mod=documentos" class="<?= ($_GET['mod'] == 'documentos') ? 'nav-active' : ''; ?>">
            <i class="bi bi-view-list"></i>
            <span>Documentos</span>
        </a>
        <a href="?m=panel&mod=objetos" class="<?= ($_GET['mod'] == 'objetos') ? 'nav-active' : ''; ?>">
            <i class="i bi-handbag"></i>
            <span>Objetos</span>
        </a>
        <?php if ($_SESSION["Usuario"]["Administrador"]) : ?>
            <a href="?m=panel&mod=usuarios" class="<?= ($_GET['mod'] == 'usuarios') ? 'nav-active' : ''; ?>">
                <i class="bi bi-people"></i>
                <span>Usuarios</span>
            </a>
        <?php endif; ?>
        <a href="?m=panel&mod=cuenta" class="<?= ($_GET['mod'] == 'cuenta') ? 'nav-active' : ''; ?>">
            <i class="bi bi-gear"></i>
            <span>Configuracion</span>
        </a>
        <span class="separador"></span>
        <a href="?m=panel&sesion=cerrar">
            <i class="bi bi-power"></i>
            <span>Cerrar sesión</span>
        </a>
    </nav>
    <section class="container-panel">
        <?php
        // Recibir el mod al que se accedió y cargar el archivo correspondiente
        if (isset($_GET['mod'])) {
            $mod = 'views/modules/' . $_GET['mod'] . '.php';
            if (file_exists($mod)) {
                require_once($mod);
            } else {
                require_once("views/404.php");
            }
        }
        ?>
    </section>
</section>
