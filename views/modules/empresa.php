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
                    $action = $_GET["action"];             
                    //====================================================================
                    //==            Mostrar los datos dentro del formulario             ==
                    //====================================================================
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // Aca se deben procesar los datos del formulario ejecutado
                        $id = isset($_GET["id"]) ? $_GET["id"] : "";
                        if ($action == "update" || $action == "delete") {
                            $consulta = "SELECT * FROM empresa WHERE idEmpresa = $id";
                            $resultado = $conexion->query($consulta);
                            if ($resultado->num_rows > 0) {
                                $row = $resultado->fetch_assoc();
                                $idEmpresa = $row["idEmpresa"];
                                $nombreEmpresa = $row["nombreEmpresa"];
                                $ruc = $row["ruc"];
                                $telefono = $row["telefono"];
                                $email = $row["email"];
                                $num_partida = $row["numeroPartida"];
                                $mipe = $row["mipe"];
                            }
                        } else if ($action == "add") {
                            // Inicializar los valores en blanco para un nuevo registro
                            $id="";
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
                
                        //Verficar action
                        if ($action == "update") {
                            
                        } else if ($action == "add") {
                            
                        } else if ($action == "delete") {

                        }
                    }
                    ?>

                <form action="?m=panel&mod=empresa&action=" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <span> Id </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="Nombre" value="<?php echo $idEmpresa   ; ?>">
                    <span> Nombre Empresa</span>
                    <input required type="text" name="Nombre" value="<?php echo $nombreEmpresa; ?>">
                    <span> RUC </span>
                    <input required type="number" min="0" name="ruc" value="<?php echo $ruc; ?>" >
                    <span> Telefono </span>
                    <input required type="number" min="0" name="telefono" value="<?php echo $telefono; ?>" >
                    <span> Email </span>
                    <input required type="text" min="0" name="email" value="<?php echo $email; ?>" >
                    <span> Numero de Partida </span>
                    <input required type="text" min="0" name="num_partida" value="<?php echo $num_partida; ?>" >
                    <span> MIPE </span>
                    <input required type="number" min="0" name="mipe" value="<?php echo $mipe; ?>" >
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
</div>