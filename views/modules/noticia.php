<?php
validacionIicioSesion();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Valido que tipo de peticion invoca al mod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aca se deben procesar los datos del formulario ejecutado
    $idNoticia = $_POST["idNoticia"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $destacado = $_POST["destacado"];

    $imagen = $_FILES["imagen"];
    $imagenNombre = $imagen["name"];

    $imagenActual = $_POST["ImagenActual"];

    $directorio = "imagenes/". $imagenNombre;

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = $dbNoticias->insertNoticia($titulo, $descripcion, $fecha, $destacado, $imagenNombre);
            if ($affectedRows > 0) {
                $msj = "0x10";
                if (!empty($imagenNombre)) {
                    if (move_uploaded_file($imagen["tmp_name"], $directorio) == false) {
                        $msj = "0x11";
                    }
                }
            }
            break;

        case 'update':
            if (!empty($imagenNombre)) {
                if (move_uploaded_file($imagen["tmp_name"], $directorio) == true) {
                    $sqlImagen = $imagenNombre;
                    unlink("imagenes//" . $imagenActual);
                } else {
                    $msj = "0x21";
                }
            } else {
                $sqlImagen = $imagenActual;
            }
            $msj = "0x20";
            $affectedRows = $dbNoticias->updateNoticia($idNoticia, $titulo, $descripcion, $fecha, $destacado, $sqlImagen);
            if ($affectedRows == 0) {
                $msj = "0x1000";
            }
            break;

        case 'delete':
            $msj = "0x30";
            if ($dbNoticias->deleteNoticia($idNoticia) > 0) {
                unlink("imagenes/" . $imagenActual);
                $msj = "0x1000";
            }
            break;
    }
    header('location: ?m=panel&mod=noticias&msj=' . $msj);
} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            //optiene el id mayor de la tabla categorias
            $maxid = $dbNoticias->MayorIdNoticia();
            foreach ($maxid as $iddd) {
                $idNoticia = $iddd["maxId"];
            }
            $idNoticia = ($idNoticia + 1);
            $btn = "Agregar";
            $status = null;
            $noticia = array(
                "idNoticia" => $idNoticia,
                "titulo" => "",
                "descripcion" => "",
                "fecha" => "",
                "destacado" => "0",
                "imagen" => ""
            );
            break;

        case 'update':
            $idNoticia = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $noticia = $dbNoticias->selectNoticia($idNoticia);
            break;

        case 'delete':
            $idNoticia = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $noticia = $dbNoticias->selectNoticia($idNoticia);
            break;
    }
}
?>
<?php
switch ($btn) {
    case 'Eliminar':
        $style = "background-color:crimson";
        $styleImage = "display: none !importans; ";
        $hacer = "Eliminar Noticia";
        // $icono = "bi bi-trash";
        break;
    case 'Agregar':
        $style = "background-color:rgb(0, 176, 26)";
        $hacer = "Agregar Noticia";
        // $icono = "bi bi-plus-square";
        break;
    case 'Actualizar':
        $style = "background-color:rgb(9, 109, 149)";
        $hacer = "Actualizar Noticia";
        // $icono = "bi bi-pencil-square";
        break;
    default:
        # code...
        break;
}
?>
<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=noticias" title="Ir a Noticias">Noticias</a>
    <a href="#" title="Estas justo aqui" class="active"><?= $hacer ?></a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>Noticia</h3>
        <div class="main">
            <div class="formm">
                
                <form action="?m=panel&mod=noticia&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idNoticia" value="<?= $noticia["idNoticia"]; ?>">
                    <input type="hidden" name="ImagenActual" value="<?= $noticia["imagen"] ?>">
                    <b> Id Noticia</b>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="idNoticia" value="<?= $noticia["idNoticia"] ?>" <?= $status ?>>
                    <b> Titulo </b>
                    <input required type="text" name="titulo" value="<?= $noticia["titulo"] ?>" <?= $status ?>>
                    <b> Descripcion </b>
                    <input required type="text" name="descripcion" value="<?= $noticia["descripcion"] ?>" <?= $status ?>>
                    <b> Fecha </b>
                    <input required type="text" name="fecha" value="<?= $noticia["fecha"] ?>" <?= $status ?>>
                    <b> Destacado </b>
                    <div class="custom-select">
                        <select name="destacado" <?= $status ?> onchange="updateDestacadoActual(this)">
                            <option value="1" <?= ($noticia['destacado'] == 1) ? 'selected' : '' ?>>Destacado</option>
                            <option value="0" <?= ($noticia['destacado']  == 0) ? 'selected' : '' ?>>No destacado</option>
                        </select>
                        <span class="custom-select-icon"><i class="bi bi-chevron-down"></i></apan> <!-- Reemplaza "Icono" con el código o clase de tu icono personalizado -->
                    </div>

                    <input type="file" name="imagen" id="selectImg" accept="image/*" <?= $status ?>>
                    <div style="text-align: center;">
                        <label for="selectImg" name="addImg" id="addImg" style="<?= $styleImage ?>" class="form_login">Elegir imagen</label>
                    </div>

                    <div class="center">
                        <div class="previewImg">
                            <?php if (!empty($noticia["imagen"])) : ?>
                                <img id="previewImg" src="imagenes/<?= $noticia["imagen"]; ?>" style="max-width:100%">
                            <?php else : ?>
                                <img id="previewImg" src="" style="max-width:100%">
                            <?php endif; ?>
                        </div>
                    </div>
                    <br><br>
                    <button type="submit" name="action" id="ac" style="<?= $style ?>" class="form_login"><?= $btn; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>