<?php
class dbEmpresa
{
    public function selectEmpresas()
    {
        global $conexion;

        $consulta = "SELECT * FROM empresa";
        $resultado = mysqli_query($conexion, $consulta);

        $empresas = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $empresas[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $empresas;
    }


    // Seleccionar un registro de la tabla empresa por su idEmpresa
    public function selectEmpresa($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM empresa WHERE idEmpresa = ?";
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

    //insertar
    public function InsertEmpresa($nombre, $ruc, $telefono, $email, $num_partida, $mipe, $archivos)
    {
        global $conexion;

        $consulta = "INSERT INTO empresa (nombreEmpresa,ruc,telefono,email,numeroPartida,mipe, archivos) 
                    VALUES ('$nombre','$ruc','$telefono','$email','$num_partida','$mipe',$archivos)";


        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);

    }

    // Actualizar registro en la tabla empresa
    public function UpdateEmpresa($id, $nombre, $ruc, $telefono, $email, $num_partida, $mipe, $archivos)
    {
        global $conexion;

        $consulta = "UPDATE empresa
                    SET nombreEmpresa = '$nombre',
                    ruc = '$ruc',
                    telefono = '$telefono',
                    email = '$email',
                    numeroPartida = '$num_partida',
                    mipe = '$mipe',
                    archivos = $archivos
                    WHERE idEmpresa = $id";

                    mysqli_query($conexion, $consulta);

                    return mysqli_affected_rows($conexion);
    }

    // Eliminar registro en la tabla empresa
    public function DeleteEmpresa($id)
    {
        global $conexion;

        $consulta = "DELETE FROM empresa WHERE idEmpresa = $id";
        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

     public function MayorIdEmpresa()
    {
        global $conexion;

        $consulta = "SELECT MAX(idEmpresa) as maxId FROM empresa";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
