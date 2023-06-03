<?php
// require_once '../config/Conexion.php';
class dbUsuarios
{
    /*****************************************************************************
     *                VERIFICA EL EMAIL Y CONTRASEÑA DEL USUARIO
     *****************************************************************************/
    public function loginUsuario($email)
    {
        // global $conexion;

        $consulta = "SELECT L.idUsuario, E.Nombre, E.Apellido, L.Email, 0 AS Rol 
                    FROM login AS L
                    INNER JOIN especialista AS E ON L.idEspecialista = E.idEspecialista
                    WHERE Email = ? AND Estado = 1
                    UNION ALL 
                    SELECT L.idUsuario, B.Nombre, B.Apellido, L.Email, 1 AS Rol 
                    FROM login AS L
                    INNER JOIN administrador AS B ON L.idAdministrador = B.idAdministrador
                    WHERE Email = ? AND Estado = 1";

        $stmt = mysqli_prepare($conexion, $consulta);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincular los parámetros a la consulta preparada
            mysqli_stmt_bind_param($stmt, "ss", $email, $email);

            // Ejecutar la consulta preparada
            mysqli_stmt_execute($stmt);

            // Obtener el resultado de la consulta
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return false;
    }


    /******************************************************************************/
    /*                     VERIFICAR SI LA CONTRASEÑA EN LA MISMA                 */
    /******************************************************************************/
    public function verificarPass($email, $pass)
    {
        // global $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Contrasena FROM login WHERE Email = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $resul = mysqli_fetch_assoc($resultado);
                if (password_verify($pass, $resul["Contrasena"])) {
                    return true;
                }
            }
        }

        return false;
    }


    /******************************************************************************/
    /*        VERIFICAR SI LA CONTRASEÑA EN LA MISMA SEGUN AL ID Y EMAIL          */
    /******************************************************************************/
    public function validarPassReset($id, $email, $oldPass)
    {
        global $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Email, Contrasena FROM login
                WHERE idUsuario = ? AND Email = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "is", $id, $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $resul = mysqli_fetch_assoc($resultado);
                if (password_verify($oldPass, $resul["Contrasena"])) {
                    return true;
                }
            }
        }

        return false;
    }



    /*****************************************************************************
     *               SELECCIONO DATOS COMPLETOS DE USUARIO POR ID
     *****************************************************************************/
    public function SelectUsuario($id)
    {
        global $conexion;

        $consulta = "SELECT L.Rol, L.Email, L.Contrasena, E.DNI,
                IFNULL (B.idAdministrador, E.idEspecialista) AS IdCliente,
                IFNULL(B.Nombre, E.Nombre) AS Nombre, 
                IFNULL(B.Apellido, E.Apellido) AS Apellido, 
                IFNULL(B.Cargo, E.Cargo) AS Cargo, 
                IFNULL(B.direccion, E.direccion) AS Direccion, 
                IFNULL(B.telefono, E.telefono) AS Telefono 
            FROM login AS L 
            LEFT JOIN especialista AS E ON L.idEspecialista = E.idEspecialista 
            LEFT JOIN administrador AS B ON L.idAdministrador = B.idAdministrador 
            WHERE L.idUsuario = ?";

        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }



    /*****************************************************************************
     *                INSERTAR USUARIO EN LA TABLA SEGUN EL ROL
     *****************************************************************************/
    public function insertUsuario($rol, $usuario)
    {
        global $conexion;

        // Se obtienen y se trimean los valores del arreglo $usuario
        $nombre = trim($usuario['Nombre']);
        $apellido = trim($usuario['Apellido']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $cargo = trim($usuario['Cargo']);
        $email = trim(strtolower($usuario['Email']));
        $pass = trim($usuario['Pass']);

        // Se genera el hash de la contraseña
        $passHash = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 11]);


        $idVinculante = "";
        $consulta = "";

        // Se determina la tabla y los campos correspondientes según el valor de $rol
        if ($rol == 1) {
            $idVinculante = "idAdministrador";
            $consulta = "INSERT INTO administrador (Nombre, Apellido, Cargo, Direccion, Telefono) VALUES (?, ?, ?, ?, ?)";
        } else if ($rol == 0) {
            $dni = trim($usuario['DNI']);
            $idVinculante = "idEspecialista";
            $consulta = "INSERT INTO especialista (DNI, Nombre, Apellido, Cargo, Direccion, Telefono) VALUES (?, ?, ?, ?, ?, ?)";
        }

        // Si la consulta no está vacía, se prepara y se ejecuta
        if (!empty($consulta)) {
            $stmt = mysqli_prepare($conexion, $consulta);
            if ($stmt) {
                // Se realiza el enlace de parámetros según el valor de $rol
                if ($rol == 1) {
                    mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellido, $cargo, $direccion, $telefono);
                } else if ($rol == 0) {
                    mysqli_stmt_bind_param($stmt, "ssssss", $dni, $nombre, $apellido, $cargo, $direccion, $telefono);
                }

                // Se ejecuta la consulta preparada y se cierra el statement
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                // Se obtiene el último id insertado y la fecha y hora actual
                $ultimo_id = mysqli_insert_id($conexion);

                date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú
                $fechaHora = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual en el formato deseado

                // Se prepara y ejecuta la consulta para insertar en la tabla login
                $consultaLogin = "INSERT INTO login (Rol, $idVinculante, Email, Contrasena, Activacion, Estado) VALUES (?, ?, ?, ?, ?, 1)";
                $stmtLogin = mysqli_prepare($conexion, $consultaLogin);
                if ($stmtLogin) {
                    mysqli_stmt_bind_param($stmtLogin, "iisss", $rol, $ultimo_id, $email, $passHash, $fechaHora);
                    mysqli_stmt_execute($stmtLogin);
                    mysqli_stmt_close($stmtLogin);
                }

                // Se devuelve el número de filas afectadas
                return mysqli_affected_rows($conexion);
            }
        }

        // Si ocurre algún error o la consulta está vacía, se devuelve false
        return false;
    }



    /*****************************************************************************
     *                ACTUALIZO EL USUARIO EN LA TABLA SEGUN EL ID
     *****************************************************************************/
    public function updateUsuario($usuario)
    {
        global $conexion;

        $id = $usuario['Id'];
        $rol = $usuario['Rol'];
        $idCliente = $usuario['IdCliente'];
        $dni = trim($usuario['DNI']);
        $nombre = trim($usuario['Nombre']);
        $apellido = trim($usuario['Apellido']);
        $cargo = trim($usuario['Cargo']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $email = trim(strtolower($usuario['Email']));

        date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú
        $fechaHora = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual en el formato deseado

        // Preparar la consulta para actualizar la tabla login
        $consulta1 = "UPDATE login
                SET Email = ?, fechaModificacionData = ?
                WHERE IdUsuario = ?";
        $stmt1 = mysqli_prepare($conexion, $consulta1);
        mysqli_stmt_bind_param($stmt1, "ssi", $email,  $fechaHora, $id);
        mysqli_stmt_execute($stmt1);
        $affectedRows = mysqli_stmt_affected_rows($stmt1);
        mysqli_stmt_close($stmt1);

        // Preparar la consulta para actualizar la tabla correspondiente según el rol
        $consulta2 = "";
        if ($rol == 1) {
            $consulta2 = "UPDATE administrador
                    SET Nombre = ?, Apellido = ?, Cargo = ?, Direccion = ?, Telefono = ?
                    WHERE idAdministrador = ?";
        } else if ($rol == 0) {
            $consulta2 = "UPDATE especialista
                    SET DNI = ?, Nombre = ?, Apellido = ?, Cargo = ?, Direccion = ?, Telefono = ?
                    WHERE idEspecialista = ?";
        }

        if (!empty($consulta2)) {
            $stmt2 = mysqli_prepare($conexion, $consulta2);
            if ($stmt2) {
                if ($rol == 1) {
                    mysqli_stmt_bind_param($stmt2, "sssssi", $nombre, $apellido, $cargo, $direccion, $telefono, $idCliente);
                } else if ($rol == 0) {
                    mysqli_stmt_bind_param($stmt2, "ssssssi", $dni, $nombre, $apellido, $cargo, $direccion, $telefono, $idCliente);
                }
                mysqli_stmt_execute($stmt2);
                $affectedRows += mysqli_stmt_affected_rows($stmt2);
                mysqli_stmt_close($stmt2);
            }
        }

        return $affectedRows;
    }


    /*****************************************************************************
     *                ELIMINO EL USUARIO EN LA TABLA SEGUN EL ID
     *****************************************************************************/
    public function deleteUsuario($usuario)
    {
        global $conexion;

        $id = $usuario['Id'];
        $rol = $usuario['Rol'];
        $idCliente = $usuario['IdCliente'];

        // Preparar la consulta para eliminar el registro de la tabla login
        $consulta1 = "DELETE FROM login WHERE IdUsuario = ?";
        $stmt1 = mysqli_prepare($conexion, $consulta1);
        mysqli_stmt_bind_param($stmt1, "i", $id);
        mysqli_stmt_execute($stmt1);
        $affectedRows = mysqli_stmt_affected_rows($stmt1);
        mysqli_stmt_close($stmt1);

        // Preparar la consulta para eliminar el registro de la tabla correspondiente según el rol
        $consulta2 = "";
        if ($rol == 1) {
            $consulta2 = "DELETE FROM administrador WHERE idAdministrador = ?";
        } else if ($rol == 0) {
            $consulta2 = "DELETE FROM especialista WHERE idEspecialista = ?";
        }

        if (!empty($consulta2)) {
            $stmt2 = mysqli_prepare($conexion, $consulta2);
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "i", $idCliente);
                mysqli_stmt_execute($stmt2);
                $affectedRows += mysqli_stmt_affected_rows($stmt2);
                mysqli_stmt_close($stmt2);
            }
        }

        return $affectedRows;
    }


    // PARA RESETEAR CONTRASEÑA NO LOGUEADO -> ABAJO 
    /*****************************************************************************
     *                        VERIFICA SI EXISTE EL MAIL
     *****************************************************************************/
    public function existMailUsuario($email)
    {
        global $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Email FROM login
                WHERE Email = ?";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $rowCount = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);

        return $rowCount > 0;
    }

    /*****************************************************************************
     *           VERIFICA SEGUN EL MAIL: RESCATA EL ID, MAIL Y ROL
     *****************************************************************************/
    public function validarEmail($email)
    {
        global $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT idUsuario, rol FROM login
                WHERE Email = ?";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        } else {
            return [];
        }
    }


    /*****************************************************************************
     *           VERIFICA SEGUN EL MAIL: RESCATA EL ID, MAIL Y ROL
     *****************************************************************************/
    public function recuperarDatos($dataReset)
    {
        $id = $dataReset["Id"];
        $rol = $dataReset["Rol"];

        global $conexion;

        $consulta = "";
        $tabla = "";
        $idUser = "";
        $idd = "";

        if ($rol == 1) {
            $tabla = "administrador";
            $idUser = "L.idAdministrador";
            $idd = "U.idAdministrador";
        } else if ($rol == 0) {
            $tabla = "especialista";
            $idUser = "L.idEspecialista";
            $idd = "U.idEspecialista";

        }

        $consulta = "SELECT L.Email, U.telefono AS Telefono 
                FROM login AS L 
                LEFT JOIN $tabla AS U ON $idUser = $idd
                WHERE L.idUsuario = ?";

        if (!empty($consulta)) {
            $stmt = mysqli_prepare($conexion, $consulta);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $resultado = mysqli_stmt_get_result($stmt);
                $data = mysqli_fetch_assoc($resultado);
                mysqli_stmt_close($stmt);

                if ($data) {
                    return $data;
                } else {
                    return [];
                }
            }
        }

        return [];
    }




    /*****************************************************************************
     *       RESETEAR LA CONTRASEÑA SEGUN EL ID Y EMAIL DE LA TABLA LOGIN
     *****************************************************************************/
    public function ResetPassUsers($id, $email, $passOk)
    {
        global $conexion;

        date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú

        $fechaHora = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual en el formato deseado

        //echo "Fecha y hora en Perú: " . $fechaHora;

        $passHash = password_hash($passOk, PASSWORD_BCRYPT, ["cost" => 11]);

        $consulta = "UPDATE login
            SET Contrasena = ?, fechaModificacionPass = ?
            WHERE IdUsuario = ? AND Email = ?";

        $stmt = mysqli_prepare($conexion, $consulta);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssis", $passHash, $fechaHora, $id, $email);
            mysqli_stmt_execute($stmt);
            $affectedRows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);

            return $affectedRows > 0;
        }

        return false;
    }
}
