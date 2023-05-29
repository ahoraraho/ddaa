<?php
// require_once '../config/Conexion.php';
class dbUsuarios
{
    /*****************************************************************************
     *                VERIFICA EL EMAIL Y CONTRASEÑA DEL USUARIO
     *****************************************************************************/
    public function loginUsuario($email)
    {
        global $conexion;

        $consulta = "SELECT L.idUsuario, E.Nombre, E.Apellido, L.Email, 0 AS Rol 
                    FROM login AS L
                    INNER JOIN especialista AS E ON L.idEspecialista = E.id
                    WHERE Email = ? AND Estado = 1
                    UNION ALL 
                    SELECT L.idUsuario, B.Nombre, B.Apellido, L.Email, 1 AS Rol 
                    FROM login AS L
                    INNER JOIN administrador AS B ON L.idAdministrador = B.id
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
        global $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Pass FROM login WHERE Email = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $resul = mysqli_fetch_assoc($resultado);
                if (password_verify($pass, $resul["Pass"])) {
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

        $consulta = "SELECT Email, Pass FROM login
                WHERE idUsuario = ? AND Email = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "is", $id, $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $resul = mysqli_fetch_assoc($resultado);
                if (password_verify($oldPass, $resul["Pass"])) {
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

        $consulta = "SELECT L.Rol, L.Email, L.Pass, E.DNI,
                IFNULL (B.id, E.id) AS IdCliente,
                IFNULL(B.Nombre, E.Nombre) AS Nombre, 
                IFNULL(B.Apellido, E.Apellido) AS Apellido, 
                IFNULL(B.Cargo, E.Cargo) AS Cargo, 
                IFNULL(B.direccion, E.direccion) AS Direccion, 
                IFNULL(B.telefono, E.telefono) AS Telefono 
            FROM login AS L 
            LEFT JOIN especialista AS E ON L.idEspecialista = E.id 
            LEFT JOIN administrador AS B ON L.idAdministrador = B.id 
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

        $nombre = trim($usuario['Nombre']);
        $apellido = trim($usuario['Apellido']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $email = trim(strtolower($usuario['Email']));
        $pass = trim($usuario['Pass']);
        $passHash = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 11]);
        $cargo = trim($usuario['Cargo']);

        $consulta = "";
        if ($rol == 1) {

            $consulta = "INSERT INTO administrador (Nombre, Apellido, Cargo, Direccion, Telefono)
                    VALUES (?, ?, ?, ?, ?)";
        } else if ($rol == 0) {
            $dni = trim($usuario['DNI']);
            $consulta = "INSERT INTO especialista (DNI, Nombre, Apellido, Cargo, Direccion, Telefono)
                    VALUES (?, ?, ?, ?, ?, ?)";
        }

        if (!empty($consulta)) {
            $stmt = mysqli_prepare($conexion, $consulta);
            if ($stmt) {
                if ($rol == 1) {
                    mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellido, $cargo, $direccion, $telefono);
                } else if ($rol == 0) {
                    mysqli_stmt_bind_param($stmt, "ssssss", $dni, $nombre, $apellido, $cargo, $direccion, $telefono);
                }
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $ultimo_id = mysqli_insert_id($conexion);
                $fechaHoraActual = date('Y-m-d H:i:s');

                $consultaLogin = "INSERT INTO login (Rol, idAdministrador, Email, Pass, Activacion, Estado)
                            VALUES (?, ?, ?, ?, ?, 1)";
                $stmtLogin = mysqli_prepare($conexion, $consultaLogin);
                if ($stmtLogin) {
                    mysqli_stmt_bind_param($stmtLogin, "iisss", $rol, $ultimo_id, $email, $passHash, $fechaHoraActual);
                    mysqli_stmt_execute($stmtLogin);
                    mysqli_stmt_close($stmtLogin);
                }

                return mysqli_affected_rows($conexion);
            }
        }

        return false;
    }


    /*****************************************************************************
     *                ACTUALIZO EL USUARIO EN LA TABLA SEGUN EL ID
     *****************************************************************************/
    public function UpdateUsuario($usuario)
    {

        global $dbConexion, $conexion;

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
        $pass = trim($usuario['Pass']);

        $consulta1 = "UPDATE login
                SET Email = '$email' 
                WHERE IdUsuario = $id";

        if ($rol == 1) {
            $consulta2 = "UPDATE administrador
                    SET Nombre = '$nombre', Apellido = '$apellido', Cargo = '$cargo', Direccion = '$direccion', Telefono = '$telefono' 
                    WHERE id = $idCliente";
        } else if ($rol == 0) {
            $consulta2 = "UPDATE especialista 
                    SET DNI = '$dni',  Nombre = '$nombre', Apellido = '$apellido', Cargo = '$cargo', Direccion = '$direccion', Telefono = '$telefono' 
                    WHERE id = $idCliente";
        }

        mysqli_query($conexion, $consulta1);
        //mysql_affected_rows: Obtener el número de filas afectadas en la operación anterior de MySQL
        $affectedRows = mysqli_affected_rows($conexion);
        mysqli_query($conexion, $consulta2);
        $affectedRows += mysqli_affected_rows($conexion);

        return $affectedRows;

        //$dbConexion->close();
    }

    /*****************************************************************************
     *                ELIMINO EL USUARIO EN LA TABLA SEGUN EL ID
     *****************************************************************************/
    public function DeleteUsuario($usuario)
    {

        global $dbConexion, $conexion;

        $id = $usuario['Id'];
        $rol = $usuario['Rol'];
        $idCliente = $usuario['IdCliente'];

        $consulta1 = "DELETE FROM login
                WHERE IdUsuario = $id";

        if ($rol == 1) {
            $consulta2 = "DELETE FROM administrador
                    WHERE id = $idCliente";
        } else if ($rol == 0) {
            $consulta2 = "DELETE FROM especialista 
                    WHERE id = $idCliente";
        }

        mysqli_query($conexion, $consulta1);
        $affectedRows = mysqli_affected_rows($conexion);
        mysqli_query($conexion, $consulta2);
        $affectedRows += mysqli_affected_rows($conexion);
        return $affectedRows;

        //$dbConexion->close();
    }


    /*****************************************************************************
     *                        VERIFICA SI EXISTE EL MAIL
     *****************************************************************************/
    public function existMailUsuario($email)
    {

        global $dbConexion, $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Email FROM login
                    WHERE Email = '$email'";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return true;
        } else {
            return false;
        }

        //$dbConexion->close();
    }

    /*****************************************************************************
     *           VERIFICA SEGUN EL MAIL: RESCATA EL ID, MAIL Y ROL
     *****************************************************************************/
    public function validarEmail($email)
    {

        global $dbConexion, $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT idUsuario, rol FROM login
                    WHERE Email = '$email' ";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado); //Recupera una fila de resultados como un array asociativo
        } else {
            return [];
        }

        //$dbConexion->close();
    }

    /*****************************************************************************
     *           VERIFICA SEGUN EL MAIL: RESCATA EL ID, MAIL Y ROL
     *****************************************************************************/
    public function recuperarDatos($dataReset)
    {
        $id = $dataReset["Id"];
        $rol = $dataReset["Rol"];

        global $dbConexion, $conexion;

        if ($rol == 1) {
            $consulta = "SELECT L.Email, B.telefono AS Telefono 
                    FROM login AS L 
                    LEFT JOIN especialista AS E ON L.idEspecialista = E.id 
                    LEFT JOIN administrador AS B ON L.idAdministrador = B.id 
                    WHERE L.idUsuario = $id";
        } else if ($rol == 0) {
            $consulta = "SELECT L.Email, E.telefono AS Telefono 
                    FROM login AS L 
                    LEFT JOIN especialista AS E ON L.idEspecialista = E.id 
                    LEFT JOIN administrador AS B ON L.idAdministrador = B.id 
                    WHERE L.idUsuario = $id";
        }

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado); //Recupera una fila de resultados como un array asociativo
        } else {
            return [];
        }

        $dbConexion->close();
    }


    /*****************************************************************************
     *       RESETEAR LA CONTRASEÑA SEGUN EL ID Y EMAIL DE LA TABLA LOGIN
     *****************************************************************************/
    public function ResetPassUsers($id, $email, $passOk)
    {
        global $dbConexion, $conexion;

        $passHash = password_hash($passOk, PASSWORD_BCRYPT, ["cost" => 11]);

        $consulta = "UPDATE login
            SET Pass = '$passHash' 
            WHERE IdUsuario = $id AND Email = '$email'";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion) > 0;

        //$dbConexion->close();
    }
}
