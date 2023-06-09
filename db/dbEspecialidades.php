<?php
class dbEspecialidades
{
    // Insertar registro en la tabla especialidad
    public function insertarEspecialidad($especialidad)
    {
        global $conexion;

        $nombre = $especialidad['nombre'];

        $consulta = "INSERT INTO especialidad (nombre) VALUES (?)";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nombre);
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

    // Obtener todos los registros de la tabla especialidad
    public function obtenerEspecialidades()
    {
        global $conexion;

        $consulta = "SELECT * FROM especialidad";
        $resultado = mysqli_query($conexion, $consulta);

        $especialidades = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $especialidades[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $especialidades;
    }

    // Seleccionar un registro de la tabla especialidad
    public function selectEspecialidad($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM especialidad WHERE idEspecialidad = ?";
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

    // Actualizar registro en la tabla especialidad
    public function updateEspecialidad($especialidad)
    {
        global $conexion;

        $idEspecialidad = $especialidad['idEspecialidad'];
        $nombre = $especialidad['nombre'];

        $consulta = "UPDATE especialidad SET nombre = ? WHERE idEspecialidad = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $nombre, $idEspecialidad);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        return false;
    }

    // Eliminar registro en la tabla especialidad
    public function deleteEspecialidad($idEspecialidad)
    {
        global $conexion;

        $consulta = "DELETE FROM especialidad WHERE idEspecialidad = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idEspecialidad);
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
