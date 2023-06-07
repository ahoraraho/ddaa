<?php
// Crear una instancia de la clase dbEmpresa
$dbEmpresas = new dbEmpresa();

// Obtener todas las empresas
$empresas = $dbEmpresas->obtenerEmpresas();
?>

<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas">Empresas</a>
    <a href="#" title="Estas justo aqui" class="active">Empresa</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>EMPRESA</h3>
        <div class="main">
            <div class="formm">
                <?php
                // Valido que haya una acción a realizar, sino se irá a crear un nuevo producto
                $action = isset($_GET["action"]) ? $_GET["action"] : "add";
                $action = $_GET["action"];

                //====================================================================
                //==            Mostrar los datos dentro del formulario             ==
                //====================================================================
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Aca se deben procesar los datos del formulario ejecutado
                    $id = isset($_GET["id"]) ? $_GET["id"] : "";

                    if ($action == "update" || $action == "delete") {
                        $empresa = $dbEmpresas->selectEmpresa($id);

                        if (!empty($empresa)) {
                            $idEmpresa = $empresa["idEmpresa"];
                            $nombreEmpresa = $empresa["nombreEmpresa"];
                            $ruc = $empresa["ruc"];
                            $telefono = $empresa["telefono"];
                            $email = $empresa["email"];
                            $num_partida = $empresa["numeroPartida"];
                            $mipe = $empresa["mipe"];
                        }
                    } else if ($action == "add") {
                        // Inicializar los valores en blanco para un nuevo registro
                        $id = "";
                        $idEmpresa = "";
                        $nombreEmpresa = "";
                        $ruc = "";
                        $telefono = "";
                        $email = "";
                        $num_partida = "";
                        $mipe = "";
                    }
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores del formulario
                    $id = $_POST["id"];
                    $nombreEmpresa = $_POST["Nombre"];
                    $ruc = $_POST["ruc"];
                    $telefono = $_POST["telefono"];
                    $email = $_POST["email"];
                    $num_partida = $_POST["num_partida"];
                    $mipe = $_POST["mipe"];

                    //Verificar action
                    if ($action == "update") {
                        // Realizar la actualización utilizando el método updateEmpresa
                        $empresa = [
                            'idEmpresa' => $id,
                            'nombreEmpresa' => $nombreEmpresa,
                            'ruc' => $ruc,
                            'telefono' => $telefono,
                            'email' => $email,
                            'numeroPartida' => $num_partida,
                            'mipe' => $mipe
                        ];

                        $actualizado = $dbEmpresas->updateEmpresa($empresa);
                        if ($actualizado) {
                            // Actualización exitosa, realizar alguna acción
                        } else {
                            // Error al actualizar, manejar el caso apropiado
                        }
                    } else if ($action == "add") {
                        // Realizar la inserción utilizando el método insertarEmpresa
                        $empresa = [
                            'nombreEmpresa' => $nombreEmpresa,
                            'ruc' => $ruc,
                            'telefono' => $telefono,
                            'email' => $email,
                            'numeroPartida' => $num_partida,
                            'mipe' => $mipe
                        ];

                        $idInsertado = $dbEmpresas->insertarEmpresa($empresa);
                        if ($idInsertado) {
                            // Inserción exitosa, realizar alguna acción
                        } else {
                            // Error al insertar, manejar el caso apropiado
                        }
                    } else if ($action == "delete") {
                        // Realizar la eliminación utilizando el método deleteEmpresa
                        $eliminado = $dbEmpresas->deleteEmpresa($id);
                        if ($eliminado) {
                            // Eliminación exitosa, realizar alguna acción
                        } else {
                            // Error al eliminar, manejar el caso apropiado
                        }
                    }
                }
                ?>

                <form action="?m=panel&mod=empresa&action=" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <span> Id </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="Nombre"
                        value="<?php echo $idEmpresa; ?>">
                    <span> Nombre Empresa</span>
                    <input required type="text" name="Nombre" value="<?php echo $nombreEmpresa; ?>">
                    <span> RUC </span>
                    <input required type="number" min="0" name="ruc" value="<?php echo $ruc; ?>">
                    <span> Telefono </span>
                    <input required type="number" min="0" name="telefono" value="<?php echo $telefono; ?>">
                    <span> Email </span>
                    <input required type="text" min="0" name="email" value="<?php echo $email; ?>">
                    <span> Numero de Partida </span>
                    <input required type="text" min="0" name="num_partida" value="<?php echo $num_partida; ?>">
                    <span> MIPE </span>
                    <input required type="number" min="0" name="mipe" value="<?php echo $mipe; ?>">
                    <br><br>
                    <button type="submit" name="action" id="ac" style="color:red;" class="form_login" value="">
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
    <?php
    ?>
</div>
