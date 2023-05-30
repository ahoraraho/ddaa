<?php ob_start();
session_start();
?>

<div class="detras"></div>

<nav>
	<div class="nav-bar">
		<i class='bi bi-list sidebarOpen'></i>

		<div class="logo">
			<a href="./" title="D & A">
				<i class="logo-img logo-light"></i>
			</a>
		</div>

		<div class="botones">
			<div class="menu">
				<div class="logo-toggle">
					<div class="logo">
						<a href="./" title="D & A">
							<i class="logg logo-img logo-light"></i>
						</a>
					</div>
					<i class='bi bi-x-lg siderbarClose'></i>
				</div>

				<ul class="nav-links">
					<?php if (isset($_SESSION["Usuario"])) : ?>
						<li><a id="nonne" href="?m=panel&mod=proyectos"><i class="bi bi-newspaper"></i><span>Proyectos</span></a></li>
						<li><a id="nonne" href="?m=panel&mod=procesos"><i class="bi bi-motherboard"></i><span>Procesos</span></a></li>
						<li><a id="nonne" href="?m=panel&mod=empresas"><i class="bi bi-buildings"></i><span>Empresas</span></a></li>
						<li><a id="nonne" href="?m=panel&mod=objetos"><i class="bi bi-postcard"></i><span>Objetos</span></a></li>
						<li><a id="nonne" href="?m=panel&mod=especialidades"><i class="bi bi-calendar4-range"></i><span>Especialidades</span></a></li>
						<li><a id="nonne" href="?m=panel&mod=contactos"><i class="bi bi-person-vcard"></i><span>Contactos</span></a></li>
						<li><a id="nonne" href="?m=panel&mod=documentos"><i class="bi bi-file-earmark-medical"></i><span>Documetos</span></a></li>

						<?php if ($_SESSION["Usuario"]["Administrador"]) : ?>
							<li><a id="nonne" href="?m=panel&mod=usuarios"> <i class="bi bi-person-video2"></i><span>Usuarios</span></a></li>
						<?php endif; ?>

						<li><a id="nonne" href="?m=panel&mod=cuenta"><i class="bi bi-nut"></i><span>Configuracion</span></a></li>
						<div class="separado"></div>
						<li><a id="nonne" href="?m=panel&sesion=cerrar"><i class="bi-power"></i><span>Cerrar sesión</span></a></li>
					<?php else : ?>
						<div class="inicios">
							<li><a id="nonne" href="?m=ingreso"><button class="btn-ingreso">Login</button></a></li>
							<li><a id="nonne" href="?m=registro"><button class="btn-registro">Registro</button></a></li>
						</div>
					<?php endif; ?>
				</ul>
			</div>

			<div class="dark-light">
				<i id="iconoTheme" class='bi-brightness-high-fill'></i>
			</div>

			<div class="person">
				<?php
				if (!isset($_SESSION["Usuario"])) :
				?>
					<div class="btn-user">
						<a href="?m=ingreso">
							<i class="bi bi-person"></i>
						</a>
					</div>
				<?php else : ?>
					<div class="btn-user">
						<a href="?m=panel<?= ($_SESSION["Usuario"]["Administrador"]) ? '&mod=proyectos' : '&mod=proyectos'; ?>">
							<i class="bi bi-person-gear"></i>
							<span><?= $_SESSION["Usuario"]["Nombre"]; ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
</nav>