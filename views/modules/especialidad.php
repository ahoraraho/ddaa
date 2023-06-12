<?php
$dbEspecialidades = new dbEspecialidades();

$especialidades = $dbEspecialidades->obtenerEspecialidades();
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=especialidades" title="Ir a Especialidades">Especialidades</a>
    <a href="#" title="Estás justo aquí" class="active">Especialidad</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>ESPECIALIDAD</h3>
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
                        $especialidad = $dbEspecialidades->selectEspecialidad($id);

                        if (!empty($especialidad)) {
                            $idEspecialidad = $especialidad["idEspecialidad"];
                            $nombre = $especialidad["nombre"];
                        }
                    } else if ($action == "add") {
                        // Inicializar los valores en blanco para un nuevo registro
                        $idEspecialidad = "";
                        $nombre = "";
                    }
                } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores del formulario
                    $idEspecialidad = $_POST["id"];
                    $nombre = $_POST["nombre"];

                    // Verificar action
                    if ($action == "update") {
                        // Realizar la actualización utilizando el método updateEspecialidad
                        $especialidad = [
                            'idEspecialidad' => $idEspecialidad,
                            'nombre' => $nombre,
                        ];

                        $actualizado = $dbEspecialidades->updateEspecialidad($especialidad);
                        if ($actualizado) {
                            // Actualización exitosa, realizar alguna acción
                        } else {
                            // Error al actualizar, manejar el caso apropiado
                        }
                    } else if ($action == "add") {
                        // Realizar la inserción utilizando el método insertarEspecialidad
                        $especialidad = [
                            'idEspecialidad' => $idEspecialidad,
                            'nombre' => $nombre,
                        ];

                        $idInsertado = $dbEspecialidades->insertarEspecialidad($especialidad);
                        if ($idInsertado) {
                            // Inserción exitosa, realizar alguna acción
                        } else {
                            // Error al insertar, manejar el caso apropiado
                        }
                    } else if ($action == "delete") {
                        // Realizar la eliminación utilizando el método deleteEspecialidad
                        $eliminado = $dbEspecialidades->deleteEspecialidad($idEspecialidad);
                        if ($eliminado) {
                            // Eliminación exitosa, realizar alguna acción
                        } else {
                            // Error al eliminar, manejar el caso apropiado
                        }
                    }
                }
                ?>
                <form action="?m=panel&mod=especialidad&action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $idEspecialidad; ?>">
                    <i class="bi bi-qr-code-scan"></i><span> Id </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="nombre" value="<?php echo $idEspecialidad; ?>">
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
