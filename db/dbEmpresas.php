<?php
class dbEmpresa
{
    // Insertar registro en la tabla empresa
    public function insertarEmpresa($empresa)
    {
        global $conexion;

        $nombreEmpresa = $empresa['nombreEmpresa'];
        $ruc = $empresa['ruc'];
        $telefono = $empresa['telefono'];
        $email = $empresa['email'];
        $num_partida = $empresa['numeroPartida'];
        $mipe = $empresa['mipe'];

        $consulta = "INSERT INTO empresa (nombreEmpresa, ruc, telefono, email, numeroPartida, mipe) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssss", $nombreEmpresa, $ruc, $telefono, $email, $num_partida, $mipe);
            if (mysqli_stmt_execute($stmt)) {
                $idInsertado = mysqli_insert_id($conexion);
                mysqli_stmt_close($stmt);
                return $idInsertado;
            } else {
                mysqli_stmt_close($stmt);
                return false;
            }
        }

        return false;
    }

    public function obtenerEmpresas()
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

        // Seleccionar registros de la tabla empresa
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

    // Actualizar registro en la tabla empresa
    public function updateEmpresa($empresa)
    {
        global $conexion;

        $idEmpresa = $empresa['idEmpresa'];
        $nombreEmpresa = $empresa['nombreEmpresa'];
        $ruc = $empresa['ruc'];
        $telefono = $empresa['telefono'];
        $email = $empresa['email'];
        $num_partida = $empresa['numeroPartida'];
        $mipe = $empresa['mipe'];

        $consulta = "UPDATE empresa SET nombreEmpresa=?, ruc=?, telefono=?, email=?, numeroPartida=?, mipe=? WHERE idEmpresa=?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssi", $nombreEmpresa, $ruc, $telefono, $email, $num_partida, $mipe, $idEmpresa);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        return false;
    }

    // Eliminar registro en la tabla empresa
    public function deleteEmpresa($idEmpresa)
    {
        global $conexion;

        $consulta = "DELETE FROM empresa WHERE idEmpresa = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idEmpresa);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
            
            mysqli_stmt_close($stmt);
        }

        return false;
    }

}
?>