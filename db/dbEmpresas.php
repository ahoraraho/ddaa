<?php
class dbEmpresa
{
    // Insertar registro en la tabla empresa
    public function insertarEmpresa($empresa)
{
    global $conexion;

    $nombreEmpresa = trim($empresa['nombreEmpresa']);
    $ruc = trim($empresa['ruc']);
    $telefono = trim($empresa['telefono']);
    $email = trim(strtolower($empresa['email']));
    $numeroPartida = trim($empresa['num_partida']);
    $mipe = trim($empresa['mipe']);

    $consulta = "INSERT INTO empresa (nombreEmpresa, ruc, telefono, email, numeroPartida, mipe) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $nombreEmpresa, $ruc, $telefono, $email, $numeroPartida, $mipe);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($conexion); // Obtener el ID generado automáticamente
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
    public function selectEmpresa($idEmpresa)
    {
        global $conexion;

        $consulta = "SELECT * FROM empresa WHERE idEmpresa = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $idEmpresa);
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

    $consulta = "UPDATE empresa SET nombreEmpresa='$nombreEmpresa', ruc='$ruc', telefono='$telefono', email='$email', numeroPartida='$num_partida', mipe='$mipe' WHERE idEmpresa='$idEmpresa'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        return true;
    } else {
        return false;
    }
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
            mysqli_stmt_close($stmt);

            return true;
        }

        return false;
    }
}
?>