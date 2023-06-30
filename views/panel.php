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
            <i class="bi bi-motherboard"></i>
            <span>Proyectos</span>
        </a>
        <a href="?m=panel&mod=procesos" class="<?= ($_GET['mod'] == 'procesos') ? 'nav-active' : ''; ?>">
            <!-- <i class="bi bi-building-gear"></i> -->
            <!-- <i class="bi bi-columns-gap"></i> -->
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Procesos</span>
        </a>
        <a href="?m=panel&mod=empresas" class="<?= ($_GET['mod'] == 'empresas') ? 'nav-active' : ''; ?>">
            <i class="bi bi-buildings"></i>
            <span>Empresas</span>
        </a>
        <a href="?m=panel&mod=objetos" class="<?= ($_GET['mod'] == 'objetos') ? 'nav-active' : ''; ?>">
            <i class="bi bi-postcard"></i>
            <span>Objetos</span>
        </a>
        <a href="?m=panel&mod=especialidades" class="<?= ($_GET['mod'] == 'especialidades') ? 'nav-active' : ''; ?>">
            <i class="bi bi-calendar4-range"></i>
            <span>Especialidades</span>
        </a>
        <a href="?m=panel&mod=contactos" class="<?= ($_GET['mod'] == 'contactos') ? 'nav-active' : ''; ?>">
            <i class="bi bi-person-vcard"></i>
            <span>Contactos</span>
        </a>
        <a href="?m=panel&mod=actualizaciones" class="<?= ($_GET['mod'] == 'actualizaciones') ? 'nav-active' : ''; ?>">
            <i class="bi bi-menu-button-wide"></i>
            <span>Actualizaciones</span>
        </a>
        <a href="?m=panel&mod=noticias" class="<?= ($_GET['mod'] == 'noticias') ? 'nav-active' : ''; ?>">
            <i class="bi bi-newspaper"></i>
            <span>Noticias</span>
        </a>

        <?php if ($_SESSION["Usuario"]["Administrador"]) : ?>
            <a href="?m=panel&mod=usuarios" class="<?= ($_GET['mod'] == 'usuarios') ? 'nav-active' : ''; ?>">
                <i class="bi bi-person-video2"></i>
                <span>Usuarios</span>
            </a>
        <?php endif; ?>
        <a href="?m=panel&mod=cuenta" class="<?= ($_GET['mod'] == 'cuenta') ? 'nav-active' : ''; ?>">
            <i class="bi bi-nut"></i>
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