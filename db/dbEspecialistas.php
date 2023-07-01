<?php

class dbEspecialistas
{

    public function selectEspecialistas()
    {
        global $conexion;
        $consulta = "SELECT * FROM especialista";
        $resultado = mysqli_query($conexion, $consulta);

        $especialistas = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $especialistas[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $especialistas;
    }

    public function selectEspecialista($idEspecialista)
    {
        global $conexion;
        $consulta = "SELECT l.idUsuario, l.rol, l.idAdministrador, l.idEspecialista, l.Email, l.Contrasena, l.Activacion, l.Estado, e.idEspecialista, e.dni, e.nombre, e.apellido, e.cargo, e.direccion, e.telefono
        FROM login l
        LEFT JOIN especialista e ON l.idEspecialista = e.idEspecialista
        WHERE l.idEspecialista = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idEspecialista);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }


    public function insertEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena, $estado)
    {
        global $conexion;
        $passHash = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 11]);
        date_default_timezone_set('America/Lima');
        $fechaHora = date('Y-m-d H:i:s');

        $consulta_especialista = "INSERT INTO especialista (dni, nombre, apellido, cargo, direccion, telefono) VALUES (?, ?, ?, 'Especialista', ?, ?);";
        $stmt_especialista = mysqli_prepare($conexion, $consulta_especialista);

        if ($stmt_especialista) {
            mysqli_stmt_bind_param($stmt_especialista, "sssss", $dni, $nombre, $apellido, $direccion, $telefono);
            mysqli_stmt_execute($stmt_especialista);
            mysqli_stmt_close($stmt_especialista);
        } else {
            // Manejar el error de consulta
            // Ejemplo: error_log(mysqli_error($conexion));
            return 0;
        }

        $consulta_login = "INSERT INTO login (idEspecialista, Email, Contrasena, Activacion, Estado, rol) VALUES (?, ?, ?, ?, 1, 0);";
        $stmt_login = mysqli_prepare($conexion, $consulta_login);

        if ($stmt_login) {
            mysqli_stmt_bind_param($stmt_login, "isss", $idEspecialista, $email, $passHash, $fechaHora);
            mysqli_stmt_execute($stmt_login);
            mysqli_stmt_close($stmt_login);
        } else {
            // Manejar el error de consulta
            // Ejemplo: error_log(mysqli_error($conexion));
            return 0;
        }

        return mysqli_affected_rows($conexion);
    }

    public function updateEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena, $estado)
    {
        global $conexion;
        $passHash = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 11]);
        date_default_timezone_set('America/Lima');
        $fechaHora = date('Y-m-d H:i:s');

        $consulta_especialista = "UPDATE especialista
                                SET dni = ?,
                                nombre = ?,
                                apellido = ?,
                                direccion = ?,
                                telefono = ?
                                WHERE idEspecialista = ?;";
        $stmt_especialista = mysqli_prepare($conexion, $consulta_especialista);

        if ($stmt_especialista) {
            mysqli_stmt_bind_param($stmt_especialista, "sssssi", $dni, $nombre, $apellido, $direccion, $telefono, $idEspecialista);
            mysqli_stmt_execute($stmt_especialista);
            mysqli_stmt_close($stmt_especialista);
        } else {
            // Manejar el error de consulta
            // Ejemplo: error_log(mysqli_error($conexion));
            return 0;
        }

        $consulta_login = "UPDATE login
                        SET Email = ?,
                        Contrasena = ?,
                        Estado = ?,
                        fechaModificacionPass = ?,
                        fechaModificacionData = ?
                        WHERE idEspecialista = ?;";
        $stmt_login = mysqli_prepare($conexion, $consulta_login);

        if ($stmt_login) {
            mysqli_stmt_bind_param($stmt_login, "sssisi", $email, $passHash, $estado, $fechaHora, $fechaHora, $idEspecialista);
            mysqli_stmt_execute($stmt_login);
            mysqli_stmt_close($stmt_login);
        } else {
            // Manejar el error de consulta
            // Ejemplo: error_log(mysqli_error($conexion));
            return 0;
        }

        return mysqli_affected_rows($conexion);
    }

    public function deleteEspecialista($idEspecialista)
    {
        global $conexion;

        $consulta_login = "DELETE FROM login WHERE idEspecialista = ?;";
        $stmt_login = mysqli_prepare($conexion, $consulta_login);

        if ($stmt_login) {
            mysqli_stmt_bind_param($stmt_login, "i", $idEspecialista);
            mysqli_stmt_execute($stmt_login);
            mysqli_stmt_close($stmt_login);
        } else {
            // Manejar el error de consulta
            // Ejemplo: error_log(mysqli_error($conexion));
            return 0;
        }

        $consulta_especialista = "DELETE FROM especialista WHERE idEspecialista = ?;";
        $stmt_especialista = mysqli_prepare($conexion, $consulta_especialista);

        if ($stmt_especialista) {
            mysqli_stmt_bind_param($stmt_especialista, "i", $idEspecialista);
            mysqli_stmt_execute($stmt_especialista);
            mysqli_stmt_close($stmt_especialista);
        } else {
            // Manejar el error de consulta
            // Ejemplo: error_log(mysqli_error($conexion));
            return 0;
        }

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdEspecialista() {
        global $conexion;

        $consulta = "SELECT MAX(idEspecialista) as maxId FROM especialista";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function MayorIdUsuarios() {
        global $conexion;

        $consulta = "SELECT MAX(idUsuario) as maxId FROM login";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    function MayorIdLogin() 
    {
    global $conexion;

    $consulta = "SELECT MAX(idUsuario) as maxId FROM login";
    $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>