<?php
$dbObjetos = new dbObjeto();

$objetos = $dbObjetos->obtenerObjetos();
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas">Objetos</a>
    <a href="#" title="Estas justo aqui" class="active">Objeto</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>OBJETO</h3>
        <div class="main">
            <div class="formm">
                <?php
                $action = isset($_GET["action"]) ? $_GET["action"] : "add";

                //====================================================================
                //==            Mostrar los datos dentro del formulario             ==
                //====================================================================
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Aca se deben procesar los datos del formulario ejecutado
                    $id = isset($_GET["id"]) ? $_GET["id"] : "";

                    if ($action == "update" || $action == "delete") {
                        $objeto = $dbObjetos->selectObjeto($id);

                        if (!empty($objeto)) {
                            $idObjeto = $objeto["idObjeto"];
                            $nombre = $objeto["nombre"];
                        }
                    } else if ($action == "add") {
                        // Inicializar los valores en blanco para un nuevo registro
                        $idObjeto = "";
                        $nombre = "";
                    }
                } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores del formulario
                    $idObjeto = $_POST["id"];
                    $nombre = $_POST["nombre"];

                    // Verificar action
                    if ($action == "update") {
                        // Realizar la actualización utilizando el método updateObjeto
                        $objeto = [
                            'idObjeto' => $idObjeto,
                            'nombre' => $nombre,
                        ];

                        $actualizado = $dbObjetos->updateObjeto($objeto);
                        if ($actualizado) {
                            // Actualización exitosa, realizar alguna acción
                        } else {
                            // Error al actualizar, manejar el caso apropiado
                        }
                    } else if ($action == "add") {
                        // Realizar la inserción utilizando el método insertarObjeto
                        $objeto = [
                            'idObjeto' => $idObjeto,
                            'nombre' => $nombre,
                        ];

                        $idInsertado = $dbObjetos->insertarObjeto($objeto);
                        if ($idInsertado) {
                            // Inserción exitosa, realizar alguna acción
                        } else {
                            // Error al insertar, manejar el caso apropiado
                        }
                    } else if ($action == "delete") {
                        // Realizar la eliminación utilizando el método deleteObjeto
                        $eliminado = $dbObjetos->deleteObjeto($idObjeto);
                        if ($eliminado) {
                            // Eliminación exitosa, realizar alguna acción
                        } else {
                            // Error al eliminar, manejar el caso apropiado
                        }
                    }
                }
                ?>
                <form action="?m=panel&mod=objeto&action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $idObjeto; ?>">
                    <i class="bi bi-qr-code-scan"></i><span> Id </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="nombre" value="<?php echo $idObjeto; ?>">
                    <i class="bi bi-grid-1x2"></i><span> Nombre </span>
                    <input required type="text" name="nombre" value="<?php echo $nombre; ?>">
                    <br><br>
                    <button type="submit" name="action" id="ac" style="color:red;" class="form_login" value="<?php echo $action; ?>">
                        <?php
                        if ($action == "update") {
                            echo "Actualizar";
                        } else if ($action == "add") {
                            echo "Agregar";
                        } else if ($action == "delete") {
                            echo "Eliminar";
                        }
                        ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
