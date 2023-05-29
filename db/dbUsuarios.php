<?php
// require_once '../config/Conexion.php';
class dbUsuarios
{
    /*****************************************************************************
     *                VERIFICA EL EMAIL Y CONTRASEÑA DEL USUARIO
     *****************************************************************************/
    public function loginUsuario($email)
    {
        global $dbConexion, $conexion;

        // $conexion = $dbs->obtenerConexion();

        $consultaEspecialista = "SELECT L.idUsuario, E.Nombre, E.Apellido, L.Email, 0 AS Rol 
                    From login AS L
                    INNER JOIN especialista AS E ON L.idEspecialista = E.id
                    WHERE Email = '$email' AND Estado = 1";

        $consultaAdministrador = "SELECT L.idUsuario, B.Nombre, B.Apellido, B.Cargo, L.Email, 1 AS Rol 
                    From login AS L
                    INNER JOIN administrador AS B ON L.idAdministrador = B.id
                    WHERE Email = '$email' AND Estado = 1";
        $resultadoEspecialista = mysqli_query($conexion, $consultaEspecialista);
        $resultadoAdministrador = mysqli_query($conexion, $consultaAdministrador);
        if (mysqli_num_rows($resultadoEspecialista) > 0) {
            return mysqli_fetch_assoc($resultadoEspecialista);
        } else if (mysqli_num_rows($resultadoAdministrador) > 0) {
            return mysqli_fetch_assoc($resultadoAdministrador);
        } else {
            return false;
        }

        $dbConexion->close();
    }

    /******************************************************************************/
    /*                     VERIFICAR SI LA CONTRASEÑA EN LA MISMA                 */
    /******************************************************************************/
    public function verificarPass($email, $pass)
    {
        global $dbConexion, $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Email, Pass FROM login
                WHERE Email = '$email'";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $resul = mysqli_fetch_assoc($resultado);
            if ($email == $resul["Email"] && password_verify($pass, $resul["Pass"])) {
                return true;
            } else {
                return false;
            }
        }
        $dbConexion->close();
    }

    /******************************************************************************/
    /*        VERIFICAR SI LA CONTRASEÑA EN LA MISMA SEGUN AL ID Y EMAIL          */
    /******************************************************************************/
    public function validarPassReset($id, $email, $oldPass)
    {
        global $dbConexion, $conexion;

        $email = trim(strtolower($email));

        $consulta = "SELECT Email, Pass FROM login
                WHERE idUsuario = '$id' AND Email = '$email'";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $resul = mysqli_fetch_assoc($resultado);
            if ($email == $resul["Email"] && password_verify($oldPass, $resul["Pass"])) {
                return true;
            } else {
                return false;
            }
        }
        $dbConexion->close();
    }


    /*****************************************************************************
     *               SELECCIONO DATOS COMPLETOS DE USUARIO POR ID
     *****************************************************************************/
    public function SelectUsuario($id)
    {
        global $dbConexion, $conexion;

        //EL IFNULL debuelve un resulataso si es que uno de ellos es nulo o vacio
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
                WHERE L.idUsuario = $id";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado); //Recupera una fila de resultados como un array asociativo
        } else {
            return [];
        }
        $dbConexion->close();
    }


    /*****************************************************************************
     *                INSERTAR USUARIO EN LA TABLA SEGUN EL ROL
     *****************************************************************************/
    public function insertUsuario($rol, $usuario)
    {

        global $dbConexion, $conexion;

        if ($rol == 1) { //TRIM()permite eliminar caracteres o espacios específicos del principio,del final o de ambos extremos de una cadena
            $nombre = trim($usuario['Nombre']);
            $apellido = trim($usuario['Apellido']);
            $direccion = trim($usuario['Direccion']);
            $telefono = trim($usuario['Telefono']);
            $cargo = trim($usuario['Cargo']);
            $email = trim(strtolower($usuario['Email']));
            $pass = trim($usuario['Pass']);

            //encriptar la contraseña - cost es el nivel de encriptamiento de la misma
            $passHash = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 11]);

            $consulta = "INSERT INTO administrador (Nombre, Apellido, Cargo, Direccion, Telefono )
        VALUES ('$nombre', '$apellido', '$cargo', '$direccion', '$telefono' );";

            mysqli_query($conexion, $consulta);

            $ultimo_id = mysqli_insert_id($conexion);

            $fechaHoraActual = date('Y-m-d H:i:s');

            $consulta = "INSERT INTO login (Rol, idAdministrador, Email, Pass, Activacion, Estado )
            VALUES ( $rol, $ultimo_id, '$email', '$passHash','$fechaHoraActual', 1 );";

            mysqli_query($conexion, $consulta);
        } else if ($rol == 0) {
            $dni = trim($usuario['DNI']);
            $nombre = trim($usuario['Nombre']);
            $apellido = trim($usuario['Apellido']);
            $cargo = trim($usuario['Cargo']);
            $direccion = trim($usuario['Direccion']);
            $telefono = trim($usuario['Telefono']);
            $email = trim(strtolower($usuario['Email'])); // strtolower : Poner una cadena en minúsculas
            $pass = trim($usuario['Pass']);

            //encriptar la contraseña - cost es el nivel de encriptamiento de la misma
            $passHash = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 11]);

            $consulta = "INSERT INTO especialista (DNI, Nombre, Apellido, Cargo, Direccion, Telefono )
        VALUES ('$dni',  '$nombre', '$apellido', '$cargo', '$direccion', '$telefono' );";

            mysqli_query($conexion, $consulta);

            $ultimo_id = mysqli_insert_id($conexion);

            $fechaHoraActual = date('Y-m-d H:i:s');

            $consulta = "INSERT INTO login (Rol, idAdministrador, Email, Pass, Activacion, Estado )
            VALUES ( $rol, $ultimo_id, '$email', '$passHash','$fechaHoraActual', 1 );";

            mysqli_query($conexion, $consulta);
        }

        return mysqli_affected_rows($conexion);

        // $dbConexion->close();
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
