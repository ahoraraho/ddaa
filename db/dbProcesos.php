<?php
class dbProcesos
{
    // Insertar registro en la tabla procesos
    public function insertarProceso($proceso)
    {
        global $conexion;

        $entidad = $proceso['entidad'];
        $nomenclatura = $proceso['nomenclatura'];
        $nombreClave = $proceso['nombreClave'];
        $consultas = $proceso['consultas'];
        $integracion = $proceso['integracion'];
        $presentacion = $proceso['presentacion'];
        $buenaPro = $proceso['buenaPro'];
        $valorReferencial = $proceso['valorReferencial'];
        $postores = $proceso['postores'];
        $encargado = $proceso['encargado'];
        $observaciones = $proceso['observaciones'];

        $consulta = "INSERT INTO procesos (entidad, nomenclatura, nombreClave, consultas, integracion, presentacion, buenaPro, valorReferencial, postores, encargado, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssiss", $entidad, $nomenclatura, $nombreClave, $consultas, $integracion, $presentacion, $buenaPro, $valorReferencial, $postores, $encargado, $observaciones);
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

    // Obtener registros de la tabla procesos
    public function obtenerProcesos()
    {
        global $conexion;

        $consulta = "SELECT * FROM procesos";
        $resultado = mysqli_query($conexion, $consulta);

        $procesos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $procesos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $procesos;
    }

    // Seleccionar registro de la tabla procesos
    public function selectProceso($numProceso)
    {
        global $conexion;

        $consulta = "SELECT * FROM procesos WHERE numProceso = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $numProceso);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }

    // Actualizar registro en la tabla procesos
    public function updateProceso($proceso)
    {
        global $conexion;

        $numProceso = $proceso['numProceso'];
        $entidad = $proceso['entidad'];
        $nomenclatura = $proceso['nomenclatura'];
        $nombreClave = $proceso['nombreClave'];
        $consultas = $proceso['consultas'];
        $integracion = $proceso['integracion'];
        $presentacion = $proceso['presentacion'];
        $buenaPro = $proceso['buenaPro'];
        $valorReferencial = $proceso['valorReferencial'];
        $postores = $proceso['postores'];
        $encargado = $proceso['encargado'];
        $observaciones = $proceso['observaciones'];

        $consulta = "UPDATE procesos SET entidad=?, nomenclatura=?, nombreClave=?, consultas=?, integracion=?, presentacion=?, buenaPro=?, valorReferencial=?, postores=?, encargado=?, observaciones=? WHERE numProceso=?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssissi", $entidad, $nomenclatura, $nombreClave, $consultas, $integracion, $presentacion, $buenaPro, $valorReferencial, $postores, $encargado, $observaciones, $numProceso);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        return false;
    }

    // Eliminar registro en la tabla procesos
    public function deleteProceso($numProceso)
    {
        global $conexion;

        $consulta = "DELETE FROM procesos WHERE numProceso = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $numProceso);
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
