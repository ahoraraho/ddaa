<?php
// Crear instancia de la clase dbContactos
$dbContactos = new dbContactos($conexion);

// Obtener todos los contactos de la tabla contacto
$contactos = $dbContactos->obtenerContactos();
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house"></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Contactos">Contactos</a>
    <a href="#" title="Estás aquí" class="active">Contacto</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>CONTACTO</h3>
        <div class="main">
            <div class="formm">
                <?php
                $action = isset($_GET["action"]) ? $_GET["action"] : "add";

                //====================================================================
                //==            Mostrar los datos dentro del formulario             ==
                //====================================================================
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Procesar los datos del formulario ejecutado
                    $id = isset($_GET["id"]) ? $_GET["id"] : "";

                    if ($action == "update" || $action == "delete") {
                        $contacto = $dbContactos->selectContacto($id);

                        if (!empty($contacto)) {
                            $idContacto = $contacto["idContacto"];
                            $dni = $contacto["dni"];
                            $nombre = $contacto["nombre"];
                            $email = $contacto["email"];
                            $celular = $contacto["celular"];
                            $cargo = $contacto["cargo"];
                        }
                    } else if ($action == "add") {
                        // Inicializar los valores en blanco para un nuevo registro
                        $idContacto = "";
                        $dni = "";
                        $nombre = "";
                        $email = "";
                        $celular = "";
                        $cargo = "";
                    }
                } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores del formulario
                    $idContacto = $_POST["id"];
                    $dni = $_POST["dni"];
                    $nombre = $_POST["nombre"];
                    $email = $_POST["email"];
                    $celular = $_POST["celular"];
                    $cargo = $_POST["cargo"];

                    // Verificar action
                    if ($action == "update") {
                        // Realizar la actualización utilizando el método updateContacto
                        $contacto = [
                            'idContacto' => $idContacto,
                            'dni' => $dni,
                            'nombre' => $nombre,
                            'email' => $email,
                            'celular' => $celular,
                            'cargo' => $cargo,
                        ];

                        $actualizado = $dbContactos->updateContacto($contacto);
                        if ($actualizado) {
                            // Actualización exitosa, realizar alguna acción
                        } else {
                            // Error al actualizar, manejar el caso apropiado
                        }
                    } else if ($action == "add") {
                        // Realizar la inserción utilizando el método insertarContacto
                        $contacto = [
                            'idContacto' => $idContacto,
                            'dni' => $dni,
                            'nombre' => $nombre,
                            'email' => $email,
                            'celular' => $celular,
                            'cargo' => $cargo,
                        ];

                        $idInsertado = $dbContactos->insertarContacto($contacto);
                        if ($idInsertado) {
                            // Inserción exitosa, realizar alguna acción
                        } else {
                            // Error al insertar, manejar el caso apropiado
                        }
                    } else if ($action == "delete") {
                        // Realizar la eliminación utilizando el método deleteContacto
                        $eliminado = $dbContactos->deleteContacto($idContacto);
                        if ($eliminado) {
                            // Eliminación exitosa, realizar alguna acción
                        } else {
                            // Error al eliminar, manejar el caso apropiado
                        }
                    }
                }
                ?>
                <form action="?m=panel&mod=contacto&action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $idContacto; ?>">
                    <i class="bi bi-credit-card"></i><span> DNI </span>
                    <input required type="text" name="dni" value="<?php echo $dni; ?>">
                    <i class="bi bi-person-fill"></i><span> Nombre </span>
                    <input required type="text" name="nombre" value="<?php echo $nombre; ?>">
                    <i class="bi bi-envelope-fill"></i><span> Email </span>
                    <input required type="email" name="email" value="<?php echo $email; ?>">
                    <i class="bi bi-phone-fill"></i><span> Celular </span>
                    <input required type="text" name="celular" value="<?php echo $celular; ?>">
                    <i class="bi bi-briefcase-fill"></i><span> Cargo </span>
                    <input required type="text" name="cargo" value="<?php echo $cargo; ?>">
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
