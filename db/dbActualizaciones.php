<?php
class dbActualizaciones
{

    // Obtener registros de la tabla procesos
    public function selectNews($tipo)
    {
        global $conexion;

        $consulta = "SELECT A.*, T.nombre AS nombre_actualizacion
                        FROM actualizaciones A
                        INNER JOIN tipoActualizacion T ON A.tipo = T.idActual
                        WHERE T.nombre = '$tipo'";
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

    public function selectActualizaciones()
    {
        global $conexion;

        $consulta = "SELECT  * FROM actualizaciones";
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

    public function selectNew($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM actualizaciones WHERE idActualizacion = ?";
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

    public function insertNew($descripcion, $tipo, $nombreArchivo)
    {
        global $conexion;

        $consulta = "INSERT INTO actualizaciones (descripcion, tipo, archivo) VALUES ('$descripcion', '$tipo', '$nombreArchivo')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function selectTipos()
    {
        global $conexion;

        $consulta = "SELECT * FROM tipoactualizacion";
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
}
