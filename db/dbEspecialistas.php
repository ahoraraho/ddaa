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

    public function insertUsuario($idEspecialista ,$dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena, $estado)
    {
        global $conexion;
        $passHash = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 11]);
        date_default_timezone_set('America/Lima');
        $fechaHora = date('Y-m-d H:i:s');

        $consulta_especialista = "INSERT INTO especialista (dni, nombre, apellido, cargo, direccion, telefono) VALUES ('$dni','$nombre','$apellido','Especialista','$direccion','$telefono');";

        mysqli_query($conexion, $consulta_especialista);

        $consulta_login = "INSERT INTO login (idEspecialista, Email, Contrasena, Activacion, Estado, rol) VALUES ($idEspecialista,'$email','$passHash','$fechaHora',1 ,0);";

        mysqli_query($conexion, $consulta_login);

        return mysqli_affected_rows($conexion);

    }


    public function updateEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena, $estado)
    {
        global $conexion;
        $passHash = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 11]);
        date_default_timezone_set('America/Lima');
        $fechaHora = date('Y-m-d H:i:s');

        $consulta_especialista="UPDATE especialista
                                SET dni = '$dni',
                                nombre = '$nombre',
                                apellido = '$apellido',
                                direccion = '$direccion',
                                telefono = '$telefono'
                                WHERE idEspecialista = $idEspecialista;";

        mysqli_query($conexion, $consulta_especialista);

        $consulta_login="UPDATE login
                        SET Email = '$email',
                        Contrasena = '$passHash',
                        Estado = $estado,
                        fechaModificacionPass = '$fechaHora',
                        fechaModificacionData = '$fechaHora'
                        WHERE idEspecialista = $idEspecialista;";
        
        mysqli_query($conexion, $consulta_login);

        return mysqli_affected_rows($conexion);
    }
    

    public function deleteEspecialista($idEspecialista)
    {
        global $conexion;

        $consulta_login="DELETE FROM login WHERE idEspecialista = $idEspecialista;";

        mysqli_query($conexion, $consulta_login);

        $consulta_especialista="DELETE FROM especialista WHERE idEspecialista = $idEspecialista;";

        mysqli_query($conexion, $consulta_especialista);

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
}
?>
