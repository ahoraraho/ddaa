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

    public function selectEspecialista($id)
    {
        global $conexion;
        $consulta = "SELECT l.idUsuario, l.rol, l.idAdministrador, l.idEspecialista, l.Email, l.Contrasena, l.Activacion, l.Estado,
        l.fechaModificacionPass, l.fechaModificacionData, e.idEspecialista, e.dni, e.nombre, e.apellido, e.cargo, e.direccion, e.telefono
        FROM login l
        LEFT JOIN especialista e ON l.idEspecialista = e.idEspecialista
        WHERE l.idEspecialista = ?";
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

    public function insertUsuario($usuario)
    {
        global $conexion;
        $passHash = password_hash($usuario['pass'], PASSWORD_BCRYPT, ["cost" => 11]);
        date_default_timezone_set('America/Lima');
        $fechaHora = date('Y-m-d H:i:s');

        $consulta_Especialistas = "INSERT INTO especialista (dni, nombre, apellido, cargo, direccion, telefono)
                                VALUES (?, ?, ?, 'Especialista', ?, ?)";
        $stmt = mysqli_prepare($conexion, $consulta_Especialistas);
        mysqli_stmt_bind_param($stmt, "sssss", $usuario['dni'], $usuario['nombre'], $usuario['apellido'], $usuario['direccion'], $usuario['telefono']);
        mysqli_stmt_execute($stmt);

        $idEspecialista = mysqli_insert_id($conexion); // Obtener el ID generado automáticamente

        $consulta_Login = "INSERT INTO login (rol, idEspecialista, Email, contrasena, activacion, estado)
                        VALUE (0, ?, ?, ?, ?, 1)";
        $stmt = mysqli_prepare($conexion, $consulta_Login);
        mysqli_stmt_bind_param($stmt, "issss", $idEspecialista, $usuario['Email'], $passHash, $fechaHora);
        mysqli_stmt_execute($stmt);

        return mysqli_affected_rows($conexion);
    }


    public function updateEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena)
    {
        global $conexion;

        $consulta_especialista = "UPDATE especialista
                    SET dni = ?,
                    nombre = ?,
                    apellido = ?,
                    direccion = ?,
                    telefono = ?,
                    Email = ?
                    WHERE idEspecialista = ?";

        $stmt = mysqli_prepare($conexion, $consulta_especialista);
        mysqli_stmt_bind_param($stmt, "ssssssi", $dni, $nombre, $apellido, $direccion, $telefono, $email, $idEspecialista);
        mysqli_stmt_execute($stmt);

        $passHash = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 11]);

        $consulta_login = "UPDATE login
                    SET Email = ?,
                    contrasena = ?
                    WHERE idEspecialista = ?";

        $stmt = mysqli_prepare($conexion, $consulta_login);
        mysqli_stmt_bind_param($stmt, "ssi", $email, $passHash, $idEspecialista);
        mysqli_stmt_execute($stmt);

        return mysqli_affected_rows($conexion);
    }


    public function deleteEspecialista($idEspecialista)
    {
        global $conexion;

        $consulta_especialista = "DELETE FROM especialista WHERE idEspecialista = ?";
        $stmt = mysqli_prepare($conexion, $consulta_especialista);
        mysqli_stmt_bind_param($stmt, "i", $idEspecialista);
        mysqli_stmt_execute($stmt);

        $consulta_login = "DELETE FROM login WHERE idEspecialista = ?";
        $stmt = mysqli_prepare($conexion, $consulta_login);
        mysqli_stmt_bind_param($stmt, "i", $idEspecialista);
        mysqli_stmt_execute($stmt);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdEspecialista()
    {
        global $conexion;

        $consulta = "SELECT MAX(idEspecialista) as maxId FROM especialista";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function MayorIdUsuarios()
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