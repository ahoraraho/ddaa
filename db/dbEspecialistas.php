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
    //============================================================================
    //
    //                  Hasta aca todo bien... pero luego XD
    //
    //============================================================================

    public function insertUsuario($idUsuario, $Email, $pass,$idEspecialista,$dni,$nombre, $apellido, $direccion, $telefono)
{
    global $conexion;
    $passHash = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 11]);
    date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú
    $fechaHora = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual en el formato deseado

    $consulta_Especialistas = "INSERT INTO especialistas (dni,nombre,apellido,cargo,direccion,telefono)
                            VALUES ('$dni','$nombre','$apellido','Especialista','$direccion','$telefono')";
    mysqli_query($conexion, $consulta_Especialistas);

    $consulta_Login = "INSERT INTO login (rol,idEspecialista,Email,contrasena,activacion,estado)
                    VALUE (0,'$idEspecialista','$Email','$passHash','$fechaHora',1)";
    mysqli_query($conexion, $consulta_Login);

    return mysqli_affected_rows($conexion);
}


    public function updateEspecialista($idEspecialista, $dni, $nombre, $apellido, $direccion, $telefono, $email, $contrasena)
    {
        global $conexion;
        
        $consulta_especialista = "UPDATE especialista
                    SET dni = '$dni',
                    nombre = '$nombre',
                    apellido = '$apellido',
                    direccion = '$direccion',
                    telefono = '$telefono'
                    WHERE idEspecialista = $idEspecialista";

        mysqli_query($conexion, $consulta_especialista);

        $passHash = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 11]);

        $consulta_login = "UPDATE login
                    SET Email = '$email',
                    contrasena = '$passHash',
                    WHERE idEspecialista = $idEspecialista";

        mysqli_query($conexion, $consulta_login);
        return mysqli_affected_rows($conexion);
    }

    public function deleteEspecialista($idEspecialista)
    {
        global $conexion;

        $consulta_especialista = "DELETE FROM especialista WHERE idEspecialista = $idEspecialista";
        mysqli_query($conexion, $consulta_especialista);

        $consulta_login = "DELETE FROM login WHERE idEspecialista = $idEspecialista";
        mysqli_query($conexion, $consulta_login);

        return mysqli_affected_rows($conexion);
    }

    function MayorIdEspecialista() 
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
